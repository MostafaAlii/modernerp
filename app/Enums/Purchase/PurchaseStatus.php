<?php

namespace App\Enums\Purchase;

enum PurchaseStatus: int
{
    case DRAFT     = 1;
    case CONFIRMED = 2;
    case CANCELLED = 3;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT     => trans('dashboard/purchases.status_draft'),
            self::CONFIRMED => trans('dashboard/purchases.status_confirmed'),
            self::CANCELLED => trans('dashboard/purchases.status_cancelled'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::DRAFT     => '<span class="badge bg-warning">'  . $this->label() . '</span>',
            self::CONFIRMED => '<span class="badge bg-success">'  . $this->label() . '</span>',
            self::CANCELLED => '<span class="badge bg-danger">'   . $this->label() . '</span>',
        };
    }

    public function isConfirmed(): bool
    {
        return $this === self::CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }
}
