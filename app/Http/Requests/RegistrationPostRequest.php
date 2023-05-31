<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationPostRequest extends FormRequest
{
//    /**
//     * Determine if the user is authorized to make this request.
//     *
//     * @return bool
//     */
//    public function authorize()
//    {
//        return true;
//    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function samePassword(): bool
    {
        if ($this->input('password') == $this->input('password_confirmation')) {
            return true;
        }
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required','confirmed'],
            'first_name' => 'required|min:2|max:10',
            'last_name' => 'required|min:2|max:10'
        ];
    }
    /**
     * Получить пользовательские имена атрибутов для формирования ошибок валидатора.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'A email is required',

            'password.required' => 'A password is required',
            'password_confirmation' => "A password isn't confirm",

            'first_name.required' => 'A first name is required',
            'first_name.min' => 'Your first name is too short!',
            'first_name.max' => 'Your first name is too long!',

            'last_name.required' => 'A last name is required',
            'last_name.min' => 'Your last name is too short!',
            'last_name.max' => 'Your last name is too long!',
        ];
    }
}
