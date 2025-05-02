<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialYearSeeder extends Seeder
{
    public function run()
    {
        $startYear = 2024;
        $currentYear = Carbon::now()->year;

        for ($i = 0; $i < 10; $i++) {
            $year = $startYear + $i;

            DB::table('financial_year')->insert([
                'year' => $year,
                'is_current' => $year == $currentYear ? 1 : 0,
            ]);
        }
    }
}
