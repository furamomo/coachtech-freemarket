<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],

            'image' => ['required', 'image', 'mimes:jpeg,png,jpg'],

            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['integer', 'exists:categories,id'],

            'condition' => ['required', 'integer', 'between:1,4'],

            'price' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',

            'image.required' => '商品画像をアップロードしてください',
            'image.image' => '商品画像を選択してください',
            'image.mimes' => '商品画像はjpegまたはpng形式でアップロードしてください',

            'category_ids.required' => '商品のカテゴリーを選択してください',
            'category_ids.array' => '商品のカテゴリーを選択してください',
            'category_ids.min' => '商品のカテゴリーを選択してください',
            'category_ids.*.exists' => '選択されたカテゴリーが正しくありません',

            'condition.required' => '商品の状態を選択してください',
            'condition.between' => '商品の状態を正しく選択してください',

            'price.required' => '商品価格を入力してください',
            'price.min' => '商品価格は1円以上で入力してください',
        ];
    }
}
