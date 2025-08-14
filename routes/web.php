<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\Entities\Module;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Artisan;

if (moduleStatusCheck('AdvSaas')) {
    Route::group(['middleware' => ['subdomain']], function ($routes) {
        require('tenant.php');
    });
} else {
    require('tenant.php');
}

Route::group(['middleware' => ['auth', 'check.plan']], function () {
    Route::controller(RoleController::class)
        ->prefix('roles')
        ->as('roles.')
        ->group(callback: function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{role}', 'edit')->name('edit');
            Route::put('/update/{role}', 'update')->name('update');
            Route::delete('/destroy/{role}', 'destroy')->name('destroy');
            Route::get('/edit/permission/{role}', 'editPermission')->name('edit.permission');
            Route::post('/assign/permission', 'assignPermission')->name('assign.permission');
        });

    Route::controller(PermissionController::class)
        ->prefix('permissions')
        ->as('permissions.')
        ->group(callback: function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{permission}', 'edit')->name('edit');
            Route::put('/update/{permission}', 'update')->name('update');
            Route::delete('/destroy/{permission}', 'destroy')->name('destroy');
        });

    Route::controller(OrganizationController::class)
        ->prefix('organizations')
        ->as('organizations.')
        ->group(callback: function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{organization}', 'edit')->name('edit');
            Route::get('/show/{subscription}', 'show')->name('show');
            Route::put('/update/{organization}', 'update')->name('update');
            Route::delete('/destroy/{organization}', 'destroy')->name('destroy');
        });

    Route::controller(SubscriptionController::class)
        ->prefix('subscriptions')
        ->as('subscriptions.')
        ->group(callback: function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{subscription}', 'edit')->name('edit');
            Route::get('/show/{subscription}', 'show')->name('show');
            Route::put('/update/{subscription}', 'update')->name('update');
            Route::delete('/destroy/{subscription}', 'destroy')->name('destroy');
        });


    //Route::get('/{page}', 'PageController@frontShow')->name('front.page.show');
    Route::get('test', function () {
        $modules = Module::all();
        $infixModule = \Modules\ModuleManager\Entities\InfixModuleManager::first();

        foreach ($modules as $module) {
            $name = $module->name;
            if (!\Modules\ModuleManager\Entities\InfixModuleManager::where('name', $name)->first()) {
                $infixModule = $infixModule->replicate();
                $infixModule->name = $name;
                $infixModule->save();

                $module->status = 1;
                $module->save();
            }

            $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
            $moduleCheck->enable();
        }

        Cache::forget('ModuleList');
        Cache::forget('ModuleManagerList');

        Artisan::call('migrate', ['--force' => true]);
    });
});


Route::get('/plan-expired', function () {
    return view('expired');
})->name('plan.expired');

