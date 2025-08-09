<?php

namespace App\Payment;

use App\Models\PaymentGatewaySetting;
use App\Traits\OrganizationTrait;
use Illuminate\Support\Facades\App;
use Modules\Finance\Services\InvoiceService;
use Stripe\Charge;
use Stripe\Stripe as StripPayment;

class Stripe
{
    use OrganizationTrait;

    private $setting;
    private $data;

    public function __construct(PaymentGatewaySetting $setting, array $data, $type='saas')
    {
        $this->type = $type;
        $this->data = $data;
        $this->setting = $setting;
    }

    public function handle(){
        StripPayment::setApiKey($this->setting->gateway_secret_key);
        $data = $this->data;
        $request = gv($data, 'request');

        if($this->type == 'saas'){
            $planPrice = gv($data, 'planPrice');
            $record = gv($data, 'record');
            $charge = Charge::create([
                "amount" => ($planPrice->discount_price ?? $planPrice->price) * 100,
                "currency" => config('configs.currency_code', 'USD'),
                "source" => $request->stripeToken,
                "description" => gv($data, 'description')
            ]);

            if($charge->status == 'succeeded'){
                $this->organizationApprove($record);
                $record->payment_id = $charge->id;
                $record->save();
                $organization = $record->organization;
                return organization_url($organization);
            }
        } else{

            $charge = Charge::create([
                "amount" => gv($data, 'amount') * 100,
                "currency" => config('configs.currency_code', 'USD'),
                "source" => $request->stripeToken,
                "description" => gv($data, 'description')
            ]);

            if($charge->status == 'succeeded'){
                $invoiceService = App::make(InvoiceService::class);
                $invoice = gv($data, 'invoice') ;
                $request->merge(['payment_method' => 'stripe']);
                $invoiceService->addPayment(array_merge($request->all()), $invoice->id);
                return null;
            }
        }


    }
}
