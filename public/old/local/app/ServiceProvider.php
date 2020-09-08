<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_subscription_package_id
 * @property string $s_name_ar
 * @property string $s_name_en
 * @property string $s_company_name
 * @property string $s_trade_license_no
 * @property string $s_telephone_number
 * @property string $s_mobile_number
 * @property string $s_email
 * @property string $s_image
 * @property string $s_address_ar
 * @property string $s_address_en
 * @property float $d_longitude
 * @property float $d_latitude
 * @property integer $i_status
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TInvoice[] $tInvoices
 * @property TRequest[] $tRequests
 * @property TSpCity[] $tSpCities
 * @property TSpQuestionAnswer[] $tSpQuestionAnswers
 * @property TSpService[] $tSpServices
 * @property TSpUser[] $tSpUsers
 * @property TSpWorkingHour[] $tSpWorkingHours
 */
class ServiceProvider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_service_provider';

    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['fk_i_subscription_package_id', 's_name_ar', 's_name_en', 's_company_name', 's_trade_license_no', 's_telephone_number', 's_mobile_number', 's_email', 's_image', 's_address_ar', 's_address_en', 'd_longitude', 'd_latitude', 'i_status', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function status()
    {
        return $this->belongsTo('App\ConstantView','i_status','pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'fk_i_service_provider_id', 'pk_i_id');
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
        return $this->hasMany('App\TSpCity', 'fk_i_service_provider_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpQuestionAnswers()
    {
        return $this->hasMany('App\TSpQuestionAnswer', 'fk_i_service_provider_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpServices()
    {
        return $this->hasMany('App\TSpService', 'fk_i_service_provider_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpUsers()
    {
        return $this->hasMany('App\TSpUser', 'fk_i_service_provider_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpWorkingHours()
    {
        return $this->hasMany('App\TSpWorkingHour', 'fk_i_service_provider_id', 'pk_i_id');
    }
}
