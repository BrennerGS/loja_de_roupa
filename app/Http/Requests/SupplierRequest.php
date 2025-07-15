<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier'); // ou 'id', dependendo da sua rota

        return [
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'cnpj' => [
                'required',
                'string',
                'max:14',
                Rule::unique('suppliers', 'cnpj')->ignore($supplierId),
            ],
            'products_provided' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'cnpj.unique' => 'Este CNPJ já está cadastrado',
            'email.unique' => 'Este e-mail já está em uso',
            'state.max' => 'O estado deve ter 2 caracteres (ex: SP)',
        ];
    }
}
