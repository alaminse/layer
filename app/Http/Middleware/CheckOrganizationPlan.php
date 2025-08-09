<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckOrganizationPlan
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->role_id == 1) {
            return $next($request);
        }

        $organization = $user->organization;

        if (!$organization || !$organization->end_date || now()->gt($organization->end_date)) {
            return redirect()->route('plan.expired'); 
        }

        return $next($request);
    }
}
