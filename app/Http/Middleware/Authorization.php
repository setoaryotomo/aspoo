<?php

namespace App\Http\Middleware;

use App\Modules\User\Service\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission_code)
    {
        $isHavePermission = UserService::checkIsHavePermission(Auth::user()->id, $permission_code);
        if(!$isHavePermission) {
            return response()->view('layout.error');
        }
        return $next($request);
    }
}
