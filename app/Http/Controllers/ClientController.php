<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Country;
use App\Models\State;
use App\Traits\CustomFields;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    use CustomFields;

    public function __construct()
    {
        $this->middleware('limit:client')->only(['create', 'store', 'changeStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = Client::when(moduleStatusCheck('ClientLogin'), function ($quey) {
            $quey->whereIn('status', ['active', 'approve'])->orWhereNull('status');
        })->get();
        return view('client.index', compact('models'));
    }
    public function waitingPage()
    {
        if (!auth()->check()) {
            return view('waiting');
        }
        exit();
    }
    public function pendingList()
    {
        $models = Client::when(moduleStatusCheck('ClientLogin'), function ($quey) {
            $quey->where('status', 'pending');
        })->get();
        return view('client.pending_client', compact('models'));
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
        $client_categories = self::getCategory('client', 'prepend');
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
        $client_id = request()->client_id;
        if (request()->ajax() and $quick_add == 1) {
            return view('client.create_modal', compact('countries', 'client_categories', 'states', 'fields', 'enable_login', 'plaintiff', 'client_id'));
        }

        return view('client.create', compact('countries', 'client_categories', 'states', 'fields', 'enable_login'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */

    public function store(Request $request)
    {

        if (!$request->json()) {
            abort(404);
        }
        $validate_rules = [
            'country_id' => 'sometimes|nullable|integer',
            'state_id' => 'sometimes|nullable|integer',
            'city_id' => 'sometimes|nullable|integer',
            'client_category_id' => 'sometimes|nullable|integer',

            'mobile' => 'sometimes|nullable|string|max:191',
            'gender' => 'sometimes|nullable|string|max:191',
            'name' => 'required|max:191|string',
            'address' => 'sometimes|nullable|max:191|string',
            'description' => 'sometimes|nullable|max:1500|string',
        ];
        if (moduleStatusCheck('CustomField')) {
            $validate_rules = array_merge($validate_rules, $this->generateValidateRules('client'));
        }
        $organization = getOrganization();
        $enable_login = false;
        $enable_login_auto = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');

            $enable_login_auto = config('configs.client_login_auto');
        }
        if ($enable_login) {
            $validate_rules = array_merge($validate_rules, [
                'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->where('organization_id', $organization->id)],
                'password' => 'required|string|min:8',
            ]);
        } else {
            $validate_rules = array_merge($validate_rules, [
                'email' => ['sometimes', 'nullable', 'email', 'max:191', Rule::unique('clients', 'email')->where('organization_id', $organization->id)],
            ]);
        }

        $request->validate($validate_rules, validationMessage($validate_rules));

        $model = new Client();
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
        $model->organization_id = $organization->id;
        $model->type = $request->type;
        if (moduleStatusCheck('ClientLogin')) {
            $model->status = $request->filled('frontend') ? ($enable_login_auto ? 'active' : 'pending') : 'active';
        }
        $model->save();

        if (moduleStatusCheck('CustomField')) {
            $this->storeFields($model, $request->custom_field, 'client');
        }
        if ($enable_login) {
            $user = new User();
            $user->name = $model->name;
            $user->email = $model->email;
            $user->password = bcrypt($request->password);
            $user->is_active = $request->filled('frontend') ? ($enable_login_auto ? 1 : 0) : 1;
            $user->organization_id = $organization->id;
            $user->save();

            $model->user_id = $user->id;
            $model->save();
        }

        $response = [
            'model' => $model,
            'message' => __('client.Client Added Successfully'),
        ];

        if ($request->quick_add == 1) {
            $plaintiff = $request->plaintiff;
            $client_id = $request->client_id;
            if ($plaintiff) {
                $response['appendTo'] = '#plaintiff';
            } elseif($client_id){
                $response['appendTo'] = '#client_id';
            }else {
                $response['appendTo'] = '#opposite';
            }

        } else {
            $response['goto'] = route('client.index');
        }

        if ($enable_login_auto && $request->filled('frontend') && $enable_login) {
            Auth::login($user);
            $response['message'] = 'Registration Successfully';
            $response['goto'] = route('client.my_dashboard');
            return response()->json($response);
        } elseif (!$enable_login_auto && $enable_login && $request->filled('frontend')) {
            $response['message'] = 'Registration Successfully';
            $response['goto'] = route('client.waiting');
            return response()->json($response);
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
        $model = Client::query();
        if (moduleStatusCheck('Finance')) {
            $model->with('invoices', 'transactions');
        }

        $model = $model->findOrFail($id);
        return view('client.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $model = Client::with('user')->findOrFail($id);
        $countries = Country::all()->pluck('name', 'id')->prepend(__('client.Select country'), '');
        $states = State::where('country_id', $model->country_id)->pluck('name', 'id')->prepend(__('client.Select state'), '');
        $cities = City::where('state_id', $model->state_id)->pluck('name', 'id')->prepend(__('client.Select city'), '');
        $client_categories = self::getCategory('client', 'prepend');
        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('client');
        }

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }

        return view('client.edit', compact('model', 'countries', 'states', 'cities', 'client_categories', 'fields', 'enable_login'));
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
        $model = Client::find($id);
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
            $enable_login = config('configs.client_login');
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
        $model->type = $request->type;
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
            'message' => __('client.Client Updated Successfully'),
            'goto' => route('client.index'),
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
        $with = [
            'plaintiffs', 'opposites', 'clientLayout2'
        ];

        if (moduleStatusCheck('CustomField')) {
            $with[] = 'customFields';
        }

        if (moduleStatusCheck('Finance')) {
            $with[] = 'invoices';
        }

        $model = Client::with($with)->find($id);

        if (!$model) {
            throw ValidationException::withMessages(['message' => __('client.Client Not Found')]);
        }

        if ($model->opposites->count() || $model->plaintiffs->count() || $model->clientLayout2->count()) {
            throw ValidationException::withMessages(['message' => __('client.Client is assign to cases.')]);
        }

        if (moduleStatusCheck('Finance')) {
            if ($model->invoices->count()) {
                throw ValidationException::withMessages(['message' => __('client.Client has invoices.')]);
            }
        }

        if (moduleStatusCheck('CustomField')) {
            $model->customFields()->delete();
        }

        $model->user()->delete();

        $model->delete();

        return response()->json(['message' => __('client.Client Deleted Successfully'), 'goto' => route('client.index')]);
    }
    public function changeStatus(Request $request)
    {
        // return $request->all();
        if ($request->status == 'approve') {
            if ($request->client_id) {
                $client = Client::where('id', $request->client_id)
                ->where('status', 'pending')->first();
                if ($client) {
                    $client->status ='active';
                    $client->save();
                }
                if ($client->user_id) {
                    User::where('id', $client->user_id)->where('is_active', 0)->update(['is_active' => 1 ]);
                }
            }
        }
        if ($request->status == 'pending') {

        }
        if ($request->status == 'reject') {

        }
        return response()->json([
            'message' => __('client.Status Update Successfully'),
            'goto' => route('client.pending.list')
        ]);
    }

    public static function getCategory($type = null, $prepend = null)
    {
        $msg = $type == 'company' ? 'client.Select Company Category' : 'client.Select Category';
        $model = ClientCategory::get();
        if ($prepend) {
            return $model->pluck('name', 'id')
                ->prepend(__($msg), '');
        }
        return $model;
    }
}
