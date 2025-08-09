<?php

namespace App\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequestForm extends FormRequest
{
    use ValidationMessage;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
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

        $enable_login = false;
        if (moduleStatusCheck('ClientLogin')) {
            $enable_login = config('configs.client_login');
        }
        if ($enable_login) {
            $validate_rules = array_merge($validate_rules, [
                'email' => 'required|email|max:191|unique:users',
                'password' => 'required|string|min:8',
            ]);
        } else {
            $validate_rules = array_merge($validate_rules, [
                'email' => 'sometimes|nullable|email|max:191',
            ]);
        }
        return $validate_rules;
    }
}
