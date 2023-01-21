<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormRequest extends FormRequest
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
            'main_category' =>'required|max:100|string|unique:main_categories',
        ];
    }

    public function messages()
    {
        return [
            'main_category.required' =>'入力必須項目です。',
            'main_category.max' =>'100文字以内で入力してください',
            'main_category.string' =>'形式が異なります',
            'main_category.unique' =>'このカテゴリーは既に登録されています。',
        ];
    }
}
