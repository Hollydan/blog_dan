<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.between' => '用户名必须介于 3 - 25 个字符之间',
            'name.regex' => '用户名只支持字母、数字、下划线、中划线',
            'name.unique' => '用户名已被占用，请重新填写',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确，请重新填写',
            'introduction.max' => '简介最多80个字符',
            'avatar.dimensions' => '图片清晰度不够，宽和高需要200px以上',
        ];
    }
}
