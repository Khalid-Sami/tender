<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_refe_id
 * @property integer $i_attach_type
 * @property string $s_url
 * @property string $s_name
 * @property string $s_description
 * @property integer $b_enabled
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property string $dt_created_date
 */
class Attachments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_attachments';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_refe_id','i_attach_type', 's_url','s_name', 's_description','b_enabled','dt_created_date','dt_modified_date','dt_deleted_date'];

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
        return $this->belongsTo('App\Tender', 'fk_i_refe_id', 'pk_i_id');
    }

    public function tenderProposal()
    {
        return $this->belongsTo('App\TenderProposal', 'fk_i_refe_id', 'pk_i_id');
    }

    public function supplier(){
        return $this->belongsTo('App\SuppliersOffers', 'fk_i_refe_id', 'pk_i_id');
    }
    
}
