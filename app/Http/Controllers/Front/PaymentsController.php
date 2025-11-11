<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stripe\StripeClient;



class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {
        $amount = $order->items->sum(function($item){
            return $item->price * $item->quantity;

        });
        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret_key')
        );
      //  dd($stripe);
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
     
        try{
            //create payment
            $payment= new Payment();
            $payment->forceFill([
             'order_id'=>$order->id,
             'amount'=>$paymentIntent->amount,
             'currency'=>$paymentIntent->currency,
             'method'=>'stripe',
             'status'=>'pending',
             'transaction_id'=>$paymentIntent->id,
             'transaction_data' => json_encode($paymentIntent),
            ])->save();
             } catch(QueryException $e){
                 echo $e->getMessage();
                 return;
             }
        return[
            'clientSecret' => $paymentIntent->client_secret,
        ];
       
    
    }

    public function confirm(Request $request,Order $order){
       
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent= $stripe->paymentIntents->retrieve(
        $request->query('payment_intent'),
          []
        );    
        //dd($paymentIntent);
        if($paymentIntent->status == 'succeeded'){
            try{
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'stripe',
                ]);
                $totalPrice = $order->total_price;
                $deliveryPrice = $order->delivery_price;
                $deliveryPercentage = ($deliveryPrice / $totalPrice) * 100;
                $adminPercentage = 10;
                $adminAmount = 
                ($adminPercentage / 100) * ($totalPrice - $deliveryPrice);
                $storeOwnerAmount = $totalPrice - ($deliveryPrice + $adminAmount);
                OrderTransaction::create([
                    'order_id' => $order->id,
                    'transaction_id' => $paymentIntent->id,
                    'total_price' => $totalPrice,
                    'admin_percentage' => $adminAmount,
                    'store_owner_percentage' => $storeOwnerAmount,
                    'delivery_percentage' => $deliveryPrice,
                ]);
                
                //update payment
                $payment= Payment::where('order_id',$order->id)->first();
                $payment->forceFill([
                 'status'=>'completed',
                 'transaction_data'=>json_encode($paymentIntent),
                ])->save();
                 } catch(QueryException $e){
                     echo $e->getMessage();
                     return;
                 }
           event('payment_created',$payment->id);

           return redirect()->route('home',[
             'status'=>'payment-succeed'
           ]);
        }
        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);
     
    }
}
