<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_user_id
 * @property integer $fk_i_service_id
 * @property string $s_description
 * @property integer $i_quotation_no
 * @property string $dt_start_time
 * @property string $dt_end_time
 * @property integer $i_status
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TServiceProvider $tServiceProvider
 * @property TRequestAttachment[] $tRequestAttachments
 * @property TRequestHistory[] $tRequestHistories
 * @property TRequestQuestionAnswer[] $tRequestQuestionAnswers
 * @property TRequestQuotation[] $tRequestQuotations
 */
class Request extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_request';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_user_id', 'fk_i_service_id', 's_description', 'i_quotation_no', 'dt_start_time', 'dt_end_time', 'i_status', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public function service(){
        return $this->belongsTo('App\ServiceView','fk_i_service_id','pk_i_id');
    }
    public function user(){
        return $this->belongsTo('App\User','fk_i_user_id','pk_i_id');
    }
    public function status(){
        return $this->belongsTo('App\ConstantView','i_status','pk_i_id');
    }




}
