<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyView extends Model
{
    protected $table = 'v_company';

    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['fk_i_subscription_package_id', 's_name_ar', 's_name','s_name_en', 's_company_name', 's_trade_license_no', 's_telephone_number', 's_mobile_number', 's_email', 's_image', 's_address_ar', 's_address_en', 'd_longitude', 'd_latitude', 'i_status', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
    }


    public function status()
    {
        return $this->belongsTo('App\ConstantView','i_status','pk_i_id');
    }

    public function enabled(){
        return $this->belongsTo('App\ConstantView','i_roles_id','pk_i_id');
    }

    public function city(){
        return $this->belongsTo('App\ConstantView','s_city','pk_i_id');
    }

    public function country(){
        return $this->belongsTo('App\ConstantView','s_country','pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'fk_i_company_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany('App\Request', 'fk_i_user_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpCities()
    {
        return $this->hasMany('App\TSpCity', 'fk_i_company_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpQuestionAnswers()
    {
        return $this->hasMany('App\TSpQuestionAnswer', 'fk_i_company_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\SPServices', 'fk_i_company_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\SpUser', 'fk_i_company_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpWorkingHours()
    {
        return $this->hasMany('App\TSpWorkingHour', 'fk_i_company_id', 'pk_i_id');
    }
}
