<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    protected static array $data = [
        'Энергия' => 25,
        'Кит' => 27,
        'Деловые линии' => 21,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$data as $company => $cost) {
            DB::table('companies')->insert([
                'name' => $company,
                'cost' => $cost,
                'created_at' => ($now = Carbon::now()),
                'updated_at' => $now,
            ]);
        }
    }
}
