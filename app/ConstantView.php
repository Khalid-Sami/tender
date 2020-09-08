<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConstantView extends Model
{
    //
    protected $table = 'v_constant';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

 
    protected $fillable = ['fk_i_parent_id', 's_path', 's_sequence_name', 'i_orginal_id', 's_key', 's_name_en', 's_name_ar', 's_extra_1', 's_extra_2', 's_extra_3', 's_extra_4', 's_comment', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }

    public static function getIdNameData($key)
    {
        $pk_i_id = ConstantView::where('s_key', $key)->first(['pk_i_id']);
        $result = "";
        if (!empty($pk_i_id)) {
            $result = ConstantView::where('fk_i_parent_id', $pk_i_id->pk_i_id)->pluck('s_name', 'pk_i_id');
        }
        return $result;
    }

    public static function getAllData($key)
    {
        $pk_i_id = ConstantView::where('s_key', $key)->first(['pk_i_id']);
        $result = "";
        if (!empty($pk_i_id)) {
            $result = ConstantView::where('fk_i_parent_id', $pk_i_id->pk_i_id)->get();
        }
        return $result;
    }

    public static function getAllChildren($id)
    {
        $result = ConstantView::where('fk_i_parent_id', $id)->get();
        return $result;
    }
}
