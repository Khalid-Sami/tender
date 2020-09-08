<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_service_id
 * @property string $s_question_ar
 * @property string $s_question_en
 * @property integer $i_question_type
 * @property integer $i_answer_type
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TService $tService
 * @property TSpQuestionAnswer[] $tSpQuestionAnswers
 */
class ServiceQuestion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_service_question';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_service_id', 's_question_ar', 's_question_en', 'i_question_type', 'i_answer_type', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\ServiceView', 'fk_i_service_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sPQuestionAnswers()
    {
        return $this->hasMany('App\SPQuestionAnswer', 'fk_i_question_id', 'pk_i_id');
    }

    public function serviceOptions()
    {
        return $this->hasMany('App\ServiceQuestionOptions', 'fk_i_question_id', 'pk_i_id');
    }
}
