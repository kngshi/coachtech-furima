<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8|max:191|',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは191文字以内で入力してください。',
            'email.unique' => 'このメールアドレスはすでに使われています。',
            'password.required' => 'パスワードは必須です。',
            'password.string' => 'パスワードは文字列で入力してください。',
            'password.min' => 'パスワードは最低8文字以上で入力してください。',
            'password.max' => 'パスワード191文字以内で入力してください。',
        ];
    }
}
