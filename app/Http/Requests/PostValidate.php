<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "content" => "required|max:140",
            "image" => "required|image",
            "tag1" => "max:10",
            "tag2" => "max:10",
        ];
    }

    public function messages()
    {
        return [
            "content.required" => "コンテンツは必須入力です",
            "content.max" => "コンテンツは140文字以内で入力してください",
            "image.required" => "画像をアップロードしてください",
            "image.image" => "Image形式の写真をアップロードしてください",
            "tag1.max" => "タグは10文字以内で入力してください",
            "tag2.max" => "タグは10文字以内で入力してください",
        ];
        
    }
}
