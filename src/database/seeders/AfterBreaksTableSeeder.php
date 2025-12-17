<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AfterBreaksTableSeeder extends Seeder
{
    public function run()
    {
        //----2025年11月5日(水) 大谷 翔平 【修正】----
        $param = [
            'after_correction_id' => 1,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 5, 12, 30, 0),
            'after_break_end'     => Carbon::create(2025, 11, 5, 13, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);
        $param = [
            'after_correction_id' => 1,                              // FK
            'break_index' => 2,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 5, 15, 15, 0),
            'after_break_end'     => Carbon::create(2025, 11, 5, 15, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        //----2025年11月8日(土) 大谷 翔平 【追加】----
        $param = [
            'after_correction_id' => 2,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 8, 12, 15, 0),
            'after_break_end'     => Carbon::create(2025, 11, 8, 12, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        //----2025年12月1日(月) 大谷 翔平 【削除】----
        $param = [
            'after_correction_id' => 3,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 12, 2, 12, 00, 0),
            'after_break_end'     => Carbon::create(2025, 12, 2, 13, 00, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        //----2025年12月2日(火) 大谷 翔平 【代理修正】----
        $param = [
            'after_correction_id' => 4,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 12, 2, 12, 15, 0),
            'after_break_end'     => Carbon::create(2025, 12, 2, 13, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        
        //----2025年11月28日(金) 八村 塁 【修正】----
        $param = [
            'after_correction_id' => 5,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 28, 12, 5, 0),
            'after_break_end'     => Carbon::create(2025, 11, 28, 13, 6, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        //----11月30日(日) 石川 佳純 【追加】----
        $param = [
            'after_correction_id' => 6,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 30, 12, 10, 0),
            'after_break_end'     => Carbon::create(2025, 11, 30, 12, 40, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);

        //----12月1日(月) 渋野 日向子 【代理修正】----
        $param = [
            'after_correction_id' => 7,                              // FK
            'break_index' => 1,                                      // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 30, 12, 0, 0),
            'after_break_end'     => Carbon::create(2025, 11, 30, 13, 1, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('after_breaks')->insert($param);


    }
}
