<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_tender_id
 * @property integer $fk_i_company_id
 * @property string $s_notes
 * @property string $i_status
 * @property integer $b_enabled
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property string $dt_created_date
 */
class TenderProposal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_tender_proposals';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_tender_id','s_notes', 'fk_i_company_id', 'i_status','b_enabled','dt_created_date','dt_modified_date','dt_deleted_date'];

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

    public function tender()
    {
        return $this->belongsTo('App\Tender', 'fk_i_tender_id', 'pk_i_id')->with(['status']);
    }

    public function company()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_company_id', 'pk_i_id');
    }
    public function companyWithAddress()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_company_id', 'pk_i_id')->with(['city', 'country']);
    }

    public function companyUser(){
        return $this->belongsTo('App\ServiceProviderUser', 'fk_i_company_id', 'fk_i_service_provider_id');
    }

    public function tenderItems(){
        return $this->hasMany('App\TenderItems', 'fk_i_tender_id','fk_i_tender_id');
    }

    public function attachments(){
        return $this->hasMany('App\Attachments', 'fk_i_refe_id','pk_i_id')->where('i_attach_type',2);
    }

    public function status(){
        return $this->belongsTo('App\ConstantView', 'i_status', 'pk_i_id');
    }

    public function tenderProposalItems(){
        return $this->hasMany('App\TenderProposalItems', 'fk_i_tender_proposal_id','pk_i_id')->with(['tenderItems']);

//        return TenderProposalItems::where('fk_i_tender_proposal_id',$this->pk_i_id)->sum('d_total');
    }

    public function proposalItems(){
        return $this->hasMany('App\TenderProposalItems', 'fk_i_tender_proposal_id','pk_i_id')->first(['d_price As price', 'i_quantity As quantity']);

//        return TenderProposalItems::where('fk_i_tender_proposal_id',$this->pk_i_id)->sum('d_total');
    }

}
