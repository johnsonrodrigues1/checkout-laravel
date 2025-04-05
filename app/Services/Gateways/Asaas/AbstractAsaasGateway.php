<?php

namespace App\Services\Gateways\Asaas;

abstract class AbstractAsaasGateway
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('payments.asaas.base_url');
        $this->apiKey = config('payments.asaas.api_key');
    }
}
