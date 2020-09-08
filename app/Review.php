<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_review';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $hidden = ['b_enabled','i_approvied','fk_i_for_user_id','fk_i_by_user_id','s_review','fk_i_request_id','dt_created_date'];
    /**
     * @var array
     */
    protected $fillable = ['b_enabled','i_approvied','fk_i_for_user_id','fk_i_by_user_id','s_review','fk_i_request_id','dt_created_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

}
