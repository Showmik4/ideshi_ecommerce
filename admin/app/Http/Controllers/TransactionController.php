<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderInfo;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public static function orderTransaction($request)
    {
        // dd($request->all());
        $order=OrderInfo::query()->where('orderId',$request->orderId)->first();
      
        $currentTotal=Transaction::query()->where('fkorderId',$request->orderId)->sum('amount');

        $newTotal=$currentTotal + $request->paid_amount;     
        
        // try {
            $orderTranscation = new Transaction();
            if($order->orderTotal >= $newTotal)
            {
                $orderTranscation->fkorderId = $request->orderId;
                $orderTranscation->amount = $request->paid_amount ?? '0';
                $orderTranscation->payment_type = $request->paymentType ?? 'normal';
                $orderTranscation->advance_note = $request->note ?? null;
                $orderTranscation->method = $request->paymentMethod ?? 'Cash';
                $orderTranscation->reciveBy = Auth::user()->userId ?? 1;
                $orderTranscation->save();

                Session::flash('success', 'Payment Succesful');
                return true;
            }
            else
            {
                Session::flash('success', 'You cannot paid more');
               return false;
            }
          
        // } catch (\Throwable $th) {
        //     throw $th;
        // }

        // return true;
    }

    /**
     * Receive an orderID.
     *
     * @param int contains orderID
     *
     * @return object with view (modal) contains payment form.
     */
    public function addPayment(Request $request)
    {
        $orderInfo = OrderInfo::with('customer', 'transaction')->find($request->orderId);

        return view('transaction.paymentModal', compact('orderInfo'));
    }

    /**
     * Receive payment information from order page
     * after validating data passing to @orderTransaction(#data).
     *
     * @param array contains instance of Request instance
     *
     * @return array with message and status code
     */
    public function savePayment(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            // 'paymentMethod' => 'required',
        ]);
        $request['paid_amount'] = $request->amount;
        $transaction = $this->orderTransaction($request);
        if ($transaction === true) {
            return response()->json(['message' => 'payment successfull', 200]);
        } 
        else {
            return response()->json(['message' => 'You Cannot Paid more', 400]);
        }
    }
}
