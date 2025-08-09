<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;
use Toastr;

class ProhibitedInDemoMode
{
    /**
     * Restric action if test mode is turned on.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (config('app.app_sync')) {
            if ($request->ajax()) {
                throw ValidationException::withMessages(['message' => 'Restricted in demo mode']);
            }
            Toastr::error('Restricted in demo mode');
            return back();
        }

        return $next($request);
    }
}
