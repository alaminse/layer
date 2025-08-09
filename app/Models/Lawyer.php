<?php

namespace App\Models;

use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model {
	use HasCustomFields;
	use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('opposite_lawyer', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('opposite_lawyer', 'delete');
        });
    }

}
