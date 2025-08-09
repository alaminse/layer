<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('case_stage', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('case_stage', 'delete');
        });
    }

    public function dates(){
        return $this->hasMany(HearingDate::class, 'stage_id', 'id');
    }
}
