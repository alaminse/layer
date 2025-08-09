<?php

namespace App;

use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasCustomFields, Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('staff', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('staff', 'delete');
        });
    }


    protected $table = 'staffs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function registerLawyerDocument()
    {       
        return $this->belongsTo(\Modules\Registration\Entities\LawyerRegistration::class, 'user_id', 'user_id')->withDefault();
    }
}
