<?php

namespace App\Enums;

enum UnitStatus: string
{
    case Vacant = 'vacant';
    case Occupied = 'occupied';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match($this) {
            self::Vacant => 'Vago (Disponível)',
            self::Occupied => 'Ocupado',
            self::Maintenance => 'Em Manutenção',
        };
    }
}
