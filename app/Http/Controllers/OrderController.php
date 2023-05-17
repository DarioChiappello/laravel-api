<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ApiResponser;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    use ApiResponser;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->all();
        return $this->successResponse($orders);
    }

    public function store(OrderRequest $request)
    {      
        try
        {
            $validateRequest = $this->orderService->validateRequest($request);
            $order = $this->orderService->processOrder($request->all());
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function show($order)
    {
        $order = $this->orderService->find($order);

        return $this->successResponse($order);
    }

    public function update(OrderRequest $request, $order)
    {
        try
        {
            $validateRequest = $this->orderService->validateRequest($request);
            $order = $this->orderService->processOrder($request->all(), "PUT", $order);
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function destroy($order)
    {
        try
        {
            $order = $this->orderService->delete($order);
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        } 
    }

    public function confirm($order)
    {
        return $order = $this->orderService->confirmOrder($order);
    }

    public function reject($order)
    {
        return $order = $this->orderService->rejectOrder($order);
    }

    public function deliver($order)
    {
        return $order = $this->orderService->deliverOrder($order);
    }
}
