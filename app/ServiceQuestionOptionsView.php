<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestionOptionsView extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_service_question_options';


    /**
     * @var array
     */
    protected $fillable = ['fk_i_question_id', 's_option_en', 's_option_ar', 's_description_en', 's_description_ar', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionAnswers()
    {
        return $this->hasMany('App\SpQuestionAnswer', 'fk_i_option_id', 'pk_i_id');
    }
}
