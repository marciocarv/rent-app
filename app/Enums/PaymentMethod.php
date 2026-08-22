<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Pix = 'pix';
    case Boleto = 'boleto';
    case BankTransfer = 'bank_transfer';

    public function label(): string
    {
        return match($this) {
            self::Pix => 'PIX',
            self::Boleto => 'Boleto Bancário',
            self::BankTransfer => 'Depósito / Transferência Bancária',
        };
    }
}
