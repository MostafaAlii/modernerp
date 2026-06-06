<?php
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class SizeTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'size_translations';

    protected $fillable = [
        'size_id',
        'locale',
        'name',
    ];
}