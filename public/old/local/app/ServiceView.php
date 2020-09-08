<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceView extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $table = 'v_service';

    /**
     * @var array
     */
    protected $fillable = ['s_service_name_en', 's_service_name_ar', 's_description_en', 's_description_ar', 'b_is_instant', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
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
