<?php

namespace App\Traits;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Modules\AdvSaas\Entities\SaasCheckout;
use Modules\AdvSaas\Entities\SaasOrganizePlanManagement;
use Modules\AdvSaas\Events\OrganizationCreated;
use Modules\AdvSaas\Jobs\NewOrganizationRegisteredMailJob;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

trait OrganizationTrait {

    public function organizationApprove($record){

        $organization = $record->organization;
        $user = $organization->user;

        $subCheckout = new SaasCheckout();
        $start_date = Carbon::now();
        $previousCheckout = SaasCheckout::where('user_id', $user->id)->latest()->first();

        if ($previousCheckout) {
            $subCheckout = $previousCheckout;
            $start_date = Carbon::parse($previousCheckout->end_date)->addDay();
        }

        $plan = $record->plan;
        $planPrice = $record->planPrice;
        if($planPrice->subscriptionPackage->days){
            $end_date = $start_date->addDays($planPrice->subscriptionPackage->days)->format('Y-m-d');
        } else{
            $end_date = null;
        }

        $subCheckout->user_id = $user->id;
        $subCheckout->plan_id = $plan->id;
        $subCheckout->price = $planPrice->price;
        $subCheckout->billing_detail_id = 0;
        $subCheckout->tracking = 0;
        $subCheckout->start_date = $start_date;
        $subCheckout->end_date = $end_date;
        $subCheckout->days = $planPrice->subscriptionPackage->days;
        $subCheckout->payment_method = $record->payment_method;
        $subCheckout->status = 1;
        $subCheckout->purchase_record_id = $record->id;
        $subCheckout->organization_id = $user->organization_id;
        $subCheckout->response = json_encode(null);
        $subCheckout->save();

        $saas_purchase_management = SaasOrganizePlanManagement::where('organization_id', $user->organization_id)->first();
        $service_end_date = null;

        if ($saas_purchase_management) {
            if($planPrice->subscriptionPackage->days){
                $service_end_date = Carbon::parse($saas_purchase_management->service_end_date)->addDays($planPrice->subscriptionPackage->days);
            }

        } else {
            if($planPrice->subscriptionPackage->days){
                $service_end_date =  Carbon::now()->addDays($planPrice->subscriptionPackage->days);
            }
            $saas_purchase_management = new SaasOrganizePlanManagement();
            $saas_purchase_management->organization_id = $user->organization_id;
        }

        $saas_purchase_management->modules = $plan->modules;
        $saas_purchase_management->limits = $plan->limits;
        $saas_purchase_management->purchase_date = Carbon::now();
        $saas_purchase_management->service_end_date = $service_end_date;

        $saas_purchase_management->save();

        if(SaasDomain() == 'main'){
            event(new OrganizationCreated($organization));
            $organization->status = 1;
            $organization->save();
        }


        return true;
    }
}
