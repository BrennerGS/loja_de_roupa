<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,'.$this->route('client'),
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'cpf' => 'nullable|string|max:14|unique:clients,cpf,'.$this->route('client'),
            'birth_date' => 'nullable|date',
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'email.email' => 'Informe um e-mail válido',
            'email.unique' => 'Este e-mail já está em uso',
            'phone.required' => 'O telefone é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
        ];
    }
    
}
