<?php

namespace App\Services\Order;

use App\Models\Company;

class CalculateOrderService
{
    public static function calculate($data): float|null
    {
        $cost = Company::find($data['company_id'])?->cost;
        return $cost ? round($data['weight'] * $data['distance'] * $cost, 2) : null;
        //todo в идеале использовать паттерн Money Фраулера для избежания проблем с дробными значениями
    }

}
