<?php
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class ColorTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'color_translations';

    protected $fillable = [
        'color_id',
        'locale',
        'name',
    ];
}