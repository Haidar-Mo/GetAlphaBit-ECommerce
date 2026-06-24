<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Traits\FormattedResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use FormattedResponse;

    private $orderService;
    private $paymentService;

    public function __construct(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    public function checkout(CheckOutRequest $request)
    {
        $result = $this->orderService->checkOut(auth()->user(), $request->validated());

        $order = $result['order']->load('orderItems.product');

        return $this->success([
            'order' => new OrderResource($order),
            'client_secret' => $result['client_secret'],
        ]);
    }
    public function history()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order->load('orderItems.product'));
    }

    public function paymentStatus(Order $order)
    {
        if (!$order->stripe_payment_intent_id) {
            return $this->message('messages.no_payment_intent', [], 404, false);
        }

        $intent = $this->paymentService->retrieveIntent($order->stripe_payment_intent_id);

        return $this->success([
            'order_id' => $order->id,
            'payment_intent_status' => $intent->status,
            'amount' => $intent->amount / 100,
            'currency' => $intent->currency,
        ]);
    }
}
