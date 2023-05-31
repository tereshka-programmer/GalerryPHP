<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPicturePostRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_file' => ['required', 'image'],
            'title' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:500'
        ];
    }

    public function messages()
    {
        return [
            'user_file' => 'Your file incorrect!',
        ];
    }
}
