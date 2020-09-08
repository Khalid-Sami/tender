<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_category_id
 * @property integer $fk_i_service_id
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 */
class ServiceCategory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_service_category';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['fk_i_category_id', 'fk_i_service_id', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    public function category(){
        return $this->belongsTo('App\CategoryView','fk_i_category_id','pk_i_id');
    } 
    public function service(){
        return $this->belongsTo('App\ServiceView','fk_i_service_id','pk_i_id');
    }
}
