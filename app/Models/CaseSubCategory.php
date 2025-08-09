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
class CaseSubCategory extends Model
{
    use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('case_sub_categories', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('case_sub_categories', 'delete');
        });
    }

    protected $table = 'case_sub_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'organization_id'];

    public function cases(){
        return $this->hasMany(Cases::class, 'case_category_id', 'id');
    }
}
