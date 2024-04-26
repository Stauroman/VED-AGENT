<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'int', 'exists:companies,id'],
            'weight' => ['required', 'int', 'gte:'.Order::MIN_WEIGHT, 'lte:'.Order::MAX_WEIGHT],
            'distance' => ['required', 'int', 'gt:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => 'Расчет невозможен без компании',
            'company_id.exists' => 'Компания не найдена',
            'weight.required' => 'Расчет невозможен без веса груза',
            'distance.required' => 'Расчет невозможен без дальности перевозки',
        ];
    }
}
