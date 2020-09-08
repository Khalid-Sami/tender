<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_cat_id
 * @property integer $i_parent_cat_id
 * @property integer $i_type
 * @property integer $i_unit
 * @property integer $i_currency
 * @property double $d_price
 * @property string $s_name_ar
 * @property string $s_name_en
 * @property string $s_photo
 * @property string $s_description
 * @property string $s_barcode
 * @property integer $b_enabled
 * @property string $dt_created_at
 * @property string dt_modified_date
 */
class ItemsView extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_items';
    public $timestamps= false;

    /**
     * @var array
     */
//    protected $fillable = ['fk_i_cat_id', 'i_type', 'i_unit', 'i_currency','d_price','s_name_ar','s_name_en','s_photo','s_barcode', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function tServiceProvider()
//    {
//        return $this->belongsTo('App\TServiceProvider', 'fk_i_service_provider_id', 'pk_i_id');
//    }

    public function category()
    {
        return $this->belongsTo('App\CategoryView', 'fk_i_cat_id', 'pk_i_id');
    }

    public function unit(){
        return $this->belongsTo('App\ConstantView', 'i_unit', 'pk_i_id');
    }

    public function type(){
        return $this->belongsTo('App\ConstantView', 'i_type', 'pk_i_id');
    }

}
