<?php

namespace App\Enums\InvUom;

enum UomMaster: int
{
    case MASTER = 1;
    case SUB    = 0;

    public function label(): string
    {
        return match ($this) {
            self::MASTER => trans('dashboard/inv_uom.master'),
            self::SUB    => trans('dashboard/inv_uom.sub'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::MASTER => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::SUB    => '<span class="badge bg-secondary">' . $this->label() . '</span>',
        };
    }
}