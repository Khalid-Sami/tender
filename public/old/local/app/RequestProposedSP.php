<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_request_id
 * @property integer $fk_i_service_provider_id
 * @property integer $i_replied
 * @property string $dt_replied
 * @property integer $i_notification_type
 */
class RequestProposedSP extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_request_proposed_sp';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_request_id', 'fk_i_service_provider_id', 'i_replied', 'dt_replied', 'i_notification_type'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

}
