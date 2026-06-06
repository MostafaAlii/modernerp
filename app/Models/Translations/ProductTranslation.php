<?php
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'product_translations';

    protected $fillable = [
        'product_id',
        'locale',
        'name',
        'description',
    ];
}