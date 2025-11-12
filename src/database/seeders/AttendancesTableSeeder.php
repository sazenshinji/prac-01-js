<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        //----2025年11月25日----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-25',
            'clock_in'   => Carbon::create(2025, 11, 25, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 25, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,                                  //八村 塁
            'work_date'  => '2025-11-25',
            'clock_in'   => Carbon::create(2025, 11, 25, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 25, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,                                  //石川 佳純
            'work_date'  => '2025-11-25',
            'clock_in'   => Carbon::create(2025, 11, 25, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 25, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,                                  //渋野 日向子
            'work_date'  => '2025-11-25',
            'clock_in'   => Carbon::create(2025, 11, 25, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 25, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年11月26日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-11-26',
            'clock_in'   => Carbon::create(2025, 11, 26, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 26, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-11-26',
            'clock_in'   => Carbon::create(2025, 11, 26, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 26, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-11-26',
            'clock_in'   => Carbon::create(2025, 11, 26, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 26, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-11-26',
            'clock_in'   => Carbon::create(2025, 11, 26, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 26, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年11月27日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-11-27',
            'clock_in'   => Carbon::create(2025, 11, 27, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 27, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-11-27',
            'clock_in'   => Carbon::create(2025, 11, 27, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 27, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-11-27',
            'clock_in'   => Carbon::create(2025, 11, 27, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 27, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-11-27',
            'clock_in'   => Carbon::create(2025, 11, 27, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 27, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年11月28日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-11-28',
            'clock_in'   => Carbon::create(2025, 11, 28, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 28, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-11-28',
            'clock_in'   => Carbon::create(2025, 11, 28, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 28, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-11-28',
            'clock_in'   => Carbon::create(2025, 11, 28, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 28, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-11-28',
            'clock_in'   => Carbon::create(2025, 11, 28, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 28, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年12月1日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-1',
            'clock_in'   => Carbon::create(2025, 12, 1, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 1, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-12-1',
            'clock_in'   => Carbon::create(2025, 12, 1, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 1, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-12-1',
            'clock_in'   => Carbon::create(2025, 12, 1, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 1, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-12-1',
            'clock_in'   => Carbon::create(2025, 12, 1, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 1, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);



        //----2025年12月2日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-2',
            'clock_in'   => Carbon::create(2025, 12, 2, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 2, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-12-2',
            'clock_in'   => Carbon::create(2025, 12, 2, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 2, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-12-2',
            'clock_in'   => Carbon::create(2025, 12, 2, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 2, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-12-2',
            'clock_in'   => Carbon::create(2025, 12, 2, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 2, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年12月3日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-3',
            'clock_in'   => Carbon::create(2025, 12, 3, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 3, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-12-3',
            'clock_in'   => Carbon::create(2025, 12, 3, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 3, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-12-3',
            'clock_in'   => Carbon::create(2025, 12, 3, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 3, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-12-3',
            'clock_in'   => Carbon::create(2025, 12, 3, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 3, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);


        //----2025年12月4日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-4',
            'clock_in'   => Carbon::create(2025, 12, 4, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 4, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-12-4',
            'clock_in'   => Carbon::create(2025, 12, 4, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 4, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-12-4',
            'clock_in'   => Carbon::create(2025, 12, 4, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 4, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-12-4',
            'clock_in'   => Carbon::create(2025, 12, 4, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 4, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);



        //----2025年12月5日----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-5',
            'clock_in'   => Carbon::create(2025, 12, 5, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 5, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 2,
            'work_date'  => '2025-12-5',
            'clock_in'   => Carbon::create(2025, 12, 5, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 5, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 3,
            'work_date'  => '2025-12-5',
            'clock_in'   => Carbon::create(2025, 12, 5, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 5, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id'    => 4,
            'work_date'  => '2025-12-5',
            'clock_in'   => Carbon::create(2025, 12, 5, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 5, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

    }
}
