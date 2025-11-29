<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BreaktimesTableSeeder extends Seeder
{
    public function run()
    {
        //----2025年11月4日(火)～7日(金)----
        $param = [
            'attendance_id' => 1,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 4, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 4, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 2,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 5, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 5, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 2,
            'break_index'     => 2,
            'break_start'   => Carbon::create(2025, 11, 5, 15, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 5, 15, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 3,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 6, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 6, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 4,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 7, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 7, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月10日(月)～14日(金)----
        $param = [
            'attendance_id' => 5,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 10, 10, 15, 0),
            'break_end'     => Carbon::create(2025, 11, 10, 10, 35, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 5,
            'break_index'     => 2,
            'break_start'   => Carbon::create(2025, 11, 10, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 10, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 5,
            'break_index'     => 3,
            'break_start'   => Carbon::create(2025, 11, 10, 14, 10, 0),
            'break_end'     => Carbon::create(2025, 11, 10, 14, 30, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 6,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 11, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 11, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 7,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 12, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 12, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 8,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 13, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 13, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 9,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 14, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 14, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月17日(月)～21日(金)----
        $param = [
            'attendance_id' => 10,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 17, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 17, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 11,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 18, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 18, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 12,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 19, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 19, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 13,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 20, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 20, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 14,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 21, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 21, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月25日(火)----
        $param = [
            'attendance_id' => 15,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 25, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 25, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月26日(水)----
        $param = [
            'attendance_id' => 19,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 26, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 26, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月27日(木)----
        $param = [
            'attendance_id' => 23,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 27, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 27, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年11月28日(金)----
        $param = [
            'attendance_id' => 27,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 11, 28, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 11, 28, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年12月1日(月)----
        $param = [
            'attendance_id' => 31,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 12, 1, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 12, 1, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年12月2日(火)----
        $param = [
            'attendance_id' => 35,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 12, 2, 12, 15, 0),
            'break_end'     => Carbon::create(2025, 12, 2, 13, 15, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年12月3日(水)----
        $param = [
            'attendance_id' => 39,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 12, 3, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 12, 3, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
        $param = [
            'attendance_id' => 39,
            'break_index'     => 2,
            'break_start'   => Carbon::create(2025, 12, 3, 14, 0, 0),
            'break_end'     => Carbon::create(2025, 12, 3, 14, 10, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年12月4日(木)----
        $param = [
            'attendance_id' => 43,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 12, 4, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 12, 4, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);

        //----2025年12月5日(金)----
        $param = [
            'attendance_id' => 47,
            'break_index'     => 1,
            'break_start'   => Carbon::create(2025, 12, 5, 12, 0, 0),
            'break_end'     => Carbon::create(2025, 12, 5, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('breaktimes')->insert($param);
    }
}
