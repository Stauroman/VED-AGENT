<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use \Symfony\Component\HttpFoundation\Response;

class OrderControllerTest extends TestCase
{
    protected $seed = true;

    public function test_the_index_page_is_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_the_calculate_action_works(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 222,
                'distance' => 33,
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_the_calculate_action_return_distance_min_value_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 30,
                'distance' => -1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'distance' => [
                    'The distance field must be greater than 0.'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_distance_required_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 30,
                'distance' => null,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'distance' => [
                    'Расчет невозможен без дальности перевозки'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_distance_type_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 30,
                'distance' => 'any_string',
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'distance' => [
                    'The distance field must be an integer.',
                    'The distance field must be greater than 0.'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_company_id_required_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => null,
                'weight' => 30,
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'company_id' => [
                    'Расчет невозможен без компании'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_company_exists_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => -1,
                'weight' => 30,
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'company_id' => [
                    'Компания не найдена'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_weight_required_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => null,
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'weight' => [
                    'Расчет невозможен без веса груза'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_weight_type_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 'any_string',
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'weight' => [
                    'The weight field must be an integer.',
                    'The weight field must be greater than or equal to 30.',
                    'The weight field must be less than or equal to 100000.'
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_weight_min_value_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 10,
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'weight' => [
                    'The weight field must be greater than or equal to 30.',
                ]
            ])
            ->etc()
        );
    }

    public function test_the_calculate_action_return_weight_max_value_validation_error(): void
    {
        $response = $this->postJson('api/order/calculate', [
                'company_id' => 1,
                'weight' => 1000000,
                'distance' => 1,
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('errors', [
                'weight' => [
                    'The weight field must be less than or equal to 100000.'
                ]
            ])
            ->etc()
        );
    }
    public function test_the_store_action_save_correctly(): void
    {
        $data = [
            'company_id' => 1,
            'weight' => 30,
            'distance' => 1,
        ];
        $response = $this->postJson('api/order/', $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('orders', $data);
    }

}
