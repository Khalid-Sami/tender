<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_tender_id
 * @property integer $fk_i_item_id
 * @property string $i_quantity
 * @property string $s_description
 * @property integer $b_enabled
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property string $dt_created_date
 */
class TenderItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_tender_items';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_tender_id','fk_i_item_id', 'i_quantity', 'dt_created_date','dt_modified_date','dt_deleted_date','b_enabled'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
//        $lang = app()->getLocale();
//        DB::statement("SET @s_language_code ='$lang'");
//        Carbon::setLocale($lang);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function currency()
    {
        return $this->belongsTo('App\ConstantView', 'fk_i_currency_id', 'pk_i_id');
    }

    public function item(){
        return $this->belongsTo('App\ItemsView', 'fk_i_item_id', 'pk_i_id');
}

    public function itemName(){
        return $this->belongsTo('App\ItemsView', 'fk_i_item_id', 'pk_i_id')->first(['s_name as name']);
    }

    public function tender(){
        return $this->belongsTo('App\Tender', 'fk_i_tender_id', 'pk_i_id');
    }

}
