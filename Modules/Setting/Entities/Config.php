<?php

namespace Modules\Setting\Entities;

use App\Models\Country;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use Tenantable;

    protected $fillable = ['key', 'value', 'organization_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id')->withDefault();
    }
}
