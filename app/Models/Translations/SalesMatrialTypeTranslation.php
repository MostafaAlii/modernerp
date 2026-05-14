<?php
namespace App\Models\Translations;
use Illuminate\Database\Eloquent\Model;
class SalesMatrialTypeTranslation extends Model {
    protected $table = 'sales_matrial_type_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'locale',
        'sales_matrial_type_id'
    ];
}
