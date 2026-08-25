<?php

namespace App\Enums;

enum ContractStatus: string
{
    case Draft = 'draft';
    case PendingSignatures = 'pending_signatures';
    case Active = 'active';
    case ExpiringSoon = 'expiring_soon';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match($this) {
            self::Draft => 'Rascunho',
            self::PendingSignatures => 'Aguardando Assinaturas',
            self::Active => 'Ativo',
            self::ExpiringSoon => 'Vencendo em Breve',
            self::Terminated => 'Encerrado',
        };
    }

    // Optional: A helpful method to check if the contract is locked from editing
    public function isLocked(): bool
    {
        return match($this) {
            self::Draft => false,
            default => true,
        };
    }
}
