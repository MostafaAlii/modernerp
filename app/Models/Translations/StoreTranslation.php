<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class StoreTranslation extends Model
{
    protected $table = 'store_translations';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'locale',
        'store_id'
    ];
}