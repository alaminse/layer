<?php

namespace Modules\Task\Entities;

use App\Traits\HasCustomFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Models\Stage;
use App\Models\Cases;
use App\Traits\Tenantable;

class Task extends Model
{
    use HasCustomFields;
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('task', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('task', 'delete');
        });
    }

    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }


    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

}
