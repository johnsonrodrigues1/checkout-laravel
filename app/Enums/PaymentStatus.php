<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case CREATED = 1;
    case PENDING = 2;
    case PAID = 3;
    case CANCELLED = 4;
    case REFUNDED = 5;

    public function label(): string
    {
        return match ($this) {
            self::CREATED => 'Criado',
            self::PENDING => 'Pendente',
            self::PAID => 'Pago',
            self::CANCELLED => 'Cancelado',
            self::REFUNDED => 'Reembolsado',
        };
    }
}
