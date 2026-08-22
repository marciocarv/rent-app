<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case Single = 'single';
    case Married = 'married';
    case Divorced = 'divorced';
    case Widowed = 'widowed';
    case StableUnion = 'stable_union';

    public function label(): string
    {
        return match($this) {
            self::Single => 'Solteiro(a)',
            self::Married => 'Casado(a)',
            self::Divorced => 'Divorciado(a)',
            self::Widowed => 'Viúvo(a)',
            self::StableUnion => 'União Estável',
        };
    }
}
