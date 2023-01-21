<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterFormRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $birth_day = ($this->filled(['old_year', 'old_month','old_day'])) ? $this->old_year .'-'. $this->old_month .'-'. $this->old_day : ' ';
        $this->merge([
           'birth_day' => $birth_day
        ]);
    }

    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ァ-ヾ 〜ー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'mail_address' => 'required|string|email|max:100|unique:users',
            'sex' => 'required|between:1,3',
            'old_year' => 'required',
            'old_month' => 'required',
            'old_day' =>'required',
            'birth_day' => 'before:now|after_or_equal:2000-01-01|date',
            'role' => 'required|between:1,4',
            'password' => 'required|min:8|max:30|string|confirmed',
            'password_confirmation' => 'required|min:8|max:30|string',
        ];
    }

    public function messages(){
        return [
            'over_name.required' => '必須項目です。',
            'over_name.max' => '10文字以内に入力してください。',
            'over_name_kana.required' => '必須項目です。',
            'over_name_kana.max' => '30文字',
            'over_name_kana.regex' => 'カタカナ！！！',
            'under_name.required' => '必須項目です。',
            'under_name.max' => '10文字
            以内に入力してください。',
            'under_name_kana.required' => '必須項目です。',
            'under_name_kana.max' => '30文字
            ',
            'mail_address.required' => '必須項目です。',
            'mail_address.email' => '有効なEメールアドレスを入力してください',
            'mail_address.min' => 'メールアドレスは5文字以上、40文字以下で入力してください',
            'mail_address.max' => 'メールアドレスは5文字以上、40文字以下で入力してください',
            'mail_address.unique' => 'このメールアドレスは既に使われています',
            'sex.required' => '必須項目です。',
            'sex.digits_between' => '無効の選択肢です。',
            'under_name_kana.regex' => 'カタカナ！！！',
            'old_year.required' => '必須項目です。',
            'old_month.required' => '必須項目です。',
            'old_day.required' => '必須項目です。',
            'birth_day.after_or_equal' => '2000年以降でお願いします',
            'birth_day.date' => '存在しない日付です。',
            'role.digits_between' => '無効の選択肢です。',
            'password.required' => '必須項目です',
            'password.min' => '８文字以上30文字以内でお願いします',
            'password.max' => '８文字以上30文字以内でお願いします',
            'password.confirmed' => '確認パスワードが一致しません',
            'password_confirmation.required' => '確認パスワードを入力してください',
        ];
    }
}
