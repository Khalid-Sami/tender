<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property string $s_service_name_en
 * @property string $s_service_name_ar
 * @property string $s_description_en
 * @property string $s_description_ar
 * @property integer $b_is_instant
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TServiceQuestion[] $tServiceQuestions
 * @property TSpService[] $tSpServices
 */
class Service extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_service';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['s_icon','s_pic','s_service_name_en', 's_service_name_ar', 's_description_en', 's_description_ar', 'b_is_instant', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceQuestions()
    {
        return $this->hasMany('App\ServiceQuestion', 'fk_i_service_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sPServices()
    {
        return $this->hasMany('App\SpService', 'fk_i_service_id', 'pk_i_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 't_service_category', 'pk_i_id', 'fk_i_category_id');
    }

    public function questions()
    {
        return $this->hasMany('App\ServiceQuestionView', 'fk_i_service_id', 'pk_i_id');
    }
}
