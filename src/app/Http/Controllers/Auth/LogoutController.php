<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function __invoke()
    {
        $role = Auth::check() ? Auth::user()->role : 0;
        Auth::logout();

        return $role === 1
            ? redirect('/admin/login')
            : redirect('/login');
    }
}
