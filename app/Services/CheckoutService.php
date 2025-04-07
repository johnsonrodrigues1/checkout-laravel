<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Helpers\FieldCleanerHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    protected CustomerService $customerService;
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(CustomerService $customerService, OrderService $orderService, PaymentService $paymentService)
    {
        $this->customerService = $customerService;
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }


    public function processCheckout(array $data)
    {
        DB::beginTransaction();
        try {
            $customer = $this->customerService->findOrCreate([
                'name' => $data['name'],
                'document' => FieldCleanerHelper::sanitize($data['document']),
                'email' => $data['email'],
                'phone' => FieldCleanerHelper::sanitize($data['phone']),
                'address' => $data['address'] ?? null,
                'address_number' => $data['address_number'] ?? null,
                'address_complement' => $data['address_complement'] ?? null,
                'postal_code' => FieldCleanerHelper::sanitize($data['postal_code'] ?? null),
            ]);


            $order = $this->orderService->create([
                'customer_id' => $customer->id,
                'total' => $data['product']['price'],
                'status' => PaymentStatus::PENDING,
                'payment_method' => $data['payment_method'],
                'order_items' => [
                    [
                        'product_id' => $data['product']['id'],
                        'quantity' => 1,
                        'price' => $data['product']['price'],
                    ],
                ],
            ]);

            $payment = $this->paymentService->create([
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'payment_method' => $order->payment_method,
                'amount' => $order->total,
                'status' => PaymentStatus::PENDING,
            ]);

            $paymentProcessData = [
                'customer' => $customer->external_id,
                'document' => $customer->document,
                'external_reference' => $payment->id,
                'billing_type' => $payment->payment_method->value,
                'amount' => $payment->amount,
                'due_date' => Carbon::now()->format('Y-m-d'),
                'remote_ip' => request()->ip(),
            ];

            if ($payment->payment_method->value == PaymentMethod::CREDIT_CARD->value) {
                $paymentProcessData['creditCard'] = [
                    'creditCardHolderInfo' => [
                        'customer_name' => $customer->name,
                        'customer_email' => $customer->email,
                        'customer_document' => $customer->document,
                        'customer_postal_code' => $customer->postal_code,
                        'customer_address_number' => $customer->address_number,
                        'customer_phone' => $customer->phone,
                    ],
                    'creditCardInfo' => [
                        'holder_name' => $data['holder_name'],
                        'card_number' => $data['card_number'],
                        'expiration_month' => $data['expiration_month'],
                        'expiration_year' => $data['expiration_year'],
                        'security_code' => $data['security_code'],
                    ],
                ];
            }

            $result = $this->paymentService->processPayment($paymentProcessData);

            if (!$result['error']) {
                $payment->update([
                    'external_payment_id' => $result['payment']['id'],
                    'response_data' => $result['payment'],
                    'status' => $result['payment']['status'] == 'CONFIRMED' ? PaymentStatus::PAID : PaymentStatus::PENDING,
                ]);
            }

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


}
