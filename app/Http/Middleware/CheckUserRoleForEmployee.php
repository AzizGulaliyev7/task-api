<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionDenied;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRoleForEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 'admin') {
            throw new PermissionDenied("Admin rolidagi foydalanuvchilar xodimlar ustida ammallar bajara olmaydi!");
        }

        return $next($request);
    }
}
