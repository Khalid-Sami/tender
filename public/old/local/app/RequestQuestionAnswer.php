<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_request_id
 * @property integer $fk_i_question_id
 * @property integer $fk_i_service_question_option_id
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TRequest $tRequest
 */
class RequestQuestionAnswer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_request_question_answer';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['fk_i_request_id', 'fk_i_question_id', 'fk_i_service_question_option_id', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];


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

    public function serviceQuestion()
    {
        return $this->belongsTo('App\ServiceQuestionView', 'fk_i_question_id', 'pk_i_id');
    }

    public function serviceQuestionOption()
    {
        return $this->belongsTo('App\ServiceQuestionOptionsView', 'fk_i_service_question_option_id', 'pk_i_id');
    }
}
