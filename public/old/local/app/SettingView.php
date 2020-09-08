<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingView extends Model
{
    //
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
    }
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $table="v_settings";
    /**
     * @var array
     */
    protected $fillable = ['s_key', 's_name_ar', 's_name_en', 'i_data_type', 's_value', 's_extra_1', 'b_enabled', 'dt_created_date', 'dt_modified_date'];

}
