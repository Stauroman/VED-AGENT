<?php

namespace App\Http\Controllers\Order;

use App\Repository\Company\CompanyRepository;
use App\Repository\Order\OrderRepository;
use App\Services\Order\CalculateOrderService;

class BaseOrderController
{
    protected OrderRepository $orderRepository;
    protected CompanyRepository $companyRepository;
    protected CalculateOrderService $service;

    public function __construct(OrderRepository $orderRepository, CompanyRepository $companyRepository, CalculateOrderService $service)
    {
        $this->service = $service;
        $this->orderRepository = $orderRepository;
        $this->companyRepository = $companyRepository;
    }
}
