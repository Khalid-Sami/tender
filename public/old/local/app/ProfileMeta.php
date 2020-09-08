<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $i_type
 * @property integer $fk_i_ref_id
 * @property string $s_language_code
 * @property string $s_key
 * @property string $s_value
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 */
class ProfileMeta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_profile_meta';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['i_type', 'fk_i_ref_id', 's_language_code', 's_key', 's_value', 'b_enabled', 'dt_created_date', 'dt_modified_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }
}
