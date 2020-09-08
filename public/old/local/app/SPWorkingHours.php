<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_service_provider_id
 * @property string $t_from
 * @property string $t_to
 * @property integer $i_day
 * @property TServiceProvider $tServiceProvider
 */
class SPWorkingHours extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_sp_working_hours';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';


    /**
     * @var array
     */
    protected $fillable = ['fk_i_service_provider_id', 't_from', 't_to', 'i_day'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tServiceProvider()
    {
        return $this->belongsTo('App\TServiceProvider', 'fk_i_service_provider_id', 'pk_i_id');
    }
}
