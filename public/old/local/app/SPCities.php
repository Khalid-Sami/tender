<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $fk_i_service_provider_id
 * @property integer $fk_i_city_id
 * @property string $dt_created_date
 * @property TServiceProvider $tServiceProvider
 */
class SPCities extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_sp_cities';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['dt_created_date','fk_i_service_provider_id','fk_i_city_id'];

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
