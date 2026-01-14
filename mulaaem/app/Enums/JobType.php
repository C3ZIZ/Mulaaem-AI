<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JobType: string implements HasLabel
{
    case FullTime = 'full-time';
    case PartTime = 'part-time';
    case Contract = 'contract';
    case Remote = 'remote';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FullTime => 'Full Time',
            self::PartTime => 'Part Time',
            self::Contract => 'Contract',
            self::Remote => 'Remote',
        };
    }
}