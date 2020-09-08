<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class EvaluationData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_evaluation_data';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $hidden = ['b_enabled','d_value','fk_i_for_user_id','fk_i_by_user_id','dt_created_date', 'fk_i_request_id', 'fk_i_evaluation_id'];
    /**
     * @var array
     */
    protected $fillable = ['b_enabled','d_value','fk_i_for_user_id','fk_i_by_user_id','dt_created_date', 'fk_i_request_id', 'fk_i_evaluation_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

    }
    public function evaluation(){
        return $this->belongsTo('App\EvaluationView','fk_i_evaluation_id','pk_i_id');
    }

}
