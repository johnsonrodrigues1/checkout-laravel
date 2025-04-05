<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $payment = Payment::find($id);
        return $payment ? $payment->update($data) : false;
    }

    public function findById(int $id): ?Payment
    {
        return Payment::find($id);
    }
}
