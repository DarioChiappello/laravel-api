<?php

namespace App\Services;

use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Services\OrderDetailService;

class OrderService extends BaseService
{

    private $orderDetailService;
    
    public function __construct(Order $order, OrderDetailService $orderDetailService)
    {
        parent::__construct($order);
        $this->orderDetailService = $orderDetailService;
    }

    public function processOrder($data, $method = "POST", $id = NULL)
    {
        $order = $method === "POST" ? $this->create($data) : $this->update($id, $data);

        $orderDetail = $method === "POST" ? $this->orderDetailService->storeDetail($order->id, $data['detail']): $this->orderDetailService->storeDetail($order->id, $data['detail'], "PUT");

        return $order;
    }

    public function all()
    {
        $orders = Order::with(['client', 'details', 'getProducts'])->get();
        return $orders;
    }

    public function find($id)
    {
        return $order = Order::with(['client', 'details', 'getProducts'])->where('id', $id)->first();
    }

    public function confirmOrder($id)
    {
        $orderConfirm = Order::where('id', $id)->update(['confirmed' => 1]);
        return $order = Order::where('id', $id)->first();
    }

    public function rejectOrder($id)
    {
        $orderReject = Order::where('id', $id)->update(['confirmed' => 0]);
        return $order = Order::where('id', $id)->first();
    }

    public function deliverOrder($id)
    {
        $orderDeliver = Order::where('id', $id)->update(['delivered' => 1]);
        return $order = Order::where('id', $id)->first();
    }
}
