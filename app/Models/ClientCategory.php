<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed description
 * @property mixed name
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 */
class ClientCategory extends Model
{
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('client_category', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('client_category', 'delete');
        });
    }


    protected $table = 'client_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'organization_id'];

    public function cases()
    {
        return $this->hasMany(Cases::class, 'client_category_id', 'id');
    }

}
