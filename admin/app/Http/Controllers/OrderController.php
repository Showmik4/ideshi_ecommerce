<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\OrderInfo;
use App\Models\Transaction;
use App\Models\ShipmentZone;
use App\Models\DeliveryService;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Sku;
use App\Models\Stock;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\HotDealsProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function list(Request $request)
    {

        $order = OrderInfo::select('order_info.orderId', 'customer.phone', 'orderTotal', 'order_info.created_at', 'order_info.updated_at', 'order_info.lastStatus', 'order_info.print')
                            ->leftjoin('customer', 'customerId', 'fkcustomerId')->orderBy('order_info.orderId', 'DESC');
        return datatables()->of($order)
                ->addColumn('totalpaid', function ($totalpaid) {
                    $totalpaid = Transaction::where('fkorderId', '=', $totalpaid->orderId)->sum('amount');
                    return $totalpaid;
                })
        ->make(true);
    }

    public function create(){

        $zones = ShipmentZone::with('charge')->get();
        $deliveryServices = DeliveryService::all();
        $category = Category::all();
        $brand = Brand::all();
        return view('order.create', compact('zones', 'deliveryServices', 'category', 'brand'));
    }

    public function addToOrder(Request $r): JsonResponse
    {
        $productId = Sku::query()->where('skuId', $r->sku)->first()->fkproductId;
        $product = Product::with(['sku', 'productImages'])->where('status', 'active')->find($productId);

        $batchToOrder = collect(DB::select(DB::raw("
            SELECT batchId, COALESCE(SUM(CASE WHEN stock_record.type = 'in' THEN stock END), 0) - COALESCE(SUM(CASE WHEN stock_record.type = 'out' THEN stock END), 0) as available
            FROM stock_record
            LEFT JOIN sku ON sku.skuId = stock_record.fkskuId
            LEFT JOIN product ON sku.fkproductId = product.productId
            WHERE fkskuId = $r->sku
            GROUP BY batchId ORDER BY available DESC
            ")));

        $batch = $batchToOrder->first();

        if ($batchToOrder->pluck('available')->first() >= 1) {
            $sale_price = Sku::query()->where('skuId', $r->sku)->first()->salePrice ?? Sku::query()->where('skuId', $r->sku)->first()->regular_price;
            $hotdeals = HotDealsProduct::with('hotdeals')->where('fkproductId', $product->productId)->first();
            if (!empty($hotdeals) && $hotdeals->hotdeals->endDate > date('Y-m-d H:i:s') && $hotdeals->hotdeals->status === 'Available') {
                $hot_amount = $hotdeals->hotdeals->percentage;
                $sale_price = round($sale_price - $sale_price * $hot_amount / 100);
            }
            \Cart::session(Auth::user()->userId)->add([
                'id' => $r->sku,
                'name' => $product->productName,
                'price' => $sale_price,
                'quantity' => 1,
                'attributes' => [
                    'batchId' => $batch,
                    'skuId' => $r->sku
                ],
                'associatedModel' => $product,
            ]);

            $cart = view('order.orderProduct')->render();
            $total = \Cart::getTotal();

            return response()->json(['total' => $total, 'cart' => $cart]);
        }

        return response()->json('not availble',404);
    }

    public function removeItem(Request $r): JsonResponse
    {
        if (!empty($r->rowId)) {
            \Cart::session(Auth::user()->userId)->remove($r->rowId);
        } else {
            \Cart::session(Auth::user()->userId)->clear();
        }

        $total =  \Cart::getTotal();
        $cart = view('order.orderProduct')->render();
        return response()->json(['total' => $total, 'cart' => $cart]);
    }

    public function updateQuantity(Request $r): JsonResponse
    {
        if ($r->type === 'inc') {
            \Cart::session(Auth::user()->userId)->update($r->id, [
                'quantity' => 1,
            ]);
        } else {
            \Cart::clearItemConditions($r->id);
            \Cart::session(Auth::user()->userId)->update($r->id, [
                'quantity' => -1,
            ]);
        }

        $total = $this->cartTotal() ;
        $cart = view('order.orderProduct')->render();
        $all = \Cart::getContent();

        return response()->json(['total' => $total, 'cart' => $cart, 'all' => $all]);
    }

    public function discount(Request $r): JsonResponse
    {
        \Cart::session(Auth::user()->userId)->get($r->id)->attributes->discount = $r->discount;

        $total = $this->cartTotal();
        $cart = view('order.orderProduct')->render();
        $all = \Cart::getContent();

        return response()->json(['total' => $total, 'cart' => $cart, 'all' => $all]);
    }

    public function cartTotal()
    {
        $total = 0;
        foreach (\Cart::getContent() as $row) {
            $subtotal = $row->quantity * $row->price - \Cart::get($row->id)->attributes->discount;
            $total += $subtotal;
        }

        return $total;
    }

    public function orderInsert(Request $request): array
    {
        $this->validate($request, [
            'customerId' => 'required',
        ]);

        $order = new OrderInfo();
        $order->fkcustomerId = $request->customerId;
        $order->deliveryService = $request->delivery_company;
        $order->deliveryTime = $request->delivery_date;
        $order->deliveryFee = $request->delivery_charge;
        $order->orderTotal = \Cart::session(Auth::user()->userId)->getTotal();
        $order->saleType = $request->saleType ?? 'shop';
        $order->print = '1';
        $order->note = $request->orderNote ?? null;
        if ((float)$request->paid_amount == \Cart::session(Auth::user()->userId)->getTotal()) {
            $order->paymentStatus = 'paid';
        } elseif ((float)$request->paid_amount > 0) {
            $order->paymentStatus = 'partial';
        } else {
            $order->paymentStatus = 'unpaid';
        }
        if (!empty($request->saleType) && $request->saleType === 'online') {
            $order->lastStatus = 'Created';
        } else {
            $order->lastStatus = 'Delivered';
        }
        $order->save();

        foreach (\Cart::session(Auth::user()->userId)->getContent() as $key => $product) {
            $orderedProduct = new OrderItem();
            $orderedProduct->fkorderId = $order->orderId;
            $orderedProduct->fkskuId = $product->attributes->skuId;
            $orderedProduct->fkBatchId = $product->attributes->batchId->batchId;
            $orderedProduct->price = $product->price;
            $orderedProduct->quantity = $product->quantity;
            $orderedProduct->total = $product->quantity * $product->price - $product->attributes->discount ?? 0;
            $orderedProduct->discount = $product->attributes->discount ?? 0;
            $orderedProduct->save();

            $stockRecordChange = new Stock();
            $stockRecordChange->fkskuId = $product->attributes->skuId;
            $stockRecordChange->batchId = $product->attributes->batchId->batchId;
            $stockRecordChange->order_id = $order->orderId;
            $stockRecordChange->stock = $product->quantity;
            $stockRecordChange->type = 'out';
            $stockRecordChange->identifier = 'sale';

            $stockRecordChange->save();
        }

        $orderStatus = new OrderLog();
        $orderStatus->fkOrderId = $order->orderId;
        $orderStatus->addedBy = Auth::user()->userId ?? '1';
        if (!empty($request->saleType) && $request->saleType === 'online') {
            $orderStatus->status = 'Created';
        } else {
            $orderStatus->status = 'Delivered';
        }
        $orderStatus->note = $request->orderNote ?? null;
        $orderStatus->save();

        if (!empty($request->paid_amount)) {
            /* passing the orderdata to Transaction controller @orderTransaction(#data) method
             * @param array contains instance of Request instance
             * @param array inject $paid amount  to the Request instance
             * @return boolean (true) ? "success" : "failed"
            **/
            $request['orderId'] = $order->orderId;
            TransactionController::orderTransaction($request);
        }

        /*passing the orderdata to Membership controller if user is a member and also add point against him/her during order
        * @param array contains instance of @Orderdata instance
        * @param array inject {$customerId,orderTotal,orderId}  to the Request instance
        * @return boolean (true) ? "success" : "failed"
        **/
//        if (!empty($request->customerId)) {
//            $orderData = [];
//            $orderData['customerId'] = $request->customerId;
//            $orderData['orderTotal'] = \Cart::session(Auth::user()->userId)->getTotal();
//            $orderData['orderId'] = $order->orderId;
//            MembershipController::addPointToMemeber($orderData);
//        }

        \Cart::clear();
        return [$order];
    }

    public function orderUpdate(Request $request): array
    {
        $this->validate($request, [
            'orderId' => 'required',
            'customerId' => 'required',
            'payment_type' => 'required',
            'payment_method' => 'required'
        ]);

        $order = OrderInfo::where('orderId',$request->orderId)->first();
        $orderDeliveryFee = $order->deliveryFee ?? 0;
        $orderTotal = $order->orderTotal;
        $totalAmount = $orderTotal - $orderDeliveryFee;


        foreach (\Cart::session(Auth::user()->userId)->getContent() as $key => $product) {
            // dd($product);
            $order->deliveryFee = $request->deliveryFee;
            $order->orderTotal =  \Cart::session(Auth::user()->userId)->getTotal() + $totalAmount + $request->deliveryFee ;
            $order->save();

            $orderedProduct = new OrderItem();
            $orderedProduct->fkOrderId = $order->orderId;
            $orderedProduct->fkskuId = $product->attributes->skuId;
            $orderedProduct->fkBatchId = $product->attributes->batchId->batchId;
            $orderedProduct->price = $product->price;
            $orderedProduct->quantity = $product->quantity;
            $orderedProduct->total = $product->quantity * $product->price - $product->attributes->discount ?? '0';
            $orderedProduct->discount = $product->attributes->discount ?? '0';
            $orderedProduct->save();

            $stockRecordChange = new Stock();
            $stockRecordChange->fkskuId = $product->attributes->skuId;
            $stockRecordChange->batchId = $product->attributes->batchId->batchId;
            $stockRecordChange->order_id = $order->orderId;
            $stockRecordChange->stock = $product->quantity;
            $stockRecordChange->type = 'out';
            $stockRecordChange->identifier = 'sale';
            $stockRecordChange->save();
        }

        $orderStatus = new OrderLog();
        $orderStatus->fkOrderId = $order->orderId;
        $orderStatus->addedBy = Auth::user()->userId ?? '1';
        if (!empty($request->saleType) && $request->saleType == 'online') {
            $orderStatus->status = 'Created';
        } else {
            $orderStatus->status = 'Delivered';
        }
        $orderStatus->note = $request->orderNote ?? null;
        $orderStatus->save();
        
        if (!empty($request->paid_amount) ) {
            /* passing the orderdata to Transaction controller @orderTransaction(#data) method
             * @param array contains instance of Request instance
             * @param array inject $paid amount  to the Request instance
             * @return boolean (true) ? "success" : "failed"
            **/
            $request['orderId'] = $order->orderId;
            TransactionController::orderTransaction($request);
        }

        else
        {
            Session::flash('success', 'You cannot paid more');
        }
        /* passing the orderdata to Membership and Transaction controller if user is a member and also reedm point during order
         * @param array contains instance of Request instance
         * @param array inject {$paid_amount,payment_type,payment_method}  to the Request instance
         * @return boolean (true) ? "success" : "failed"
         **/
        if (!empty($request->point)) {
            $order->orderTotal = \Cart::session(Auth::user()->userId)->getTotal() + $totalAmount + $request->deliveryFee - (int)$request->point;
//            $orderData = [];
//            $orderData['customerId'] = $request->customerId;
//            $orderData['orderTotal'] =\Cart::session(Auth::user()->userId)->getTotal();
//            $orderData['orderId'] = $order->orderId;
//            $orderData['type'] = 'out';
//            $orderData['point'] = $request->point;
            $request['orderId'] = $order->orderId;
            $request['paid_amount'] = $request->point;
            $request['payment_type'] = 'redeem';
            $request['payment_method'] = 'redeem';
//            MembershipController::addPointToMemeber($orderData);
            TransactionController::orderTransaction($request);
        } else {
            $order->orderTotal = \Cart::session(Auth::user()->userId)->getTotal();
        }
        /*passing the orderdata to Membership controller if user is a member and also add point against him/her during order
        * @param array contains instance of @Orderdata instance
        * @param array inject {$customerId,orderTotal,orderId}  to the Request instance
        * @return boolean (true) ? "success" : "failed"
        **/
//        if (!empty($request->customerId)) {
//            $orderData = [];
//            $orderData['customerId'] = $request->customerId;
//            $orderData['orderTotal'] = $this->cartTotal();
//            $orderData['orderId'] = $order->orderId;
//             MembershipController::addPointToMemeber($orderData);
//        }

        \Cart::session(Auth::user()->userId)->clear();
        return [$order];
    }


    public function details(Request $request, $id)
    {
        $order = OrderInfo::with('customer.user', 'orderedProduct.sku.product', 'orderStatusLogs.author', 'transaction', 'delivery', 'lastStatus')->find($id);
        return view('order.details', compact('order'));
    }

    public function orderStatus(Request $request): JsonResponse
    {
        $order = OrderInfo::with('customer.user', 'orderedProduct.sku.product', 'orderStatusLogs.author', 'transaction', 'delivery', 'lastStatus')->find($request->id);
        $deliveryServices = DeliveryService::all();
        $orderPaidAmount = Transaction::query()->where([['fkorderId', $order->orderId], ['payment_type', '!=', 'return']])->sum('amount');
        $dueAmount = $order->orderTotal - $orderPaidAmount;
        $modal = view('order.orderStatusModal', compact('order', 'deliveryServices', 'dueAmount'))->render();
        return response()->json($modal);
    }

    // public function orderStatusChange(Request $request)

    // {
    //     $id=$request->orderId;
    //     $orderStatusLog =OrderLog::find($id);       
    //     $orderStatusLog->fkOrderId = $request->orderId;
    //     $orderStatusLog->status = $request->status;
    //     $orderStatusLog->note = $request->note;
    //     $orderStatusLog->addedBy = Auth::user()->userId ?? '1';
    //     $orderStatusLog->save();       
    //     if($orderStatusLog)
    //     {
    //         Session::flash('success', 'Product Updated Successfully!');
    //         return redirect()->route('product.show');
    //     }

    //     else
    //     {
    //         Session::flash('error', 'Error Occured!');
    //     }          
       
    // }

    public function orderStatusChange(Request $request): bool
    {
        if ($request->status === 'Created' && $request->currentStatus !== 'Return') 
        {
            abort(422, 'To make a order Created current status must be Cancel state.');
        }
       
        if (Str::contains($request->status, ['Delivered', 'Complete']) === true) {
            if ($request->currentStatus !== 'Return' && $request->currentStatus !== 'Cancel') {
                $orderInfo = OrderInfo::find($request->orderId);
                $orderPaidAmount = Transaction::query()->where([['fkorderId', $request->orderId], ['payment_type', '!=', 'return']])->sum('amount');
                $orderDue = $orderInfo->orderTotal - $orderPaidAmount;
                if ($orderDue > 0) {                  
                    $request['paid_amount'] = $orderDue;
                    TransactionController::orderTransaction($request);
                }

                if ($orderInfo->sale_type === 'Online') {
                
                    $deliveryAdded = $this->deliveryBalanceAdd($request);
                  
                    if ($deliveryAdded === true) {
                        $request['payment_status'] = 'paid';
                        $this->orderStatusUpdate($request);
                    } else {
                        return $deliveryAdded;
                    }
                } else {
                    $request['payment_status'] = 'paid';
                    $this->orderStatusUpdate($request);
                    
                }
            } else {
                abort(422, 'To make a order Delivered current status may not in Return state.');
            }
        }

        
        if (Str::contains($request->status, 'OnDelivery') === true) {
            if ($request->currentStatus !== 'Return' && $request->currentStatus !== 'Cancel' && $request->currentStatus !== 'Delivered' && $request->currentStatus !== 'Complete') {
                if (!empty($request->collectAmount)) {
                    $orderInfo = OrderInfo::find($request->orderId);
                    $orderPaidAmount = Transaction::where([['fkorderId', $request->orderId], ['payment_type', '!=', 'return']])->sum('amount');
                    $orderDue = $orderInfo->orderTotal - (float)$request->collectAmount;

                    $request['paid_amount'] = $request->collectAmount;
                    TransactionController::orderTransaction($request);

                    $request['payment_status'] = $orderDue > 0 ? 'partial' : 'paid';
                    $this->orderStatusUpdate($request);                   
                   
                    
                   
                }
            } else {
                abort(422, "To make a order OnDelivery current status cant be on $request->currentStatus state.");
            }
        }

      
        if (Str::contains($request->status, 'Return') === true) {
            if (Str::contains($request->currentStatus, ['OnDelivery', 'Delivered']) === false) {
                abort(422, 'To make a order Returned current status must be OnDelivery or Delivered state.');
            }

            $orderInfo = OrderInfo::with('transaction', 'customer')->find($request->orderId);
            $orderedProduct = OrderItem::where('fkorderId', $request->orderId)->get();

           
            foreach ($orderedProduct as $product) {
                $skuInfo = [
                    'orderItemId' => $product->order_itemId,
                    'previousQuantity' => $product->quiantity,
                    'returnQuantity' => $product->quiantity,
                    'reason' => null,
                ];
                $return = $this->returnOrder($skuInfo);
               
            }        
            if ($return === true) {
                $this->orderStatusUpdate($request);
            } else {
                abort(422, 'Oh my God!!\r\n The system is facing new problem!');
            }
        }       
        if (Str::contains($request->status, 'Cancel') === true) {
            $orderInfo = OrderInfo::with('transaction', 'customer')->find($request->orderId);
            $orderedProduct = OrderItem::where('fkorderId', $request->orderId)->get();

            foreach ($orderedProduct as $product) {
                $skuInfo = [
                    'orderItemId' => $product->order_itemId,
                    'quiantity' => $product->quiantity,

                ];
                $return = $this->cancelOrder($skuInfo);                
            }

            if ($return === true) {
                $this->orderStatusUpdate($request);
            } else {
                abort(422, 'Oh my God!!\r\n The system is facing new problem!');
            }
        }

        $this->orderStatusUpdate($request);
    }

    /**
     * Change the status an order to new State and create new log.
     *
     * @param $request
     * @param null $paid
     * @return void
     */
    // public function orderStatusUpdate($request, $paid = null)
    // {
        
    //     $orderStatusLog = new OrderLog();
    //     $orderStatusLog->fkOrderId = $request->orderId;
    //     $orderStatusLog->status = $request->status;
    //     $orderStatusLog->note = $request->note;
    //     $orderStatusLog->addedBy = Auth::user()->userId ?? '1';
    //     $orderStatusLog->save();       
    //     $orderInfo = OrderInfo::find($request->orderId);
    //     $orderInfo->lastStatus = $request->status;
    //     if (!empty($request->payment_status)) {
    //         $orderInfo->paymentStatus = $request->payment_status;
    //     }

    //     if (!empty($request->delivery_company)) {
    //         $orderInfo->delivery_service = $request->delivery_company;
    //     }
    //     $orderInfo->save()      
    //     ;         
       
    //     Session::flash('success', 'Product Updated Successfully!');
    //     return redirect()->route('order.show');
      
    // }

    public function orderStatusUpdated(Request $request,$id)
    {
            $orderInfo = OrderInfo::find($request->orderId);
            $orderStatusLog = new OrderLog();
            if($orderInfo->lastStatus != 'Complete')
            {
                $orderStatusLog->fkOrderId = $id;
                $orderStatusLog->status = $request->status;
                $orderStatusLog->note = $request->note;
                $orderStatusLog->addedBy = Auth::user()->userId ?? '1';
                $orderStatusLog->save();       
                
                $orderInfo->lastStatus = $request->status;
                if (!empty($request->payment_status)) {
                $orderInfo->paymentStatus = $request->payment_status;
                }
    
               if (!empty($request->delivery_company)) {
               $orderInfo->delivery_service = $request->delivery_company;
                }
                $orderInfo->save();                 

                Session::flash('success', 'Order Status Updated!');
                return redirect()->route('order.show');
            }

            else
            {
                Session::flash('error', 'You cannot change the status now!');
                return redirect()->route('order.show');
            }    
                   
        }

    /**
     * Return a order product based on input quantity
     * Restock that order item in the database Stock table again.
     *
     * @param $data
     * @return boolean
     */
    private function returnOrder($data): bool
    {
        try {
            $orderedProduct = OrderItem::with('order', 'order.orderStatusLogs')->find($data['orderItemId']);
            DB::transaction(function () use ($data, $orderedProduct) {
                $orderedProduct->quantity = $data['previousQuantity'] - $data['returnQuantity'];
                $orderedProduct->total = ($data['returnQuantity'] - $data['returnQuantity']) * $orderedProduct->price;
                $orderedProduct->returned = $orderedProduct->returned + $data['returnQuantity'];
                if ($data['previousQuantity'] - $data['returnQuantity'] == 0) {
                    $orderedProduct->discount = 0;
                }
                $orderedProduct->save();

                $orderStatus = new OrderLog();
                $orderStatus->fkOrderId = $orderedProduct->fkOrderId;
                $orderStatus->addedBy = Auth::user()->userId ?? '1';
                $orderStatus->status = 'Return';
                $orderStatus->note = 'Return Order';
                $orderStatus->save();

                $stock = new Stock();
                $stock->fkskuId = $orderedProduct->fkskuId;
                $stock->batchId = $orderedProduct->batch_id;
                $stock->order_id = $orderedProduct->fkorderId;
                $stock->stock = $data['returnQuantity'];
                $stock->type = 'in';
                $stock->identifier = 'return_stock';
                $stock->save();

                $orderedProduct->order->orderTotal = OrderItem::query()->where('fkorderId', $orderedProduct->fkorderId)->sum('total');
                $orderedProduct->order->save();
            });
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Cancel an order product based on input quantity
     * Restock that order item in the database Stock table again.
     *
     * @param $data
     * @return boolean
     */

    private function cancelOrder($data): bool
    {
        try {
            $orderedProduct = OrderItem::with('order', 'order.orderStatusLogs')->find($data['orderItemId']);
            DB::transaction(function () use ($data, $orderedProduct) {
                $stock = new Stock();
                $stock->fkskuId = $orderedProduct->fkskuId;
                $stock->batchId = $orderedProduct->batch_id;
                $stock->order_id = $orderedProduct->fkorderId;
                $stock->stock = $data['quiantity'];
                $stock->type = 'in';
                $stock->identifier = 'cancel';
                $stock->save();
            });
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function returnModal(Request $request)
    {
        $orderedProduct = OrderItem::find($request->orderItemId);

        return view('order.returnOrderModal', compact('orderedProduct'));
    }

    public function singleReturn(Request $request): void
    {
        $this->validate(
            $request,
            [
                'rQuantity' => 'numeric|min:1|max:' . $request->previousQuantity,
            ],
            [
                'rQuantity.max' => 'Quantity can be maximum ' . $request->previousQuantity,
            ]
        );

        $request['returnQuantity'] = $request->rQuantity;
        $this->returnOrder($request);
    }

    public function edit($id){
        $zones = ShipmentZone::all();
        $deliveryServices = DeliveryService::all();
        $category = Category::all();
        $brand = Brand::all();
        $order = OrderInfo::with('customer.user', 'orderedProduct.sku.product', 'orderStatusLogs.author', 'transaction', 'delivery', 'lastStatus')->find($id);
        $orderDue = $order->orderTotal - $order->paidAmount();

        return view('order.edit', compact('order','zones', 'deliveryServices', 'category', 'brand','orderDue'));
    }

    public function deliveryBalanceAdd(Request $request): bool
    {
        return true;
    }
}
