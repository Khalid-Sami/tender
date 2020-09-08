<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mod;

class CompanyCategories extends Model
{
    protected $table = 't_comapny_categories';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

    protected $fillable = ['fk_i_comapny_id', 'fk_i_categories_id','dt_created_at'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function category(){
        return $this->belongsTo('App\CategoryView','fk_i_categories_id','pk_i_id');
    }

    public function company(){
        return $this->belongsTo('App\CompanyView','fk_i_comapny_id','pk_i_id');
    }

    public function usercompany(){
        return $this->belongsTo('App\ServiceProviderUser','fk_i_comapny_id','fk_i_service_provider_id')->with(['user']);
    }

}