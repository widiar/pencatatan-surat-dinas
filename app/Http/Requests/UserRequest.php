<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
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
        $id = $this->route('user_management');
        // dd($id);
        return [
            'username' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'nama' => 'required',
            // 'password' => 'required',
            // 'retype_password' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required',
        ];
    }
}
