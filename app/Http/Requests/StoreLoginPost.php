<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoginPost extends FormRequest
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
            'user_name' => [
                'required',
                'max:20',
                'min:3',
                'regex:/^[a-zA-Z0-9_-]{3,20}$/',
            ],
            'user_pwd' => 'required|max:12|min:3|alpha_dash',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => '用户名要填哦',
            'user_name.max' => '用户名最长20位哦',
            'user_name.min' => '用户名最小3位哦',
            'user_name.regex' => '用户名字母数字下划线组成哦',
            'user_pwd.required' => '密码要填哦',
            'user_pwd.max' => '密码最长12位哦',
            'user_pwd.min' => '密码最小3位哦',
            'user_pwd.alpha_dash' => '密码数字字母下划线组成哦',
        ];
    }
}
