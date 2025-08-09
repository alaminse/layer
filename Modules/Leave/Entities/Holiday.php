<?php

namespace Modules\Leave\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use Tenantable;

    protected $fillable = ['year','name','date','type'];
}
