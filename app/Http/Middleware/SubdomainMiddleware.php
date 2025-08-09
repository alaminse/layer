<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LmsInstitute;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SubdomainMiddleware
{
    public function handle($request, Closure $next)
    {

        $organization = getOrganization();

        Session::put('domain', $organization->subdomain);

        if (moduleStatusCheck('AdvSaasMD')) {
            if (DB::connection()->getDatabaseName() != $organization->db_database) {
                DbConnect();
            }
        }

        app()->forgetInstance('organization');
        app()->instance('organization', $organization);


        return $next($request);
    }


}
