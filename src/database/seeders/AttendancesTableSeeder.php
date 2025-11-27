<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        //----2025年11月1日(土)----
        //----2025年11月2日(日)----
        //----2025年11月3日(祝)----
        //----2025年11月4日(火)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-4',
            'clock_in'   => Carbon::create(2025, 11, 4, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 4, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月5日(水)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-5',
            'clock_in'   => Carbon::create(2025, 11, 5, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 5, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月6日(木)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-6',
            'clock_in'   => Carbon::create(2025, 11, 6, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 6, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月7日(金)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-7',
            'clock_in'   => Carbon::create(2025, 11, 7, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 7, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月8日(土)----
        //----2025年11月9日(日)----
        //----2025年11月10日(月)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-10',
            'clock_in'   => Carbon::create(2025, 11, 10, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 10, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月11日(火)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-11',
            'clock_in'   => Carbon::create(2025, 11, 11, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 11, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月12日(水)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-12',
            'clock_in'   => Carbon::create(2025, 11, 12, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 12, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月13日(木)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-13',
            'clock_in'   => Carbon::create(2025, 11, 13, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 13, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月14日(金)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-14',
            'clock_in'   => Carbon::create(2025, 11, 14, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 14, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);

        //----2025年11月15日(土)----
        //----2025年11月16日(日)----
        //----2025年11月17日(月)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-17',
            'clock_in'   => Carbon::create(2025, 11, 17, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 17, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        //----2025年11月18日(火)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-18',
            'clock_in'   => Carbon::create(2025, 11, 18, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 18, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        //----2025年11月19日(水)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-19',
            'clock_in'   => Carbon::create(2025, 11, 19, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 19, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        //----2025年11月20日(木)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-20',
            'clock_in'   => Carbon::create(2025, 11, 20, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 20, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        //----2025年11月21日(金)----
        $param = [
            'user_id'    => 1,                                  //大谷 翔平
            'work_date'  => '2025-11-21',
            'clock_in'   => Carbon::create(2025, 11, 21, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 11, 21, 18, 0, 0),
            'status'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('attendances')->insert($param);
        //----2025年11月22日(土)----
        //----2025年11月23日(日)----
        //----2025年11月24日(祝)----
        //----2025年11月25日(火)----
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

        //----2025年11月26日(水)----
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

        //----2025年11月27日(木)----
        $param = [
            'user_id'    => 1,
//            'work_date'  => '2025-11-27',
//            'clock_in'   => Carbon::create(2025, 11, 27, 9, 0, 0),
//            'clock_out'  => Carbon::create(2025, 11, 27, 18, 0, 0),
            'work_date'  => '2025-1-27',
            'clock_in'   => Carbon::create(2025, 1, 27, 9, 0, 0),
            'clock_out'  => Carbon::create(2025, 1, 27, 18, 0, 0),
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

        //----2025年11月28日(金)----
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

        //----2025年11月29日(土)----
        //----2025年11月30日(日)----
        //----2025年12月1日(月)----
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

        //----2025年12月2日(火)----
        $param = [
            'user_id'    => 1,
            'work_date'  => '2025-12-2',
            'clock_in'   => Carbon::create(2025, 12, 2, 7, 0, 0),
            'clock_out'  => Carbon::create(2025, 12, 2, 21, 0, 0),
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

        //----2025年12月3日(水)----
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

        //----2025年12月4日(木)----
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

        //----2025年12月5日(金)----
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

        //----2025年12月6日(土)----
        //----2025年12月7日(日)----

    }
}
