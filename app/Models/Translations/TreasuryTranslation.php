<?php
namespace App\Models\Translations;
use Illuminate\Database\Eloquent\Model;
class TreasuryTranslation extends Model {
    protected $table = 'treasury_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'locale',
    ];
}