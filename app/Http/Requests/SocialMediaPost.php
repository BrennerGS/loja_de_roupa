<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaPost extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'platform' => 'required|in:facebook,instagram,twitter,linkedin,tiktok',
            'content' => 'required|string|max:2000',
            'scheduled_at' => 'nullable|date|after_or_equal:now',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'is_published' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'platform.in' => 'Plataforma de rede social inválida',
            'content.max' => 'O conteúdo não pode exceder 2000 caracteres',
            'image.max' => 'A imagem não pode ser maior que 5MB',
        ];
    }
}
