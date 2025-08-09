<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class CaseAct extends Model {

	use Tenantable;

	public $timestamps = false;
	protected $with = ['act'];
	protected $fillable = ['name', 'description', 'organization_id'];
	

	public function act() {
		return $this->belongsTo(Act::class, 'acts_id', 'id');
	}
}
