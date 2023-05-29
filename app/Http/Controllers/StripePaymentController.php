<?php

namespace App\Http\Controllers;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StripePaymentController extends Controller
{
    public function paymentStripe()
    {
        return view('stripe');
    }

    public function postPaymentStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            // 'amount' => 'required',
        ]);

        $input = $request->except('_token');

        if ($validator->passes()) {
            $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);

                if (!isset($token['id'])) {
                    return redirect()->route('stripe.add.money');
                }

                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => 20.49,
                    'description' => 'wallet',
                ]);

                if($charge['status'] == 'succeeded') {
                    dd($charge);
                    return redirect()->route('addmoney.paymentstripe');
                } else {
                    return redirect()->route('addmoney.paymentstripe')->with('error','Money not add in wallet!');
                }
            } catch (Exception $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error',$e->getMessage());
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error',$e->getMessage());
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error',$e->getMessage());
            }
        }
    }
}
