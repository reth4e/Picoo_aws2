<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PictureRequest extends FormRequest
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
            'file_name' => 'mimes:jpeg,png,jpg',
            'title' => 'max:30',
            'post_comment' => 'max:300',
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'タイトルは30文字以内にしてください',
            'post_comment.max' => 'タイトルは300文字以内にしてください'
        ];
    }
}
