<?php

namespace App\View\Components;

use App\Models\State;
use App\Models\Country;
use Illuminate\View\Component;
use App\Http\Controllers\ClientController;
use Modules\ClientLogin\Entities\SocialSetting;

class ClientRegistration extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $countries = Country::all()->pluck('name', 'id')->prepend(__('client.Select country'), '');
        $states = State::where('country_id', config('configs.country_id'))->pluck('name', 'id')->prepend(__('client.Select state'), '');
        $client_categories = ClientController::getCategory('client', 'prepend');

        $data['fields'] = null;

        if (moduleStatusCheck('CustomField')) {
            $data['fields'] = getFieldByType('client');
        }

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }
        $data['google'] = SocialSetting::where('type', 'google')->where('allow', 1)->first();
        $data['facebook'] = SocialSetting::where('type', 'facebook')->where('allow', 1)->first();
        $data['twitter'] = SocialSetting::where('type', 'twitter')->where('allow', 1)->first();
        $data['ios'] = SocialSetting::where('type', 'ios')->where('allow', 1)->first();
        return view('components.client-registration', compact('countries', 'states', 'client_categories', 'enable_login'))->with($data);
    }
}
