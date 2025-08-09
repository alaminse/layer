<?php

namespace App\Models;

use App\Scopes\OrganizationScope;
use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasCustomFields;
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('appointment', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('appointment', 'delete');
        });
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class)->withoutGlobalScope(OrganizationScope::class);
    }

}
