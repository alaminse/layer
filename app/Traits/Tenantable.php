<?php

namespace App\Traits;

use App\Models\Organization;
use App\Scopes\OrganizationScope;
use App\Models\LmsInstitute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait Tenantable
{

    protected static function bootTenantable()
    {
        static::addGlobalScope(new OrganizationScope);

        if (Auth::check() && Auth::user()->organization_id) {
            static::creating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'organization_id')) {
                    if(!$model->organization_id){
                        $model->organization_id = Auth::user()->organization_id;
                    }
                }
            });
        }
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
