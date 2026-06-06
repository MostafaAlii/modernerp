<?php
namespace App\Enums\Stock;

enum StockMovementType: int
{
    case PURCHASE   = 1;
    case SALE       = 2;
    case RETURN     = 3;
    case ADJUSTMENT = 4;

    public function label(): string
    {
        return match ($this) {
            self::PURCHASE   => trans('dashboard/stock.movement_purchase'),
            self::SALE       => trans('dashboard/stock.movement_sale'),
            self::RETURN     => trans('dashboard/stock.movement_return'),
            self::ADJUSTMENT => trans('dashboard/stock.movement_adjustment'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PURCHASE   => '<span class="badge bg-success">' . $this->label() . '</span>',
            self::SALE       => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::RETURN     => '<span class="badge bg-warning">' . $this->label() . '</span>',
            self::ADJUSTMENT => '<span class="badge bg-info">'    . $this->label() . '</span>',
        };
    }

    public function isIn(): bool
    {
        return in_array($this, [self::PURCHASE, self::RETURN]);
    }

    public function isOut(): bool
    {
        return in_array($this, [self::SALE]);
    }
}