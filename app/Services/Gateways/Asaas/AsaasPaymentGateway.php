<?php

namespace App\Services\Gateways\Asaas;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasPaymentGateway extends AbstractAsaasGateway
{
    public function createPayment(array $data): array
    {

        return match ($data['billing_type']) {
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
        $payload = $this->buildBasePayload($data, 'BOLETO');
        return $this->sendRequest($payload);
    }

    protected function createPixPayment(array $data): array
    {
        $payload = $this->buildBasePayload($data, 'PIX');
        return $this->sendRequest($payload);
    }

    protected function createCreditCardPayment(array $data): array
    {
        $payload = $this->buildBasePayload($data, 'CREDIT_CARD');


        $creditCardHolderInfo = $data['creditCard']['creditCardHolderInfo'];
        $creditCard = $data['creditCard']['creditCardInfo'];

        $payload = array_merge($payload, [
            'creditCardHolderInfo' => [
                'name' => $creditCardHolderInfo['customer_name'],
                'email' => $creditCardHolderInfo['customer_email'],
                'cpfCnpj' => $creditCardHolderInfo['customer_document'],
                'postalCode' => $creditCardHolderInfo['customer_postal_code'],
                'addressNumber' => $creditCardHolderInfo['customer_address_number'],
                'phone' => $creditCardHolderInfo['customer_phone']
            ],
            'creditCard' => [
                'holderName' => $creditCard['holder_name'],
                'number' => $creditCard['card_number'],
                'expiryMonth' => $creditCard['expiration_month'],
                'expiryYear' => $creditCard['expiration_year'],
                'ccv' => $creditCard['security_code'],
            ],
        ]);

        return $this->sendRequest($payload);
    }


    private function buildBasePayload(array $data, string $billingType): array
    {
        return [
            'customer' => $data['customer'],
            'billingType' => $billingType,
            'value' => $data['amount'],
            'dueDate' => $data['due_date'],
            'externalReference' => $data['external_reference'],
            'remoteIp' => $data['remote_ip'],
        ];
    }

    protected function sendRequest(array $payload): array
    {
        try {
            $responseAsaas = Http::withHeaders([
                'access_token' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])->post($this->baseUrl . "/payments", $payload);

            if ($responseAsaas->failed()) {
                $response = json_decode($responseAsaas->body(), true);
                if (isset($response['errors'])) {
                    $errorMessage = implode(', ', array_map(fn($error) => $error['description'], $response['errors']));
                    Log::error('Erro na API do Asaas', ['errors' => $errorMessage]);
                    return [
                        'error' => true,
                        'message' => $errorMessage
                    ];
                }
            }

            $response = json_decode($responseAsaas->body(), true);
            return [
                'error' => false,
                'message' => 'Pagamento processado com sucesso.',
                'payment' => $response
            ];
        } catch (Exception $e) {
            Log::error('Exception ao integrar com o Asaas: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Erro ao processar o pagamento.'
            ];
        }
    }
}
