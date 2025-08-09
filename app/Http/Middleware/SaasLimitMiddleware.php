<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SaasLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature)
    {
        if (moduleStatusCheck('AdvSaas') && saasPlanCheck($feature)) {
            $message = 'You have reached valid '.str_replace('_', ' ', $feature).' limit';
            if($request->ajax()){
                return response()->json(['message' => $message, 'status' => false], 403);
            }

            Toastr::error($message, trans('common.Failed'));
            if(url()->previous() == url()->current()){
                return redirect()->route('home');
            }
            return redirect()->back();

        }

        return $next($request);
    }
}
