<?php

namespace App\Enums;

enum ContractStatus: string
{
    case Active = 'active';
    case ExpiringSoon = 'expiring_soon';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match($this) {
            self::Active => 'Ativo',
            self::ExpiringSoon => 'Vencendo em Breve',
            self::Terminated => 'Encerrado',
        };
    }
}
