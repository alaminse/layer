<?php

namespace App\Models;

use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class HearingDate extends Model
{
    use HasCustomFields;
    use Tenantable;

    protected $with = ['files'];

    public function case_stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'id');
    }

    public function cases()
    {
        return $this->belongsTo(Cases::class, 'cases_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(Upload::class);
    }
}
