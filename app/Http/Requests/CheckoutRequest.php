<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'document' => [
                'required',
                'string',
                'max:18',
                'min:12',
            ],
            'email' => 'required|email',
            'phone' => [
                'required',
                'string',
                'min:16',
                'max:16',
            ],
            'payment_method' => 'required|in:1,2,3',
        ];

        if ($this->input('payment_method') === '2') {
            $rules = array_merge($rules, [
                'address' => 'sometimes|nullable|string|max:255',
                'address_number' => 'sometimes|nullable|string|max:255',
                'address_complement' => 'sometimes|nullable|string|max:255',
                'postal_code' => 'sometimes|nullable|string|max:10',
                'holder_name' => 'required|string|max:255',
                'card_number' => 'required',
                'expiration_month' => 'required|digits:2|integer|min:1|max:12',
                'expiration_year' => 'required|digits:2',
                'security_code' => 'required|digits:3',
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'product_id.required' => 'O campo produto é obrigatório.',
            'document.required' => 'O campo CPF/CNPJ é obrigatório.',
            'document.max' => 'O CPF/CNPJ deve conter no máximo 14 dígitos.',
            'document.min' => 'O CPF/CNPJ deve conter no mínimo 11 dígitos.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.min' => 'O telefone deve conter 11 dígitos.',
            'phone.max' => 'O telefone deve conter 15 dígitos.',
            'payment_method.required' => 'Selecione uma forma de pagamento.',
            'payment_method.in' => 'Forma de pagamento inválida.',
            'holder_name.required' => 'O nome impresso no cartão é obrigatório.',
            'card_number.required' => 'O número do cartão é obrigatório.',
            'expiration_month.required' => 'O mês de expiração é obrigatório.',
            'expiration_month.digits' => 'O mês de expiração deve conter 2 dígitos.',
            'expiration_month.min' => 'O mês de expiração deve ser entre 01 e 12.',
            'expiration_month.max' => 'O mês de expiração deve ser entre 01 e 12.',
            'expiration_year.required' => 'O ano de expiração é obrigatório.',
            'expiration_year.digits' => 'O ano de expiração deve conter 2 dígitos.',
            'security_code.required' => 'O código de segurança é obrigatório.',
            'security_code.digits' => 'O código de segurança deve conter 3 dígitos.',
        ];
    }
}
