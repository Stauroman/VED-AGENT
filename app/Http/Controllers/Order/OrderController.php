<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Order\CalculateOrderService;
use App\Models\{Company, Order};

class OrderController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('order.index', compact('companies'));
    }

    public function calculate(OrderRequest $request)
    {
        $data = $request->validated();
        $amount = CalculateOrderService::calculate($data);
        return $amount
            ? response(['amount' => $amount], 200)
            : response(['message' => 'Не удалось расчитать стоимость'], 500);
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $data['amount'] = CalculateOrderService::calculate($data);
        try {
            Order::create($data);
            $message = 'Расчет сохранен';
            $status = 200;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = 500;
        }
        return response(['message' => $message ?: ''], $status);
    }
}
