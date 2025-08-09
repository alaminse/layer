<?php

namespace Modules\Leave\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Auth;

class LeaveType extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public static function boot()
    {
        parent::boot();
        static::saving(function ($brand) {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand) {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }
}
