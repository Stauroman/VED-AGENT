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
    public function calculate(array $data, CompanyRepository $companyRepository): float
    {
        $requestModel = new OrderRequest;
        $validator = Validator::make($data, $requestModel->rules(), $requestModel->messages());
        $validator->validate();
        $company = $companyRepository->getById($data['company_id']);
        return round($data['weight'] * $data['distance'] * $company->cost, 2);
    }
}
