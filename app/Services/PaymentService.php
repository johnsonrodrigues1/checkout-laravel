<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
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


        $this->paymentRepository->create($data);


       $asaasPaymentGateway = app(AsaasPaymentGateway::class);





        $gatewayResponse = $asaasPaymentGateway->createPayment($data);

        $paymentData = [
            'order_id'            => $data['order_id'],
            'customer_id'         => $data['customer_id'],
            'payment_type'        => $data['payment_type'],
            'amount'              => $data['amount'],
            'status'              => isset($gatewayResponse['error']) ? 'failed' : 'completed',
            'acquirer_payment_id' => $gatewayResponse['id'] ?? null,
            'response_data'       => json_encode($gatewayResponse),
        ];

        $payment = $this->paymentRepository->create($paymentData);

        return [
            'payment'  => $payment,
            'response' => $gatewayResponse,
        ];
    }
}
