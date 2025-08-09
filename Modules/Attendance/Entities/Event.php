<?php

namespace Modules\Attendance\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\Role;
class Event extends Model
{
    use Tenantable;

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_by = Auth::id() ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? null;
        });

        static::created(function ($course) {
            saasPlanManagement('event', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('event', 'delete');
        });
    }

    protected $fillable = ['title','for_whom','location','description','from_date','to_date','image','status','created_by','updated_by', 'organization_id'];

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'for_whom');
    }

}
