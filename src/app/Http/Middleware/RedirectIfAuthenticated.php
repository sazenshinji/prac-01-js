<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // 管理者ログイン中は 管理者TOPへ
                if ($user->role === 1) {
                    return redirect('/admin/attendance/list');
                }

                // 一般ログイン中は 一般TOPへ
                return redirect('/attendance');
            }
        }

        return $next($request);
    }
}
