<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property string $s_title
 * @property integer $fk_i_company_id
 * @property integer $i_status
 * @property string $s_notes
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 */
class Offer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_offer';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','s_title','fk_i_company_id','i_status','i_currency', 's_notes', 'dt_created_date','dt_modified_date','dt_deleted_date','b_enabled'];

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

    public function company()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_company_id', 'pk_i_id');
    }

    public function status(){
        return $this->belongsTo('App\ConstantView', 'i_status', 'pk_i_id');
    }

    public function currency(){
        return $this->belongsTo('App\ConstantView', 'i_currency', 'pk_i_id');
    }

    public function items(){
        return $this->hasMany('App\OfferItems', 'fk_i_offer_id','pk_i_id');
    }

    public function attachment(){
        return $this->belongsTo('App\Attachments', 'pk_i_id', 'fk_i_refe_id')->where('i_attach_type',4);
    }

    public function userCompany(){
        return $this->belongsTo('App\ServiceProviderUser', 'fk_i_company_id', 'fk_i_service_provider_id')->with(['user']);
    }

}
