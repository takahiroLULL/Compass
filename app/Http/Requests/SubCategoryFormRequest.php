<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'main_category_id'=>'required|exists:sub_categories,main_category_id',
            'sub_category' => 'required|max:100|string|unique:sub_categories'
        ];
    }

    public function messages()
    {
        return [
            'main_category_id.required' =>'選択必須項目です。',
            'main_category_id.exists' =>'このidは存在しません。',
            'sub_category.required' =>'入力必須項目です。',
            'sub_category.max' =>'100文字以内で入力してください',
            'sub_category.string' =>'形式が異なります',
            'sub_category.unique' =>'このカテゴリーは既に登録されています。',
        ];
    }
}
