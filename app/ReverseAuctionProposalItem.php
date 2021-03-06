<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_auction_proposal_id
 * @property integer $fk_i_tender_item_id
 * @property integer $i_quantity
 * @property double $d_price
 * @property double $d_total
 * @property integer $b_is_different
 * @property string $s_note
 * @property integer $b_enabled
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property string $dt_created_date
 */
class ReverseAuctionProposalItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_reverse_auction_proposal_items';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_auction_id','fk_i_auction_proposal_id','fk_i_auction_item_id', 'i_quantity', 'd_price','d_total','b_is_different','s_note','b_enabled','dt_created_date','dt_modified_date','dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function auctionProposal()
    {
        return $this->belongsTo('App\ReverseAuctionProposal', 'fk_i_auction_proposal_id', 'pk_i_id');
    }

    public function auctionProposalItem()
    {
        return $this->belongsTo('App\ItemView', 'fk_i_auction_item_id', 'pk_i_id');
    }

    public function auctionItem(){
        return $this->hasOne('App\ReverseAuctionItem', 'fk_i_auction_item_id', 'pk_i_id');
    }


}
