<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'brand' => 'required|string|max:191',
            'price' => 'required|integer',
            'description' => 'required|string|max:400',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'condition_id' => 'required|integer',
            'parent_category' => 'required|exists:categories,id',
            'category' => 'required|array',
            'category.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'name.string' => '商品名は文字列で入力してください。',
            'name.max' => '商品名は191文字以内で入力してください。',
            'brand.required' => 'ブランド名を入力してください。',
            'brand.string' => 'ブランド名は文字列で入力してください。',
            'brand.max' => 'ブランド名は191文字以内で入力してください。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格を半角の数字で入力してください。',
            'description.required' => '商品説明を入力してください。',
            'description.string' => '商品説明は文字列で入力してください。',
            'description.max' => '商品説明は400文字以内で入力してください。',
            'img_url.required' => '画像ファイルをアップロードしてください。',
            'img_url.image' => '画像ファイルをアップロードしてください。',
            'img_url.mimes' => 'アップロードできる画像ファイルは、jpeg、png、jpg、gif、またはsvg形式のみです。',
            'img_url.max' => '画像ファイルのサイズは最大2MBまでです。',
            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.integer' => '商品の状態に正しい値を選択してください。',
            'condition_id.exists' => '選択された商品の状態が無効です。',
            'parent_category.required' => '親カテゴリを選択してください。',
            'parent_category.exists' => '選択された親カテゴリが無効です。',
            'category.required' => '少なくとも1つの子カテゴリを選択してください。',
            'category.array' => 'カテゴリは配列で指定してください。',
            'category.*.exists' => '子カテゴリを選択してください。',
        ];
    }
}
