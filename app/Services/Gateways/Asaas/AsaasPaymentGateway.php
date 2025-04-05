<?php

namespace App\Services\Gateways\Asaas;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasPaymentGateway extends AbstractAsaasGateway
{
    public function createPayment(int $paymentMethod, array $data): array
    {
        return match ($paymentMethod) {
            1 => $this->createPixPayment($data),
            2 => $this->createCreditCardPayment($data),
            3 => $this->createBilletPayment($data),
            default => [
                'error' => true,
                'message' => 'Tipo de pagamento não suportado.'
            ],
        };
    }


    protected function createBilletPayment(array $data): array
    {
        $payload = [
            'customer' => $data['customer_id'],
            'billingType' => 'BOLETO',
            'value' => $data['amount'],
            'dueDate' => $data['due_date'],
            'externalReference' => $data['order_id'],
            'remoteIp' => $data['remote_ip'],
        ];
        return $this->sendRequest($payload);
    }

    protected function createCreditCardPayment(array $data): array
    {
        $payload = [
            'creditCardHolderInfo' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'cpfCnpj' => $data['customer_document'],
                'postalCode' => $data['customer_postal_code'],
                'addressNumber' => $data['customer_address_number'],
                'phone' => $data['customer_phone']
            ],
            'creditCard' => [
                'holderName' => $data['holder_name'],
                'number' => $data['credit_card_number'],
                'expiryMonth' => $data['credit_card_expiry_month'],
                'expiryYear' => $data['credit_card_expiry_year'],
                'ccv' => $data['credit_card_security_code'],
            ],
            'customer' => $data['customer_id'],
            'billingType' => 'CREDIT_CARD',
            'value' => $data['amount'],
            'dueDate' => $data['due_date'],
            'externalReference' => $data['order_id'],
            'remoteIp' => $data['remote_ip'],
        ];
        return $this->sendRequest($payload);
    }

    protected function createPixPayment(array $data): array
    {
        $payload = [
            'customer' => $data['customer_id'],
            'billingType' => 'PIX',
            'value' => $data['amount'],
            'dueDate' => $data['due_date'],
            'externalReference' => $data['order_id'],
            'remoteIp' => $data['remote_ip'],
        ];
        return $this->sendRequest($payload);
    }

    protected function sendRequest(array $payload): array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])->post($this->baseUrl."/payments", $payload);

            if ($response->failed()) {
                Log::error('Erro na API do Asaas', ['response' => $response->body()]);
                throw new Exception('Erro ao processar o pagamento.');
            }
            return $response->json();
        } catch (Exception $e) {
            Log::error('Exception ao integrar com o Asaas: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Erro ao processar o pagamento.'
            ];
        }
    }
}
