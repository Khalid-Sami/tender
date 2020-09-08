<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_option_id
 * @property integer $fk_i_question_id
 * @property integer $fk_i_service_id
 * @property integer $fk_i_service_provider_id
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TServiceQuestionOption $tServiceQuestionOption
 * @property TServiceQuestion $tServiceQuestion
 * @property TSpService $tSpService
 * @property TServiceProvider $tServiceProvider
 */
class SPQuestionAnswer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_sp_question_answer';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['fk_i_option_id', 'fk_i_question_id', 'fk_i_service_id', 'fk_i_service_provider_id', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceQuestionOption()
    {
        return $this->belongsTo('App\ServiceQuestionOption', 'fk_i_service_provider_id', 'pk_i_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo('App\ServiceProviderView', 'fk_i_option_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceQuestion()
    {
        return $this->belongsTo('App\ServiceQuestion', 'fk_i_question_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\SpService', 'fk_i_service_id', 'fk_i_service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tServiceProvider()
    {
        return $this->belongsTo('App\TServiceProvider', 'fk_i_service_provider_id', 'pk_i_id');
    }
}
