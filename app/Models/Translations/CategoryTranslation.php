<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'category_translations';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'locale',
        'name',
        'short_description',
        'description',
    ];
}