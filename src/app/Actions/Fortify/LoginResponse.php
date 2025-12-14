<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        return redirect(
            $user->role === 1
                ? '/admin/attendance/list'
                : '/attendance'
        );
    }
}
