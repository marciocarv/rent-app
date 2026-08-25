<?php

namespace App\Enums;

enum PlanTier: string
{
    case Free = 'free';
    case Basic = 'basic';
    case Premium = 'premium';

    public function label(): string
    {
        return match($this) {
            self::Free => 'Grátis (1 Imóvel)',
            self::Basic => 'Básico (Até 3 Imóveis)',
            self::Premium => 'Premium (Ilimitado)',
        };
    }
}
