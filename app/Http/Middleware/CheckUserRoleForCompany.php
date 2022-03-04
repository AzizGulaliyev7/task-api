<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionDenied;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUserRoleForCompany
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
        $user = Auth::user();
        if (($user->role == 'company') && DB::table('companies')->whereNull('deleted_at')->where('user_id', $user->id)->exists()) {
            throw new PermissionDenied("Ushbu foydalanuvchida allaqachon korxona mavjud!");
        }

        return $next($request);
    }
}
