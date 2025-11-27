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
            'aftercorrection_id' => 1,                                      // FK
            'break_index' => 1,                                             // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 5, 12, 30, 0),
            'after_break_end'     => Carbon::create(2025, 11, 5, 13, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('afterbreaks')->insert($param);
        $param = [
            'aftercorrection_id' => 1,                                      // FK
            'break_index' => 2,                                             // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 5, 15, 15, 0),
            'after_break_end'     => Carbon::create(2025, 11, 5, 15, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('afterbreaks')->insert($param);

        //----2025年11月8日(土) 大谷 翔平 【追加】----
        $param = [
            'aftercorrection_id' => 2,                                      // FK
            'break_index' => 1,                                             // 休憩番号
            'after_break_start'   => Carbon::create(2025, 11, 8, 12, 15, 0),
            'after_break_end'     => Carbon::create(2025, 11, 8, 12, 45, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('afterbreaks')->insert($param);

        //----2025年12月1日(月) 大谷 翔平 【削除】----
        //　　削除の場合、correctionbreaksテーブルの登録はない。

        //----2025年12月2日(火) 大谷 翔平 【代理修正】----
        $param = [
            'aftercorrection_id' => 3,                                      // FK
            'break_index' => 1,                                             // 休憩番号
            'after_break_start'   => Carbon::create(2025, 12, 2, 12, 15, 0),
            'after_break_end'     => Carbon::create(2025, 12, 2, 13, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('afterbreaks')->insert($param);

    }
}
