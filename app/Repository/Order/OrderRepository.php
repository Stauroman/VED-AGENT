<?php

namespace App\Repository\Order;

use App\Models\Order;
use App\Repository\AbstractRepository;
use App\Repository\Interfaces\BaseRepositoryInterface;


class OrderRepository extends AbstractRepository implements BaseRepositoryInterface
{
    protected Order $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }
}
