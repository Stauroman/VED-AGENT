<?php

namespace App\Services\Order;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Company;
use App\Repository\Company\CompanyRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CalculateOrderService
{
    /**
     * @throws ValidationException
     */
    public function calculate($data): float
    {
        $requestModel = new OrderRequest;
        $validator = Validator::make($data, $requestModel->rules(), $requestModel->messages());
        $validator->validate();
        $company = (new CompanyRepository(new Company))->getById($data['company_id']);
        return round($data['weight'] * $data['distance'] * $company->cost, 2);
    }
}
