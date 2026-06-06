<?php
namespace App\Enums\Product;

enum ProductVariantType: int
{
    case SIMPLE     = 0;
    case COLOR      = 1;
    case SIZE       = 2;
    case COLOR_SIZE = 3;

    public function label(): string
    {
        return match ($this) {
            self::SIMPLE     => trans('dashboard/products.variant_type_simple'),
            self::COLOR      => trans('dashboard/products.variant_type_color'),
            self::SIZE       => trans('dashboard/products.variant_type_size'),
            self::COLOR_SIZE => trans('dashboard/products.variant_type_color_size'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::SIMPLE     => '<span class="badge bg-secondary">' . $this->label() . '</span>',
            self::COLOR      => '<span class="badge bg-info">'      . $this->label() . '</span>',
            self::SIZE       => '<span class="badge bg-primary">'   . $this->label() . '</span>',
            self::COLOR_SIZE => '<span class="badge bg-success">'   . $this->label() . '</span>',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function hasColor(): bool
    {
        return in_array($this, [self::COLOR, self::COLOR_SIZE]);
    }

    public function hasSize(): bool
    {
        return in_array($this, [self::SIZE, self::COLOR_SIZE]);
    }

    public function isSimple(): bool
    {
        return $this === self::SIMPLE;
    }
}