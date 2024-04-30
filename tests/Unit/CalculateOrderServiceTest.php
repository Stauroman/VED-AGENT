<?php

namespace Tests\Unit;

use App\Services\Order\CalculateOrderService;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CalculateOrderServiceTest extends TestCase
{
    protected $seed = true;

    public function test_that_calculate_returns_float(): void
    {
        $data = [
            'company_id' => 1,
            'weight' => 35,
            'distance' => 33,
        ];
        $this->assertIsFloat((new CalculateOrderService)->calculate($data));
    }

    public function test_that_calculate_throw_validation_exception_company_exists_error(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Компания не найдена');
        $data = [
            'company_id' => -1,
            'weight' => 34,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_company_id_required_error(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Расчет невозможен без компании');
        $data = [
            'company_id' => null,
            'weight' => 34,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_company_id_type_error(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The company id field must be an integer.');
        $data = [
            'company_id' => 'string',
            'weight' => 34,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_weight_required(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Расчет невозможен без веса груза');
        $data = [
            'company_id' => 1,
            'weight' => null,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_weight_type(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The weight field must be an integer. (and 2 more errors)');
        $data = [
            'company_id' => 1,
            'weight' => 'string',
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_weight_min_value(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The weight field must be greater than or equal to 30.');
        $data = [
            'company_id' => 1,
            'weight' => 10,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_weight_max_value(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The weight field must be less than or equal to 100000.');
        $data = [
            'company_id' => 1,
            'weight' => 1000000,
            'distance' => 33,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_distance_required(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Расчет невозможен без дальности перевозки');
        $data = [
            'company_id' => 1,
            'weight' => 40,
            'distance' => null,
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_distance_type(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The distance field must be an integer. (and 1 more error)');
        $data = [
            'company_id' => 1,
            'weight' => 40,
            'distance' => 'string',
        ];
        (new CalculateOrderService)->calculate($data);
    }

    public function test_that_calculate_throw_validation_exception_distance_min_value(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The distance field must be greater than 0.');
        $data = [
            'company_id' => 1,
            'weight' => 40,
            'distance' => -1,
        ];
        (new CalculateOrderService)->calculate($data);
    }

}
