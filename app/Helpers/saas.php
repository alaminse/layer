<?php

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\AdvSaas\Entities\SaasCheckout;
use Modules\AdvSaas\Entities\SaasOrganizePlanManagement;
use Modules\ModuleManager\Entities\Module;

if (!function_exists('hasActiveSaasPlan')) {
    function hasActiveSaasPlan(): bool
    {
        try {
            if (SaasDomain() != 'main') {
                $organization = SaasOrganization();
                $organization_id = $organization->id;
                $organization_domain = $organization->subdomain;

                $active_plan = Cache::rememberForever('active_plan_for_'.$organization_domain, function() use($organization_id){
                    return SaasOrganizePlanManagement::on('mysql')->where('organization_id', $organization_id)->first();
                });
                if ($active_plan) {
                    if (is_null($active_plan->service_end_date)) {
                        return true;
                    }
                    $today = Carbon::now();

                    if ($today->lt( $active_plan->service_end_date)) {
                        return true;
                    }
                }
                return false;
            } else {
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('SaasDomain')) {
    function SaasDomain()
    {

       /* if (app()->bound('organization')) {
            return app('organization')->subdomain;
        }*/

        $domain = 'main';
        $saas_module = 'Modules/AdvSaas/Providers/AdvSaasServiceProvider.php';

        if (file_exists($saas_module)) {
            $module_status = json_decode(file_get_contents('modules_statuses.json'), true);
            if ((isset($module_status['AdvSaas']) && $module_status['AdvSaas'])) {

                if (config('app.short_url') != request()->getHost()) {
                    $short_url = preg_replace('#^https?://#', '', rtrim(env('APP_URL', 'http://localhost'), '/'));

                    $domain = str_replace('.' . $short_url, '', request()->getHost());
                }
            }
        }

        return $domain;
    }
}

function activePlan(){
    $organization = SaasOrganization();
    $organization_id = $organization->id;
    $organization_domain = $organization->subdomain;
    return Cache::rememberForever('active_plan_for_'.$organization_domain, function() use($organization_id){
        return SaasOrganizePlanManagement::on('mysql')->where('organization_id', $organization_id)->first();
    });
}

if (!function_exists('saasPlanManagement')) {
    function saasPlanManagement($feature, $type, $size = null)
    {

        if (SaasDomain() != 'main') {
            $organization = SaasOrganization();
            $active_plan = activePlan();

            $limit = gv($active_plan->limits, $feature, 0);

            if ($type == 'create') {
                $limit -= 1;
            }
            if ($type == 'delete') {
                $limit += 1;
            }

            if ($limit <= 0) {
                $limit = 0;
            }

            $active_plan->forceFill([
                'limits->' . $feature => $limit
            ])->save();

            Cache::forget('active_plan_for_'.$organization->subdomain);

        }
    }
}

if (!function_exists('SaasOrganization')) {
    function SaasOrganization()
    {
        try {
            DB::connection()->getPdo();
            $hasConnection = true;
        } catch (\Throwable $th) {
            $hasConnection = false;
        }

        if ($hasConnection && Schema::hasTable('organizations')) {

            try {
                $saasOrganization = Cache::rememberForever('saasOrganization' . SaasDomain(), function () {
                    return Organization::where('subdomain', SaasDomain())->first();
                });
                return $saasOrganization;
            } catch (\Throwable $th) {
                return Organization::first();
            }
        } else {
            $organization = collect();
            $organization->name = 'InfixAdvocate';
            $organization->description = 'InfixAdvocate';
            $organization->subdomain = 'main';
            $organization->domain = null;
            $organization->user_id = 1;
            $organization->status = 1;
            return $organization;
        }
    }
}

if (!function_exists('saasPlanCheck')) {
    function saasPlanCheck($feature, $count = null)
    {

        try {
            $organization = SaasOrganization();

            $organization_domain = $organization->subdomain;
            if ( $organization_domain == 'main') {
                return false;
            }

            $organization_id = $organization->id;
            $active_plan = activePlan();


            if (!$active_plan) {
                return true;
            }

            if (!$active_plan->service_end_date) {
                return false;
            }

            $today = Carbon::now();

            if ($today->gt($active_plan->service_end_date)) {
                return true;
            }

            $checkout = Cache::rememberForever('checkouts_for_'.$organization_domain, function() use($organization_id){
                return SaasCheckout::on('mysql')->with('plan')->where('organization_id', $organization_id)->get();
            });

            foreach ($checkout as $check) {
                if (!is_null(gv($check->plan->limits, $feature)) && gv($check->plan->limits, $feature) == 0) {
                    return false;
                }
            }

            if (gv($active_plan->limits, $feature) && gv($active_plan->limits, $feature) > 0) {
                return false;
            }

            return true;

        } catch (\Throwable $th) {
            return true;
        }
    }
}

function limits(){
    $modules = Module::where('name', '!=', 'AdvSaas')->get();
    $limits['root'] = getVar('limits');
    foreach ($modules as $module) {
        $name = $module->name;
        if (moduleStatusCheck($name)) {
            $limits[$name] =  getModuleVar($name, 'limits');

        }
    }

    return $limits;
}

function organization_url($organization = null){
    if(!$organization){
        $organization = getOrganization();
    }

    $protocol = check_https();
    return $protocol.'://'.$organization->subdomain.'.'.config('app.short_url');
}
