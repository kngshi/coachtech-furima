<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
        return [
            'postcode' => 'required|string|max:10',
            'address' => 'required|string|max:191',
            'building' => 'nullable|string|max:191',
        ];
    }

    public function messages()
    {
        return [
            'postcode.required' => '郵便番号は必須です。',
            'postcode.string' => '郵便番号は文字列で入力してください。',
            'postcode.max' => '郵便番号は10文字以内で入力してください。',
            'address.nullable' => '',
            'address.string' => '住所は文字列で入力してください。',
            'address.max' => '住所は191文字以内で入力してください。',
            'building.string' => '建物名は文字列で入力してください。',
            'building.max' => '建物名は191文字以内で入力してください。',
        ];
    }
}
