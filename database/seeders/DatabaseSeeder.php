<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
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
        Company::factory(3)->create();
    }
}
