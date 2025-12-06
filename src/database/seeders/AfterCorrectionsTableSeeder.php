<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AfterCorrectionsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'correction_id' => 1,
            'after_work_date'  => '2025-11-5',
            'after_clock_in'   => Carbon::create(2025, 11, 5, 7, 30, 0),
            'after_clock_out'  => Carbon::create(2025, 11, 5, 16, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_corrections')->insert($param);
        $param = [
            'correction_id' => 2,
            'after_work_date'  => '2025-11-8',
            'after_clock_in'   => Carbon::create(2025, 11, 8, 10, 30, 0),
            'after_clock_out'  => Carbon::create(2025, 11, 8, 17, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_corrections')->insert($param);
        $param = [
            'correction_id' => 3,
            'after_work_date'  => '2025-12-1',
            'after_clock_in'   => Carbon::create(2025, 12, 1, 9, 0, 0),
            'after_clock_out'  => Carbon::create(2025, 12, 1, 18, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_corrections')->insert($param);
        $param = [
            'correction_id' => 4,
            'after_work_date'  => '2025-12-2',
            'after_clock_in'   => Carbon::create(2025, 12, 2, 7, 0, 0),
            'after_clock_out'  => Carbon::create(2025, 12, 2, 21, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_corrections')->insert($param);
    }
}
