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
    protected $table = 't_category';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $hidden = ['dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    /**
     * @var array
     */
    protected $fillable = ['s_category_name_en', 's_category_name_ar', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }

    public function service()
    {
        return $this->belongsToMany('App\Service', 't_service_category', "fk_i_category_id", 'pk_i_id');
    }
}
