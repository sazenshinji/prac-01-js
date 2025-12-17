<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CorrectionsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'operate_user_id' => 1,    // 大谷 翔平
            'target_user_id' => 1,     // 大谷 翔平
            'attendance_id' => 2,      // 11月5日(水)
            'type' => 1,               // 種別: 1=修正
            'reason' => '間違い修正',   // 申請理由
            'status' => 0,             // 0:申請中
            'approved_at' => null,     // 未承認
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
        $param = [
            'operate_user_id' => 1,        // 大谷 翔平
            'target_user_id' => 1,         // 大谷 翔平
            'attendance_id' => null,       // 未登録
            'type' => 0,                   // 種別: 0=新規追加
            'reason' => '後日入力',         // 申請理由
            'status' => 0,                 // 0:申請中
            'approved_at' => null,         // 未承認
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
        $param = [
            'operate_user_id' => 1,    // 大谷 翔平
            'target_user_id' => 1,     // 大谷 翔平
            'attendance_id' => 31,     // 12月1日(月)
            'type' => 2,               // 種別: 2=削除
            'reason' => '入力ミス',     // 申請理由
            'status' => 0,             // 0:申請中
            'approved_at' => null,     // 未承認
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
        $param = [
            'operate_user_id' => 5,            // (代)長嶋 茂雄
            'target_user_id' => 1,             // 大谷 翔平
            'attendance_id' => 35,             // 12月2日(火)
            'type' => 1,                       // 種別: 1=修正
            'reason' => '修正(代：長嶋茂雄)',   // 申請理由
            'status' => 1,                     // 1:承認済
            'approved_at' => Carbon::create(2025, 12, 5, 9, 0, 0),  // 承認日時
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);

        $param = [
            'operate_user_id' => 2,         // 八村 塁
            'target_user_id' => 2,          // 八村 塁
            'attendance_id' => 28,          // 11月28日(金)
            'type' => 1,                    // 種別: 1=修正
            'reason' => '八村 塁、修正',     // 申請理由
            'status' => 0,                  // 0:申請中
            'approved_at' => null,          // 未承認
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
        $param = [
            'operate_user_id' => 3,             // 石川 佳純
            'target_user_id' => 3,              // 石川 佳純
            'attendance_id' => null,            // 未登録
            'type' => 0,                        // 種別: 0=新規追加
            'reason' => '石川 佳純、後日入力',    // 申請理由
            'status' => 0,                      // 0:申請中
            'approved_at' => null,              // 未承認
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
        $param = [
            'operate_user_id' => 5,             // (代)長嶋 茂雄
            'target_user_id' => 4,              // 渋野 日向子
            'attendance_id' => 34,              // 12月1日(月)
            'type' => 1,                        // 種別: 1=修正
            'reason' => '修正(代：長嶋茂雄)',    // 申請理由
            'status' => 1,                      // 1:承認済
            'approved_at' => Carbon::create(2025, 12, 6, 9, 0, 0),  // 承認日時
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('corrections')->insert($param);
    }
}
