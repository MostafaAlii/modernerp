<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class InvUomTranslation extends Model
{
    protected $table = 'inv_uom_translations';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'locale',
        'inv_uom_id'
    ];
}