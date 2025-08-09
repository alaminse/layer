<?php

namespace Modules\Payroll\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class PayrollPaymentLog extends Model
{
    use Tenantable;

    protected $guarded = ['id'];
}
