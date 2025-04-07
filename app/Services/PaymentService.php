<?php

namespace App\Services;

use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\Gateways\Asaas\AsaasPaymentGateway;

class PaymentService
{
    protected PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function create(array $data): Payment
    {
        return $this->paymentRepository->create($data);
    }


    public function processPayment(array $data): array
    {
        $asaasPaymentGateway = app(AsaasPaymentGateway::class);
        return $asaasPaymentGateway->createPayment($data);
    }
}
