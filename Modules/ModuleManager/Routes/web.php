<?php

use Illuminate\Support\Facades\Route;

if (moduleStatusCheck('AdvSaas') ) {
    Route::group(['middleware' => ['subdomain']], function ($routes) {
        require('tenant.php');
    });
} else {
    require('tenant.php');
}
