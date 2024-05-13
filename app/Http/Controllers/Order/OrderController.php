<?php

namespace App\Http\Controllers\Order;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Repository\Company\CompanyRepository;
use App\Repository\Order\OrderRepository;
use App\Services\Order\CalculateOrderService;
use Illuminate\Http\JsonResponse;
use \Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class OrderController
{
    private CompanyRepository $companyRepository;
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(): View
    {
        return view('order.index', [
            'companies' => $this->companyRepository->getAll(),
            'minWeight' => Order::MIN_WEIGHT,
            'maxWeight' => Order::MAX_WEIGHT,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function calculate(OrderRequest $request, CalculateOrderService $service): JsonResponse
    {
        $amount = $service->calculate($request->validated(), $this->companyRepository);
        return response()->json(['amount' => $amount]);
    }

    /**
     * @throws ValidationException
     */
    public function store(OrderRequest $request, OrderRepository $orderRepository, CalculateOrderService $service): JsonResponse
    {
        $amount = $service->calculate($request->validated(), $this->companyRepository);
        $orderRepository->store($request->validated() + ['amount' => $amount]);
        return response()->json(['message' => 'Расчет сохранен']);
    }
}
