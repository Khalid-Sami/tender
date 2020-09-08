<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_auction_id
 * @property integer $fk_i_item_id
 * @property string $i_quantity
 * @property string $s_description
 * @property string $s_notes
 * @property integer $b_enabled
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property string $dt_created_date
 */
class ReverseAuctionItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_reverse_auction_item';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_auction_id','fk_i_item_id', 'i_quantity', 's_notes', 'dt_created_date','dt_modified_date','dt_deleted_date','b_enabled'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
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

    public function reverseAuction(){
        return $this->belongsTo('App\ReverseAuction', 'fk_i_auction_id', 'pk_i_id');
    }

}
