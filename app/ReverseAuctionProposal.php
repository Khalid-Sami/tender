<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer fk_i_auction_id
 * @property integer $fk_i_company_id
 * @property string $s_notes
 * @property string $i_status
 * @property integer $b_enabled
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property string $dt_created_date
 */
class ReverseAuctionProposal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_reverse_auction_proposals';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_auction_id','s_notes', 'fk_i_company_id', 'i_status','b_enabled','dt_created_date','dt_modified_date','dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function auction()
    {
        return $this->belongsTo('App\ReverseAuction', 'fk_i_auction_id', 'pk_i_id')->with(['status']);
    }

    public function company()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_company_id', 'pk_i_id');
    }

    public function companyUser(){
        return $this->belongsTo('App\ServiceProviderUser', 'fk_i_company_id', 'fk_i_service_provider_id');
    }

    public function item(){
        return $this->hasOne('App\ReverseAuctionItem', 'fk_i_auction_id','fk_i_auction_id');
    }

    public function attachments(){
        return $this->hasMany('App\Attachments', 'fk_i_refe_id','pk_i_id')->where('i_attach_type',6);
    }

    public function status(){
        return $this->belongsTo('App\ConstantView', 'i_status', 'pk_i_id');
    }

    public function reverseAuctionProposalItem(){
        return $this->hasOne('App\ReverseAuctionProposalItem', 'fk_i_auction_proposal_id','pk_i_id');
    }

}
