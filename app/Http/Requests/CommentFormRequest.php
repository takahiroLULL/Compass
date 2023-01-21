<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
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
                'comment' =>'required|max:2500|string',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' =>'入力必須です。',
            'comment.max' =>'最大2500文字までです。',
            'comment.string' =>'形式が異なります。',        
        ];
    }
}
