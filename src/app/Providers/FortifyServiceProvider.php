<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ⭐ ログイン後の遷移分岐登録
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot(): void
    {

        Fortify::createUsersUsing(CreateNewUser::class);

        // 一般ログイン
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 一般会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ⭐ 管理者ログイン
        \Route::get('/admin/login', function () {
            return view('auth.adminlogin');
        })->name('admin.login');

        // ⭐ 認証条件をURLで分岐
        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return null;
            }

            // 管理者ログインURL
            if ($request->is('admin/login')) {
                return $user->role === 1 ? $user : null;
            }

            // 一般ログインURL
            return $user->role === 0 ? $user : null;
        });
    }
}
