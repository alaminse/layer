<?php

namespace App\Payment;

use App\Models\PaymentGatewaySetting;
use App\Traits\OrganizationTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Modules\AdvSaas\Entities\Plan;
use Modules\AdvSaas\Entities\SaasOrganizationPlanPurchaseRecord;
use Omnipay\Omnipay;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Paypal
{
    use OrganizationTrait;

    private $_api_context;
    private $mode;
    private $client_id;
    private $secret;
    /**
     * @var Plan
     */
    private $data;

    public function __construct(PaymentGatewaySetting $setting, array $data)
    {
        $this->data = $data;
        $paypal_conf = config('paypal');
        if ($setting->gateway_mode == "live") {
            $paypal_conf['settings']['mode'] = "live";
        }

        $this->_api_context = Omnipay::create('PayPal_Rest');
        $this->_api_context->setClientId($setting->gateway_client_id);
        $this->_api_context->setSecret($setting->gateway_secret_key);
        $this->_api_context->setTestMode($setting->gateway_mode != "live");


    }

    public function handle()
    {
        $data = $this->data;
        $planPrice = gv($data, 'planPrice');
        $plan = gv($data, 'plan');
        $record = gv($data, 'record');

        $response = $this->_api_context->purchase(array(
            'amount' => $planPrice->discount_price > 0 ? $planPrice->discount_price : $planPrice->price,
            'currency' => config('configs.currency_code', 'USD'),
            'returnUrl' => route('payment_gateway_success_callback', ['PayPal', $record->id]),
            'cancelUrl' => route('payment_gateway_cancel_callback', ['PayPal', $record->id]),

        ))->setItems([
            [
                'name' => $plan->name . '('.$planPrice->subscriptionPackage->name.')',
                'quantity' => 1,
                'price' => ($planPrice->discount_price > 0 ? $planPrice->discount_price : $planPrice->price)
            ]
        ])->send();

        $payment_id = gv($response->getData(), 'id');
        if(!$payment_id){
            throw ValidationException::withMessages(['amount'=> $response->getMessage()]);
        }

        if ($response->isRedirect()) {
            if(request()->wantsJson()){
                return $response->getRedirectUrl();
            }else{
                return redirect()->to($response->getRedirectUrl())->send();
            }
        } else {
            throw ValidationException::withMessages(['amount'=> $response->getMessage()]);
        }

    }


    public function successCallback(Request $request)
    {
        try {
            $payment_id = $request->paymentId;

            $check_existing_payment = SaasOrganizationPlanPurchaseRecord::where('payment_id', $payment_id)->first();
            if ($check_existing_payment) {
                Toastr::error('Payment record previously stored');
                return redirect()->route('saas-plans');
            }
            $transaction = $this->_api_context->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $payment_id,
            ));
            $response = $transaction->send();


            $record = gv($this->data, 'record');
            if (!$response->isSuccessful() || $response->getData()['state'] != 'approved') {
                Log::info('Payment state for Payment id ' . $response->getData()['state'] . ' organization name: ' . $record->organization->name);
                Toastr::error('Payment Failed');
                return redirect()->route('saasPlans');
            }

            $this->organizationApprove($record);
            $record->payment_id = $payment_id;
            $record->save();
            return true;


        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error($e->getMessage(), 'Failed');
            return false;
        }
    }

    public function cancelCallback()
    {

    }
}
