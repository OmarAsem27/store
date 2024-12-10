<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', compact('order'));
    }

    public function createStripePaymentIntent(Order $order)
    {
        // dd($order->products);
        $amount = $order->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => round($amount * 100),
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);
        // dd($paymentIntent);
        return [
            'clientSecret' => $paymentIntent->client_secret,
            // [DEV]: For demo purposes only, you should avoid exposing the PaymentIntent ID in the client-side code.
            'dpmCheckerLink' => "https://dashboard.stripe.com/settings/payment_methods/review?transaction_id={$paymentIntent->id}",
        ];
    }


    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->retrieve($request->payment_intent, []);
        // dd($request->all());
        // dd($paymentIntent);
        if ($paymentIntent->status === 'succeeded') {
            $payment = Payment::forceCreate([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'method' => 'stripe',
                'status' => 'completed',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent)
            ])->save();
            event('payment.created', $payment);

            return redirect()->route('home');
        }
    }
}
