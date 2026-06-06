<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class SalesUnitTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'sales_unit_translations';

    protected $fillable = [
        'sales_unit_id',
        'locale',
        'name',
    ];
}