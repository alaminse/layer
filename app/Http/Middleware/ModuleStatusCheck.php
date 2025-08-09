<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ModuleStatusCheck
{

    public function handle(Request $request, Closure $next, $module)
    {
        if (!moduleStatusCheck($module)) {
           abort(404);
        }

        return $next($request);
    }
}
