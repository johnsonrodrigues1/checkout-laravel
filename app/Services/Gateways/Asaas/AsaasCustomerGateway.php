<?php

namespace App\Services\Gateways\Asaas;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasCustomerGateway extends AbstractAsaasGateway
{
    public function create(array $payload): ?array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])->post("{$this->baseUrl}/customers", $payload);

            if ($response->failed()) {

                Log::error('Erro na API do Asaas (Customer)', ['response' => $response->body()]);
                return null;
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Exception ao integrar com o Asaas (Customer): ' . $e->getMessage());
            return null;
        }
    }
}
