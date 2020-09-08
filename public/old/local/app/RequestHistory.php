<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_request_id
 * @property integer $fk_i_user_id
 * @property string $s_title_en
 * @property string $s_title_ar
 * @property integer $i_status
 * @property string $dt_created_date
 * @property TRequest $tRequest
 */
class RequestHistory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_request_history';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_request_id', 'fk_i_user_id', 's_title_en', 's_title_ar', 'i_status', 'dt_created_date'];


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
}
