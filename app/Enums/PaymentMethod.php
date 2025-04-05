<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case PIX = 1;
    case CREDIT_CARD = 2;
    case BILLET = 3;

    public function label(): string
    {
        return match ($this) {
            self::CREDIT_CARD => 'Cartão de Crédito',
            self::PIX => 'PIX',
            self::BILLET => 'Boleto',
        };
    }
}
