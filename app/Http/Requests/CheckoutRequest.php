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
            'payment-method' => 'required|in:1,2,3',
        ];

        if ($this->input('payment-method') === '2') {
            $rules = array_merge($rules, [
                'holder-name' => 'required|string|max:255',
                'card-number' => 'required|digits:16',
                'expiration-month' => 'required|digits:2|integer|min:1|max:12',
                'expiration-year' => 'required|digits:2',
                'security-code' => 'required|digits:3',
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
            'payment-method.required' => 'Selecione uma forma de pagamento.',
            'payment-method.in' => 'Forma de pagamento inválida.',
            'holder-name.required' => 'O nome impresso no cartão é obrigatório.',
            'card-number.required' => 'O número do cartão é obrigatório.',
            'card-number.digits' => 'O número do cartão deve conter 16 dígitos.',
            'expiration-month.required' => 'O mês de expiração é obrigatório.',
            'expiration-month.digits' => 'O mês de expiração deve conter 2 dígitos.',
            'expiration-month.min' => 'O mês de expiração deve ser entre 01 e 12.',
            'expiration-month.max' => 'O mês de expiração deve ser entre 01 e 12.',
            'expiration-year.required' => 'O ano de expiração é obrigatório.',
            'expiration-year.digits' => 'O ano de expiração deve conter 2 dígitos.',
            'security-code.required' => 'O código de segurança é obrigatório.',
            'security-code.digits' => 'O código de segurança deve conter 3 dígitos.',
        ];
    }
}
