<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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

        $productId = $this->route('product');

        $rules = [
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'category_id' => 'required|exists:categories,id',
            'size' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'price' => 'required|numeric|min:0.01|decimal:0,2',
            'cost_price' => 'required|numeric|min:0|decimal:0,2',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'sometimes|boolean',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do produto é obrigatório',
            'sku.required' => 'O SKU é obrigatório',
            'sku.unique' => 'Este SKU já está em uso',
            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'A categoria selecionada é inválida',
            'size.required' => 'O tamanho é obrigatório',
            'color.required' => 'A cor é obrigatória',
            'price.required' => 'O preço de venda é obrigatório',
            'price.min' => 'O preço deve ser maior que zero',
            'price.decimal' => 'O preço deve ter no máximo 2 casas decimais',
            'cost_price.required' => 'O preço de custo é obrigatório',
            'cost_price.min' => 'O preço de custo não pode ser negativo',
            'cost_price.decimal' => 'O preço de custo deve ter no máximo 2 casas decimais',
            'quantity.required' => 'A quantidade em estoque é obrigatória',
            'quantity.min' => 'A quantidade não pode ser negativa',
            'min_quantity.required' => 'O estoque mínimo é obrigatório',
            'min_quantity.min' => 'O estoque mínimo não pode ser negativo',
            'image.image' => 'O arquivo deve ser uma imagem válida',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp',
            'image.max' => 'A imagem não pode ser maior que 2MB',
        ];
    }

    protected function prepareForValidation()
    {
        // Garante que campos numéricos estejam no formato correto
        $this->merge([
            'price' => str_replace(',', '.', $this->price),
            'cost_price' => str_replace(',', '.', $this->cost_price),
            'active' => $this->has('active') ? true : false,
        ]);
    }

}
