<?php

namespace App\Models;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseStaff extends Model
{
    use HasFactory;
    use Tenantable;

    protected $fillable = ['case_id', 'staff_id', 'organization_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id')->withDefault();
    }
}
