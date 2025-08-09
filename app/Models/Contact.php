<?php

namespace App\Models;

use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\CustomField\Entities\CustomFieldResponse;

class Contact extends Model
{
    use HasCustomFields;
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('contact', 'create');
        });

        self::deleted(function ($model) {
                saasPlanManagement('contact', 'delete');
        });
    }

    public function category()
    {
        return $this->belongsTo(ContactCategory::class,'contact_category_id')->withDefault();
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'contact_id', 'id');
    }

}
