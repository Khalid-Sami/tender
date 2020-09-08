<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_question_id
 * @property string $s_option_en
 * @property string $s_option_ar
 * @property string $s_description_en
 * @property string $s_description_ar
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TSpQuestionAnswer[] $tSpQuestionAnswers
 */
class ServiceQuestionOptions extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_service_question_options';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_question_id', 's_option_en', 's_option_ar', 's_description_en', 's_description_ar', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SpQuestionAnswers()
    {
        return $this->hasMany('App\TSpQuestionAnswer', 'fk_i_option_id', 'pk_i_id');
    }
}
