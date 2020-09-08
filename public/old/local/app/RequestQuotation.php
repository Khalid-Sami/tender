<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_request_id
 * @property integer $fk_i_service_provider_id
 * @property string $s_description
 * @property float $d_price
 * @property integer $i_status
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TRequest $tRequest
 */
class RequestQuotation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_request_quotation';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['fk_i_request_id', 'fk_i_service_provider_id', 's_description', 'd_price', 'i_status', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request()
    {
        return $this->belongsTo('App\Request', 'fk_i_request_id', 'pk_i_id');
    }
    public function quotationAttachment()
    {
        return $this->hasMany('App\RequestQuotationAttachment', 'fk_i_request_quotation_id', 'pk_i_id');
    }
    
    public function serviceProvider(){
        return $this->belongsTo('App\ServiceProviderView','fk_i_service_provider_id','pk_i_id');
    }
   
}
