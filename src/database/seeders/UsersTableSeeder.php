<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => '大谷 翔平',
            'email' => '1234@abcd1',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'), // ハッシュ化して保存
            'role' => 0,                          // 0:一般 1:管理者
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '八村 塁',
            'email' => '1234@abcd2',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'),
            'role' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '石川 佳純',
            'email' => '1234@abcd3',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'),
            'role' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '渋野 日向子',
            'email' => '1234@abcd4',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'),
            'role' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);


        $param = [
            'name' => '長嶋 茂雄',
            'email' => '1234@abcd5',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'),
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '澤 穂希',
            'email' => '1234@abcd6',
            'email_verified_at'  => now(),
            'password' => Hash::make('12345678'),
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('users')->insert($param);
    }
}
