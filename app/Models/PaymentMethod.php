<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, Tenantable;

    public function setting(){
        return $this->hasOne(PaymentGatewaySetting::class, 'gateway_name', 'method');
    }
}
