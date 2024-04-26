<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class OrderRequest extends FormRequest
{

    public function rules()
    {
        return [
            'company_id' => ['required', 'int'],
            'weight' => ['required', 'decimal:0,2', 'gte:'.Order::MIN_WEIGHT, 'lte:'.Order::MAX_WEIGHT],
            'distance' => ['required', 'int', 'gt:0'],
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }


    public function messages()
    {
        return [
            'company_id.required' => 'Расчет невозможен без компании',
            'weight.required' => 'Расчет невозможен без веса груза',
            'distance.required' => 'Расчет невозможен без дальности перевозки',
        ];
    }

}
