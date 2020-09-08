<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestionView extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_service_question';

    /**
     * @var array
     */
    protected $fillable = ['fk_i_service_id', 's_question_ar', 's_question_en', 'i_question_type', 'i_answer_type', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\Service', 'fk_i_service_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionAnswers()
    {
        return $this->hasMany('App\SpQuestionAnswer', 'fk_i_question_id', 'pk_i_id');
    }

    public function questionOptions(){
        return $this->hasMany('App\ServiceQuestionOptionsView','fk_i_question_id','pk_i_id');
    }
}
