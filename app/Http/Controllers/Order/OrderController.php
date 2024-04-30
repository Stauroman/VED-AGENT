<?php

namespace App\Http\Controllers\Order;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use \Illuminate\Contracts\View\View;

class OrderController extends BaseOrderController
{
    public function index(): View
    {
        return view('order.index', ['companies' => $this->companyRepository->getAll(), 'minWeight' => Order::MIN_WEIGHT, 'maxWeight' => Order::MAX_WEIGHT]);
    }

    public function calculate(OrderRequest $request): JsonResponse
    {
        $amount = $this->service->calculate($request->toArray());
        return response()->json(['amount' => $amount]);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $amount = $this->service->calculate($request->toArray());
        $this->orderRepository->store($request->toArray() + ['amount' => $amount]);
        return response()->json(['message' => 'Расчет сохранен']);
    }
}
