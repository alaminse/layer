<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    use Tenantable;
    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('contact_category', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('contact_category', 'delete');
        });
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'contact_category_id', 'id');
    }
}
