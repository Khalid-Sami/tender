<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_offer_id
 * @property integer $fk_i_item_id
 * @property integer $i_quantity
 * @property double $d_price
 * @property string $s_note
 * @property integer $b_enabled
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property string $dt_created_date
 */
class OfferItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_offer_items';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_offer_id','fk_i_item_id', 'i_quantity', 'd_price','s_note','b_enabled','dt_created_date','dt_modified_date','dt_deleted_date'];

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

    public function offer()
    {
        return $this->belongsTo('App\Offer', 'fk_i_offer_id', 'pk_i_id');
    }

    public function item()
    {
        return $this->belongsTo('App\ItemsView', 'fk_i_item_id', 'pk_i_id');
    }



}
