<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerjalananRequest extends FormRequest
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
        $id = $this->route('perjalanan');
        return [
            'no_surat' => [
                'required',
                Rule::unique('perjalanan', 'nomor_surat')->ignore($id),
            ],
            'dinas' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
            'foto_surat' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required',
        ];
    }
}
