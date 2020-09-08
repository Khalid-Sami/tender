<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property string $s_category_name_en
 * @property string $s_category_name_ar
 * @property integer $b_enabled
 * @property integer $s_parent_id
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 */
class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_categories';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
//    protected $hidden = ['dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    /**
     * @var array
     */
    protected $fillable = ['s_name_en', 's_name_ar','s_parent_id', 'b_enabled', 'dt_created_at'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }

//    public function service()
//    {
//        return $this->belongsToMany('App\Service', 't_service_category', "fk_i_category_id", 'pk_i_id');
//    }
}
