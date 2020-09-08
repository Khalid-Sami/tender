<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_by_user_id
 * @property integer $fk_i_currency_id
 * @property string $s_title
 * @property string $s_description
 * @property integer $b_enabled
 * @property string $dt_open_date
 * @property string $dt_close_date
 * @property string $dt_created_date
 */
class ReverseAuction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_reverse_auction';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','s_title','s_description', 'dt_open_date', 'dt_close_date','fk_i_currency_id','fk_i_by_user_id','b_enabled','dt_created_date'];

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

    public function status(){
        return $this->belongsTo('App\ConstantView', 'i_status', 'pk_i_id');
    }

    public function auctionITem(){
        return $this->hasOne('App\ReverseAuctionItem', 'fk_i_auction_id','pk_i_id');
    }

    public function attachments(){
        return $this->hasMany('App\Attachments', 'fk_i_refe_id','pk_i_id')->where('i_attach_type',5);
    }

    public function auctionProposals(){
        return $this->hasMany('App\ReverseAuctionProposal', 'fk_i_auction_id','pk_i_id');
    }

    public function auctionProposalOffers(){
        return $this->hasMany('App\ReverseAuctionProposalItem', 'fk_i_auction_id','pk_i_id')->orderBy('dt_created_date', 'asc');
    }

    public function accetpoffer(){
        return $this->belongsTo('App\ReverseAuctionProposal', 'i_accept_offer', 'pk_i_id')->with(['company']);
    }

}
