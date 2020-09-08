<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryView extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'V_CATEGORIES';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
//    protected $fillable = ['s_name','s_category_name_en', 's_category_name_ar', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
    }
//
//    public function service()
//    {
//        return $this->belongsToMany('App\Service', 't_service_category', "fk_i_category_id", 'pk_i_id');
//    }

    public function categories(){
        return $this->hasMany('App\CategoryView','s_parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\CategoryView','s_parent_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function parentRecursive2()
    {
        return $this->parentWithChildren()->with('parentRecursive2');
    }

    public function parentWithChildren(){
        return $this->belongsTo('App\CategoryView','s_parent_id')->with('categories');
    }

    public function children()
    {
        return $this->hasMany('App\CategoryView', 's_parent_id');
    }

    public function childrenRecursive(){
        return $this->children()->with('childrenRecursive');
    }


}
