<?php

namespace Modules\Setting\Model;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use Tenantable;
    protected $guarded = ['id'];
}
