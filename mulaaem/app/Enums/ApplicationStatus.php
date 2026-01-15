<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum ApplicationStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Reviewed = 'reviewed';
    case Interview = 'interview';
    case Hired = 'hired';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Reviewed => 'warning',
            self::Interview => 'info',
            self::Hired => 'success',
            self::Rejected => 'danger',
        };
    }
}