<?php

namespace App\Enums;

enum PropertyType: string
{
    case SingleFamily = 'single_family';
    case MultiFamily = 'multi_family';
    case Commercial = 'commercial';

    // A helper method for clean UI labels
    public function label(): string
    {
        return match($this) {
            self::SingleFamily => 'Casa',
            self::MultiFamily => 'Quitinete / Condominio',
            self::Commercial => 'Sala Comercial',
        };
    }
}
