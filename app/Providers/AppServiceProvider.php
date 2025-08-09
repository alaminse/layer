<?php

namespace App\Providers;

use App\Models\Cases;
use App\Models\CaseStaff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(Storage::exists('.app_installed') && Storage::get('.app_installed')){
            try {
                $this->app->singleton('ModuleList', function () {
                    return Cache::rememberForever('ModuleList', function () {
                        return DB::table('modules')->select('name', 'status', 'order', 'details')->get();
                    });
                });

                $this->app->singleton('ModuleManagerList', function () {
                    return Cache::rememberForever('ModuleManagerList', function () {
                        return DB::table('infix_module_managers')
                            ->select('name', 'email', 'notes', 'version', 'update_url', 'purchase_code', 'installed_domain', 'activated_date', 'checksum')
                            ->get();
                    });
                });
            } catch (\Exception $e){

            }
        }


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        View::composer(['partials.sidebar', 'home'], function ($view) {
            $caseAccess = false;
            $caseIds = [];

            // if (!permissionCheck('all-case')) {
            //     $caseAccess = true;
            //     $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
            // }

            $view->with([
                'all_cases' => Cases::when($caseAccess, function ($query) use ($caseIds) {
                    $query->whereIn('id', $caseIds);
                })->count(),

                'running_cases' => Cases::when($caseAccess, function ($query) use ($caseIds) {
                    $query->whereIn('id', $caseIds);
                })->where(function ($q) {
                    $q->where('status', 'Open')->orWhereIn('judgement_status', ['Open', 'Reopen']);
                })->count(),

                'judgement_cases' => Cases::when($caseAccess, function ($query) use ($caseIds) {
                    $query->whereIn('id', $caseIds);
                })->where('judgement_status', 'Judgement')->count(),

                'closed_cases' => Cases::when($caseAccess, function ($query) use ($caseIds) {
                    $query->whereIn('id', $caseIds);
                })->where('judgement_status', 'Close')->count(),
            ]);
        });
    }
}
