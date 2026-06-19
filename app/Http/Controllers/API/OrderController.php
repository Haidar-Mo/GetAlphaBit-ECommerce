<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\FormattedResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use FormattedResponse;

    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkout(CheckOutRequest $request)
    {
        $order = $this->orderService->checkOut(auth()->user(), $request->validated());

        return new OrderResource($order->load('orderItems.product'));
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
}
