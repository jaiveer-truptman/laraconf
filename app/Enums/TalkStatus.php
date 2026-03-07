<?php

namespace App\Enums;

enum TalkStatus: int
{
    case REJECTED = 0;
    case APPROVED = 1;
    case SUBMITTED = 2;

    public function label(): string
    {
        return match ($this) {
            self::REJECTED => 'Rejected',
            self::APPROVED => 'Approved',
            self::SUBMITTED => 'Submitted',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::REJECTED => 'danger',
            self::APPROVED => 'success',
            self::SUBMITTED => 'warning',
        };
    }
}
