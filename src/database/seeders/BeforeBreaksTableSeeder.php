<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BeforeBreaksTableSeeder extends Seeder
{
    public function run()
    {
        //----2025年11月5日(水)----
        //　承認待ちのためレコードはない。

        //----2025年11月8日(土)----
        //　承認待ちのためレコードはない。

        //----2025年12月1日(月)----
        //　承認待ちのためレコードはない。


        //----2025年12月2日(火)----
        $param = [
            'before_correction_id' => 1,
            'break_index'     => 1,
            'before_break_start'   => Carbon::create(2025, 12, 2, 12, 0, 0),
            'before_break_end'     => Carbon::create(2025, 12, 2, 13, 0, 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('before_breaks')->insert($param);

        //(2025年12月1日(月)渋野 日向子 【代理削除】)
        //この日、休憩を取っていなかったためレコードはない。

    }
}
