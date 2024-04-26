<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Stock;
use Darryldecode\Cart\Cart;
use App\Models\ShipmentZone;
use App\Models\Address;
use App\Models\OrderInfo;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view_product_details($id)
    {
        $product_details = Product::with('sku','productDetails','productImages')->where('productId', $id)->first();   
        $similar_products = Product::with('sku')->where('fkCategoryId', $product_details->fkCategoryId)->get(); 
        $variations= Sku::with('variationRelation', 'variationRelation.variation')->where('fkProductId', $id)->get();
        session()->push('recentProductIds', $id);
        $recentProducts = Product::query()->whereIn('productId', Session::get('recentProductIds'))->get();        
        return view('product_details',compact('product_details','similar_products','variations','recentProducts'));
    }  

    public function view_cart()
    {
        // $shippingZones = ShipmentZone::all();
        return view('cart');

    }

    public function addToCart(Request $request): JsonResponse
    {
        $stockIn=Stock::where('fkskuId',$request->sku)->where('type', 'in')->sum('stock');
        $stockOut=Stock::where('fkskuId',$request->sku)->where('type', 'out')->sum('stock');
        $stockAvailable = $stockIn-$stockOut;
        $quantity=$request->quantity;
        if ($stockAvailable >= $quantity) 
        {
            $sku =Sku::findOrfail($request->sku);
            //$product=Product::with(['sku','images'])->where('status','active')->findOrFail($productId)->first();
            $product = $sku->product()->first();
            $productImage = $sku->variationImages()->first();
            $variations=[];
            foreach($sku->variationRelation as $variation)
            {
                $variations[] = $variation->variationDetailsdata;
            }
            // $hotDeal = $sku->product->hotdealProducts->where('hotdeals.status', 'Available')->where('hotdeals.startDate', '<=', date('Y-m-d H:i:s'))->where('hotdeals.endDate', '>=', date('Y-m-d H:i:s'))->where('hotdeals.percentage', '>', 0)->first();

            $afterDiscountPrice = null;
            if (!empty($hotDeal) && !empty($sku->discount))
            {
                $percentage = $hotDeal->hotdeals->percentage;
                $afterDiscountPrice = ($sku->regularPrice) - (($sku->regularPrice)*$percentage)/100;
            }

            if (!empty($hotDeal) && empty($sku->discount)){
                $percentage = $hotDeal->hotdeals->percentage;
                $afterDiscountPrice = ($sku->regularPrice) - (($sku->regularPrice)*$percentage)/100;
            }

            if(empty($hotDeal) && !empty($sku->discount))
            {
                $afterDiscountPrice = $sku->salePrice;
            }

            if(!empty($sku->salePrice))
            {
                $afterDiscountPrice = $sku->salePrice;
            }

            \Cart::add(array(
                'id' => $sku->skuId,
                'name' => $sku->product->productName,
                'price' => $afterDiscountPrice ? $afterDiscountPrice : $sku->regularPrice ?? '0',
                'quantity' =>$quantity,
                'attributes' => array(
                    'variations' => $variations,
                    'image' => $sku->product->featureImage,
                    'regularPrice' => $sku->regularPrice,
                    'discount' => $sku->discount,
                    'selectedColor' => $request->input('selectedColor'), 
                    'selectedSize' => $request->input('selectedSize'),
                ),
                'associatedModel' => $product, $productImage
            ));

            $cartPage= view('cart')->render();
            $cart=\Cart::getContent();
            $cartQuantity=\Cart::getContent()->count();
            $total = number_format(\Cart::getSubTotal());

            if(Session::has('promoCode')){
                $cuponAmount =  Session::get('promoCode');

                $increasediscount = (\Cart::getSubTotal() * $cuponAmount) / 100;
                $newTotal = \Cart::getSubTotal() - $increasediscount;

                Session::put('discountAmount', $increasediscount);
                Session::put('sub', $newTotal);
            }
            return response()->json(['cartPage'=>$cartPage, 'cart'=>$cart, 'cartQuantity'=>$cartQuantity, 'total'=>$total],200);
        }

        return response()->json(['Quantity'=>'Stock not available'],400);
    }

    public function getSubtotal(Request $request)
    {
        $subtotal = \Cart::getSubTotal();
        return response()->json(['subtotal' => $subtotal]);
    }

    public function updateCart(Request $request): JsonResponse
    {
        $stockIn=Stock::where('fkskuId',$request->sku)->where('type', 'in')->sum('stock');
        $stockOut=Stock::where('fkskuId',$request->sku)->where('type', 'out')->sum('stock');
        $stockAvailable = $stockIn-$stockOut;
        $quantity=(int)$request->quantity;
        if ($stockAvailable >= $quantity) 
            {
            \Cart::update($request->sku,[
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity,
                )
            ]);
            // $cartPage= view('layouts.partials.cart')->render();
            if(Session::has('sub') && Session::has('discountAmount') && Session::has('promoCode'))
            {
                $discountAmount = (\Cart::getSubTotal() * Session::get('promoCode')) / 100;
                $newTotal = \Cart::getSubTotal() - $discountAmount;
                Session::put('sub', $newTotal);
                Session::put('discountAmount', $discountAmount);
                // dd( Session::get('sub'));
            }

            $cartPage = \Cart::getContent();
            $cartQuantity = \Cart::getContent()->count();
            $total = number_format(\Cart::getSubTotal());
            $subtotal = number_format(\Cart::getSubTotal());
            $grandtotal = number_format(\Cart::getTotal());
            return response()->json([
                'cart' => $cartPage,
                'cartQuantity' => $cartQuantity,
                'total' => $total,
                'subtotal' => $subtotal,
                'grandtotal' => $grandtotal,
            ], 200);
        }
        return response()->json(['Quantity'=>'Stock not available'],400);
    }

    public function clearCart(Request $request): JsonResponse
    {
        \Cart::clear();
        return response()->json();
    }


    public function removeCartItem(Request $request): JsonResponse
    {
        \Cart::remove($request->sku);
        $condition=\Cart::getCondition('coupon');
        if(!empty($condition)){
            $conditionSku=$condition->getAttributes();
            if ($conditionSku['sku'] == $request->skuId) 
            {
                \Cart::clearCartConditions();
            }
        }
        if (\Cart::isEmpty()) 
        {
            \Cart::clear();
            \Cart::clearCartConditions();
        }
        if(Session::has('sub') && Session::has('discountAmount') && Session::has('promoCode'))
        {
            $discountAmount = (\Cart::getSubTotal() * Session::get('promoCode')) / 100;
            $newTotal = \Cart::getSubTotal() - $discountAmount;
            Session::put('sub', $newTotal);
            Session::put('discountAmount', $discountAmount);
        }
        $cartQuantity=\Cart::getContent()->count();
        $cart=\Cart::getContent();
        $subTotal =\Cart::getSubTotal();
        $grandTotal =\Cart::getTotal();
        return response()->json(['cartQuantity'=>$cartQuantity, 'cart'=>$cart, 'subTotal'=>$subTotal, 'grandTotal'=>$grandTotal],200);
    }

    public function remove_CartItem($id)
    {
        \Cart::remove($id);
        return redirect()->back();
    }

    public function shipmentZoneCharge(Request $request): JsonResponse
    {
        $shipmentZoneCharge = ShipmentZone::where('shipmentZoneId', $request->zone)->first()->charge->deliveryFeeInside;
        $shipmentZoneId = ShipmentZone::where('shipmentZoneId', $request->zone)->first()->shipmentZoneId;
        Session::put('zoneCharge', $shipmentZoneCharge);
        Session::put('zoneChargeId', $shipmentZoneId);
        $cartSubTotal = \Cart::getSubTotal();
        return response()->json(['zoneCharge'=>$shipmentZoneCharge, 'cartSubTotal'=>$cartSubTotal]);
    }

    public function checkout(Request $request)
    {
        // $request->validate
        // ([
        //         'firstName' => 'required',
        //         'email' => 'required',
        //         'phone' => 'required',
        //         'billingAddress' => 'required',
        //         'payment' => 'required',
        // ]);

        if (!Auth::user()) {
            $customer = Customer::where('phone', $request->phone)->first();
        }
        if (Auth::user()) {
            $customer = Customer::where('fkuserId', Auth::user()->userId)->first();
        }

        if (!Auth::user() && empty($customer)) 
        {
            $guestUser =  new User();
            $guestUser->firstName = $request->firstName;
            $guestUser->lastName = $request->lastName;
            $guestUser->email = $request->email;
            //$guestUser->password = Hash::make('123456');
            $guestUser->password = bcrypt($request->password);
            $guestUser->fkuserTypeId = 2;
            $guestUser->save();

            $customer = new Customer();
            $customer->fkuserId = $guestUser->userId;
            $customer->phone = $request->phone;
            $customer->status = 'active';
            $customer->save();

            $address = new Address();
            $address->billingAddress = $request->billingAddress;
            if ($request->shipping == 'on') {
                $address->shippingAddress = $request->diffshippingAddress;
            } else {

                $address->shippingAddress = $request->billingAddress;
            }
            $address->fkcustomerId  = $customer->customerId;
            $address->fkshipment_zoneId  = $request->fkshipment_zoneId;
            $address->save();
        }
        if (Auth::user() && !empty($customer)) 
        {
            $address = $customer->address()->first();
            if (empty($address)) {
                $address = new Address();
                $address->billingAddress = $request->billingAddress;

                if ($request->shipping == 'on') {
                    $address->shippingAddress = $request->diffshippingAddress;
                } else {
                    $address->shippingAddress = $request->billingAddress;
                }
                $address->save();
            }
        }

        // $deliveryFee = 0;
        // $deliveryFee += ShipmentZone::where('shipmentZoneId', $request->shipmentZone)->first()->charge()->first()->deliveryFeeInside;

        if (\Cart::getContent()->count() > 0) 
        {
            $order = new OrderInfo();
            $order->fkcustomerId = $customer ? $customer->customerId : '';
            // $order->note = $request->note;
            // $order->deliveryFee = $deliveryFee;
            if (Session::has('discountAmount')) {
                $order->discount = Session::get('discountAmount');
            }
            if (Session::has('sub')) {
                $order->orderTotal = Session::get('sub');
            }
            if (Session::has('promoId')) {
                $order->promoId = Session::get('promoId');
            }
            if (!Session::has('sub')) {
                $order->orderTotal = \Cart::getSubTotal()+$request->shipping_cost;
            }
            $order->paymentStatus = 'unpaid';
            $order->lastStatus = 'Pending';
            $order->paymentType = $request->payment;
            $order->deliveryFee = $request->shipping_cost;
            $order->save();

            $order_status_log = new OrderLog();
            $order_status_log->fkOrderId = $order->orderId;
            $order_status_log->status = 1;
            // $order_status_log->note = $order->note;
            $order_status_log->save();

            foreach (\Cart::getContent() as $cartData) 
            {
                $q = $cartData['quantity'];

                $order_item = new OrderItem();
                $order_item->fkorderId = $order->orderId;
                $order_item->quantity = $cartData->quantity;
                $order_item->price = $cartData->price;
                $order_item->total = $cartData->price * $cartData->quantity;
                $order_item->discount = $cartData->discount;
                $order_item->fkskuId = $cartData->id;
                $order_item->save();

                $inStock = Stock::where('fkskuId', $cartData->id)->where('type', 'in')->sum('stock');
                $outStock = Stock::where('fkskuId', $cartData->id)->where('type', 'out')->sum('stock');
                $stockAvailable = $inStock - $outStock;

                if($q > $stockAvailable){
                    $q = $stockAvailable;
                }
                if($q <= $stockAvailable){
                    $stock_record = new Stock();
                    $stock_record->batchId = '0';
                    $stock_record->fkskuId = $cartData->id;
                    $stock_record->order_id = $order->orderId;
                    $stock_record->stock = $q;
                    $stock_record->type = 'out';
                    $stock_record->identifier = 'sale';
                    $stock_record->save();
                }
            }
            \Cart::clear();
        }
        Session::flash('success', 'Order placed successfully');
        if (Session::has('discountAmount')) {
            Session::forget('discountAmount');
        }
        if (Session::has('sub')) {
            Session::forget('sub');
        }
        if (Session::has('zoneChargeId')) 
        {
            Session::flash('zoneChargeId');
            Session::flash('zoneCharge');
        }
        return redirect('/');
    }

  
}
