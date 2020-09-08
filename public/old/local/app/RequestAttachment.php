<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_request_id
 * @property string $s_url
 * @property string $s_description
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TRequest $tRequest
 */
class RequestAttachment extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_request_attachment';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_request_id', 's_url', 's_description', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
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
