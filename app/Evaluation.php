<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Evaluation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_evaluation';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $hidden = ['b_enabled','s_name_ar','s_name_en','dt_created_date', 'dt_modified_date', 'dt_deleted_date','i_type'];
    /**
     * @var array
     */
    protected $fillable =['b_enabled','s_name_ar','s_name_en','dt_created_date', 'dt_modified_date', 'dt_deleted_date','i_type'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
      
    }
    
}
