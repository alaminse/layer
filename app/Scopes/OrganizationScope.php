<?php

namespace App\Scopes;

use App\Models\LmsInstitute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class OrganizationScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (moduleStatusCheck('AdvSaas')){
            $table = $model->getTable();
            $organization_id = 1;
            if (getOrganization()) {
                $organization_id = getOrganization()->id;
            } else if (Auth::check()) {
                $organization_id = Auth()->user()->organization_id;
            }

            $builder->where($table.'.organization_id', $organization_id)->orWhereNull($table.'.organization_id');
        }

    }
}
