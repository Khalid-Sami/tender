<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property string $s_key
 * @property string $s_name_ar
 * @property string $s_name_en
 * @property integer $i_data_type
 * @property string $s_value
 * @property string $s_extra_1
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 */
class Setting extends Model
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_system_settings';

    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['s_key', 's_name_ar', 's_name_en', 'i_data_type', 's_value', 's_extra_1', 'b_enabled', 'dt_created_date', 'dt_modified_date'];

}
