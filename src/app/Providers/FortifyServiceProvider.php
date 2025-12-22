<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\Auth\LoginRequest as CustomLoginRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Fortify の LoginRequest を自作 LoginRequest に差し替え
        $this->app->bind(FortifyLoginRequest::class, CustomLoginRequest::class);
    }

    public function boot(): void
    {
        // ここで LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Actions\Fortify\LoginResponse::class
        );

        Fortify::createUsersUsing(CreateNewUser::class);

        // ログイン画面（URLに応じて role をセット）
        Fortify::loginView(function () {
            if (request()->is('admin/login')) {
                // 管理者ログイン画面から来た
                session(['login_role' => 'admin']);
                return view('auth.adminlogin');
            }

            // 一般ログイン画面
            session(['login_role' => 'user']);
            return view('auth.login');
        });

        // 一般会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン試行制限（429対策：開発中は緩くする）
        RateLimiter::for('login', function (Request $request) {
            // 開発中はかなり緩く（または Limit::none() でもOK）
            return Limit::perMinute(100)->by($request->email . $request->ip());
        });

        // 認証処理 分岐
        Fortify::authenticateUsing(function ($request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            // メール未登録 or パスワード不一致
            if (
                !$user ||
                !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません',
                ]);
            }

            $loginRole = session('login_role');

            // セッション不正（直打ち対策）
            if (!$loginRole) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません',
                ]);
            }

            // 管理者としてログイン画面に来ているのに、一般ユーザーだった場合
            if ($loginRole === 'admin' && $user->role !== 1) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません',
                ]);
            }

            // 一般ユーザーとしてログイン画面に来ているのに、管理者だった場合
            if ($loginRole === 'user' && $user->role !== 0) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません',
                ]);
            }

            // ここまで来たら「正しいユーザー」なのでログイン許可
            return $user;
        });

        //verify-email メール認証誘導画面
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
