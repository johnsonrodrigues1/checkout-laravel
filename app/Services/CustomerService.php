<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Services\Gateways\Asaas\AsaasCustomerGateway;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function findOrCreate(array $data): Customer
    {
        $customer = $this->customerRepository->findByDocument($data['document']);
        $asaasGateway = app(AsaasCustomerGateway::class);

        if ($customer) {
            if (!empty($customer->external_id)) {
                return $customer;
            }

            $asaasResponse = $asaasGateway->create($this->mountAsaasPayload($data));

            if ($asaasResponse && isset($asaasResponse['id'])) {
                $customer->update(['external_id' => $asaasResponse['id']]);
            } else {
                Log::warning('Falha ao sincronizar o cliente com o Asaas.', ['data' => $data]);
            }

            return $customer;
        }

        $asaasResponse = $asaasGateway->create($this->mountAsaasPayload($data));
        if ($asaasResponse && isset($asaasResponse['id'])) {
            $data['external_id'] = $asaasResponse['id'];
        } else {
            Log::warning('Falha ao criar o cliente no Asaas.', ['data' => $data]);
        }

        return $this->customerRepository->create($data);
    }

    private function mountAsaasPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'cpfCnpj' => $data['document'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'addressNumber' => $data['address_number'] ?? null,
            'addressComplement' => $data['address_complement'] ?? null,
            'postalCode' => $data['postal_code'] ?? null,
        ];
    }
}
