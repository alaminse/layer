<?php

namespace App\Models;

use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {

    use HasCustomFields;
	use Tenantable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            saasPlanManagement('court', 'create');
        });

        self::deleted(function ($model) {
            saasPlanManagement('court', 'delete');
        });
    }


    protected $with = ['court_category'];
	protected $table = 'courts';
	protected $primaryKey = 'id';
	protected $fillable = ['country_id', 'state_id', 'city_id', 'court_category_id', 'location', 'name', 'description', 'organization_id'];

	public function court_category() {
		return $this->belongsTo(CourtCategory::class)->withDefault();
	}

	public function country() {
		return $this->belongsTo(Country::class)->withDefault();
	}

	public function state() {
		return $this->belongsTo(State::class,'state_id')->withDefault();
	}

	public function city() {
		return $this->belongsTo(City::class,'city_id')->withDefault();
	}

	public function cases(){
	    return $this->hasMany(Cases::class, 'court_id', 'id');
    }

}
