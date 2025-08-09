<?php

namespace App\Models;

use App\Scopes\OrganizationScope;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\AdvSaas\Entities\SaasCheckout;
use Modules\AdvSaas\Entities\SaasOrganizePlanManagement;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function user(){
    //     return $this->belongsTo(User::class)->withOutGlobalScope(OrganizationScope::class)->withDefault([
    //         'name' => ''
    //     ]);
    // }

    /**
     * Get the user associated with the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'organization_id');
    }

    public function checkout()
    {
        return $this->hasMany(SaasCheckout::class, 'organization_id')->orderBy('id', 'desc');
    }

    public function planManagement()
    {
        return $this->belongsTo(SaasOrganizePlanManagement::class, 'id', 'organization_id');
    }

}
