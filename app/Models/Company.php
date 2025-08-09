<?php

namespace App\Models;

use App\User;
use App\Models\City;
use App\Models\Cases;
use App\Models\State;
use App\Models\Country;
use App\Models\ClientCategory;
use App\Traits\HasCustomFields;
use App\Traits\Tenantable;
use Modules\Finance\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Entities\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Tenantable;

    // use HasCustomFields;
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = ['country_id', 'state_id', 'city_id', 'client_category_id', 'email', 'mobile', 'gender', 'address', 'name', 'description', 'organization_id'];
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function state()
    {
        return $this->belongsTo(State::class)->withDefault();
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(ClientCategory::class, 'client_category_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'clientable');
    }

    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Invoice::class,
            'clientable_id',
            'morphable_id',
            'id',
            'id'
        )->where(['invoices.clientable_type' => __CLASS__, 'transactions.morphable_type' => get_class(new Invoice())]);
    }

    public function plaintiffs()
    {
        return $this->hasMany(Cases::class, 'plaintiff', 'id');
    }

    public function opposites()
    {
        return $this->hasMany(Cases::class, 'opposite', 'id');
    }
}
