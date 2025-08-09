<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\City;
use App\Models\State;
use App\Models\Client;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequestForm;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function index()
    {
        $data = self::getData();
        return view('company.index', $data);
    }
    public static function getData(): array
    {
        $data = [];
        $data['companies'] = Company::get();
        return $data;
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::all()->pluck('name', 'id')->prepend(__('client.Select country'), '');
        $states = State::where('country_id', config('configs.country_id'))->pluck('name', 'id')->prepend(__('client.Select state'), '');
        $company_categories = ClientController::getCategory('company', 'prepend');
        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('client');
        }

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }

        $quick_add = request()->quick_add;
        $plaintiff = request()->plaintiff;
        if (request()->ajax() and $quick_add == 1) {
            return view('company.create_modal', compact('countries', 'company_categories', 'states', 'fields', 'enable_login', 'plaintiff'));
        }

        return view('company.create', compact('countries', 'company_categories', 'states', 'fields', 'enable_login'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function store(CompanyRequestForm $request)
    {
        if (!$request->json()) {
            abort(404);
        }

        $model = new Company();
        $model->country_id = $request->country_id;
        $model->state_id = $request->state_id;
        $model->city_id = $request->city_id;
        $model->client_category_id = $request->client_category_id;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->gender = $request->gender;
        $model->mobile = $request->mobile;
        $model->address = $request->address;
        $model->description = $request->description;
        $model->save();

        if (moduleStatusCheck('CustomField')) {
            $this->storeFields($model, $request->custom_field, 'client');
        }
        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }
        if ($enable_login) {
            $user = new User();
            $user->name = $model->name;
            $user->email = $model->email;
            $user->password = bcrypt($request->password);
            // $user->role_id = 4;

            $user->save();

            $model->user_id = $user->id;
            $model->save();
        }

        $response = [
            'model' => $model,
            'message' => __('client.Company Added Successfully'),
        ];

        if ($request->quick_add == 1) {
            $plaintiff = $request->plaintiff;
            if ($plaintiff) {
                $response['appendTo'] = '#plaintiff';
            } else {
                $response['appendTo'] = '#opposite';
            }

        } else {
            $response['goto'] = route('company.index');
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $model = Company::query();
        if (moduleStatusCheck('Finance')) {
            $model->with('invoices', 'transactions');
        }

        $model = $model->findOrFail($id);
        return view('company.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $model = Company::with('user')->findOrFail($id);
        $countries = Country::all()->pluck('name', 'id')->prepend(__('client.Select country'), '');
        $states = State::where('country_id', $model->country_id)->pluck('name', 'id')->prepend(__('client.Select state'), '');
        $cities = City::where('state_id', $model->state_id)->pluck('name', 'id')->prepend(__('client.Select city'), '');
        $company_categories = ClientController::getCategory('company', 'prepend');
        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('client');
        }

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }

        return view('company.edit', compact('model', 'countries', 'states', 'cities', 'company_categories', 'fields', 'enable_login'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }
        $model = Company::find($id);
        if (!$model) {
            throw ValidationException::withMessages(['message' => __('client.Client Not Found')]);
        }
        $validate_rules = [
            'country_id' => 'sometimes|nullable|integer',
            'state_id' => 'sometimes|nullable|integer',
            'city_id' => 'sometimes|nullable|integer',
            'client_category_id' => 'sometimes|nullable|integer',
            'email' => 'sometimes|nullable|email|max:191',
            'mobile' => 'sometimes|nullable|string|max:191',
            'gender' => 'sometimes|nullable|string|max:191',
            'name' => 'required|max:191|string',
            'address' => 'sometimes|nullable|max:191|string',
            'description' => 'sometimes|nullable|max:1500|string',
        ];

        if (moduleStatusCheck('CustomField')) {
            $validate_rules = array_merge($validate_rules, $this->generateValidateRules('client'));
        }

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $config = config('configs.client_login');
        }
        if ($enable_login) {
            $validate_rules = array_merge($validate_rules, [
                'email' => 'required|email|max:191|unique:users,email,' . ($model->user ? $model->user->id : ''),
            ]);
            if (!$model->user) {
                $validate_rules = array_merge($validate_rules, [
                    'password' => 'required|string|min:8',
                ]);
            } else {
                $validate_rules = array_merge($validate_rules, [
                    'password' => 'sometimes|nullable|string|min:8',
                ]);
            }
        } else {
            $validate_rules = array_merge($validate_rules, [
                'email' => 'sometimes|nullable|email|max:191',
            ]);
        }
        $request->validate($validate_rules, validationMessage($validate_rules));

        $model->country_id = $request->country_id;
        $model->state_id = $request->state_id;
        $model->city_id = $request->city_id;
        $model->client_category_id = $request->client_category_id;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->gender = $request->gender;
        $model->mobile = $request->mobile;
        $model->address = $request->address;
        $model->description = $request->description;
        $model->save();
        if (moduleStatusCheck('CustomField')) {
            $this->storeFields($model, $request->custom_field, 'client');
        }

        if ($enable_login) {
            $user = User::find($model->user_id);
            if (!$user) {
                $user = new User();
            }
            $user->name = $model->name;
            $user->email = $model->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            $model->user_id = $user->id;
            $model->save();
        }

        $response = [
            'message' => __('client.Company Updated Successfully'),
            'goto' => route('company.index'),
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }

        $model = Company::with('plaintiffs', 'opposites')->find($id);

        if (!$model) {
            throw ValidationException::withMessages(['message' => __('client.Company Not Found')]);
        }

        if ($model->opposites()->count() or $model->plaintiffs()->count()) {
            throw ValidationException::withMessages(['message' => __('client.Company is assign to cases.')]);
        }

        if (moduleStatusCheck('Finance')) {
            $model->load('invoices');
            if ($model->invoices()->count()) {
                throw ValidationException::withMessages(['message' => __('client.Company has invoices.')]);
            }
        }

        if (moduleStatusCheck('CustomField')) {
            $model->load('customFields');
            $model->customFields()->delete();
        }

        $model->delete();

        return response()->json(['message' => __('client.Company Deleted Successfully'), 'goto' => route('company.index')]);
    }
}
