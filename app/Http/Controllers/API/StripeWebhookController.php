<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $intent = $event->data->object;
                $this->markOrderAsPaid($intent->id);
                break;

            case 'payment_intent.payment_failed':
                $intent = $event->data->object;
                $this->markOrderAsFailed($intent->id);
                break;

            default:
                Log::info('Unhandled Stripe event type: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    private function markOrderAsPaid($paymentIntentId)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($order) {
            $order->update([
                'payment_status' => PaymentStatus::PAID,
                'status' => OrderStatus::PROCESSING,
            ]);
        }
    }

    private function markOrderAsFailed($paymentIntentId)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($order) {
            $order->update([
                'payment_status' => PaymentStatus::FAILED,
            ]);
        }
    }
}