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
class CourtCategory extends Model {

	use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('court_category', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('court_category', 'delete');
        });
    }


    protected $table = 'court_categories';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'description', 'organization_id'];

	public function courts() {
		return $this->hasMany(Court::class);
	}

}
