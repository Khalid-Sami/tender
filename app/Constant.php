<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_parent_id
 * @property string $s_path
 * @property string $s_sequence_name
 * @property integer $i_orginal_id
 * @property string $s_key
 * @property string $s_name_en
 * @property string $s_name_ar
 * @property string $s_extra_1
 * @property string $s_extra_2
 * @property string $s_extra_3
 * @property string $s_extra_4
 * @property string $s_comment
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TConstant $tConstant
 * @property TSpCity[] $tSpCities
 * @property TUser[] $tUsers
 */
class Constant extends Model
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_constant';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['fk_i_parent_id', 's_path', 's_sequence_name', 'i_orginal_id', 's_key', 's_name_en', 's_name_ar', 's_extra_1', 's_extra_2', 's_extra_3', 's_extra_4', 's_comment', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }

    public function updateConstant($table, $pk_i_id)
    {
        Constant::where('pk_i_id', $pk_i_id)->update($table);
    }
    public function storeConstant($table)
    {
        Constant::create($table);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tConstant()
    {
        return $this->belongsTo('App\TConstant', 'fk_i_parent_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpCities()
    {
        return $this->hasMany('App\TSpCity', 'fk_i_city_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function role()
    {
        return $this->hasMany('App\TUser', 'fk_i_role_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gender()
    {
        return $this->hasMany('App\TUser', 'fk_i_gender_id', 'pk_i_id');
    }
}
