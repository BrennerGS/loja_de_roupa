<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
         $clientId = $this->route('client')?->id;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($clientId)
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients', 'phone')->ignore($clientId)
            ],
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('clients', 'cpf')->ignore($clientId)
            ],
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'O nome do cliente é obrigatório',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro cliente',
            'phone.required' => 'O telefone é obrigatório',
            'phone.unique' => 'Este telefone já está cadastrado',
            'cpf.unique' => 'Este CPF já está cadastrado'
        ];
    }
    
}
