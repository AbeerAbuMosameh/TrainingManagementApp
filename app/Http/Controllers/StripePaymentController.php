<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StripePaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(config('pk_test_51NCpWIC2PxI10leUSKlcbw1SwSOxDtFNmyJkWeLhukQjdGmuI7SgGSXiw3YDiyR5KpGwzQl8Dt2aH7urc7uhVfjX00iD6bkQAu'));

        // Create a PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => 'usd',
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
