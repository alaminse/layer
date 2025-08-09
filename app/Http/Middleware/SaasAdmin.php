<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaasAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (moduleStatusCheck('AdvSaas')) {
            $user = Auth::user();
            if ($user && $user->is_saas_admin == 1) {
                return $next($request);
            } else {
               return abort(403);
            }
        }else {
            return $next($request);
        }
    }
}
