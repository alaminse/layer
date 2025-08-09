<?php

namespace Modules\Setting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('theme', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('theme', 'delete');

        });
    }

    public function colors(){
        return $this->belongsToMany(Color::class)->withPivot(['value']);
    }
}
