<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required', 'array'],
            'condition_id' => ['required'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0', 'max:9999999'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '商品画像はjpegまたはpng形式で選択してください',
            'categories.required' => '商品のカテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
            'price.max' => '販売価格は9,999,999円以下で入力してください',
        ];
    }
}