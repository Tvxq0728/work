<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if($this->path()=="/register"){
        //     return true;
        // }else{
        //     return false;
        // }
        // ↑なぜThis action is unauthorized
        
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
        "name"=>"required",
        "email"=>[
            "required",
            "email",
    ],
        "password"=>"required",
        "password_check"=>[
            "same:password",
        ]
        ];
    }

    public function messages(){
        return[
        "name.required"=>"名前は必須です。",
        "email.required"=>"メールアドレスは必須です。",
        "email.email"=>"メールアドレスの形式で入力してください",
        // "password.required"=>"パスワードは必須です。",
        // input type="email"で自動で確認している。
        "password.required"=>"パスワードは必須です。",
        "password_check.same"=>"パスワードとパスワード確認用が一致しません",
        ];
    }
}
