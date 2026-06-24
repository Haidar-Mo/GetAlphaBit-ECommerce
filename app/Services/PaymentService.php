<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService
{


    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

    }


    public function createPaymentIntent($amount, $currency = 'usd')
    {
        return PaymentIntent::create([
            'amount' => (int) round($amount * 100),
            'currency' => $currency,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
            ],
        ]);
    }

    public function retrieveIntent($paymentIntentId)
    {
        return PaymentIntent::retrieve($paymentIntentId);
    }
}
