<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 一般ユーザーのみ UI 側で制御済み
    }

    public function rules()
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'ユーザー名を入力してください。',
            'email.required'    => 'メールアドレスを入力してください。',
            'email.email'       => '正しいメール形式で入力してください。',
            'email.unique'      => 'このメールアドレスは既に登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min'       => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => '確認用パスワードが一致しません。',
        ];
    }
}
