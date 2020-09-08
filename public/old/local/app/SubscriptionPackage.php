<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property string $s_name_ar
 * @property string $s_name_en
 * @property integer $i_users_count
 * @property integer $i_services_count
 * @property integer $i_request_count
 * @property integer $i_sms_notification
 * @property integer $i_email_notification
 * @property float $d_percentage
 * @property float $d_price
 * @property integer $i_duration
 * @property integer $b_listed_on_homepage
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 */
class SubscriptionPackage extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_subscription_package';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['s_name_ar', 's_name_en', 'i_users_count', 'i_services_count', 'i_request_count', 'i_sms_notification', 'i_email_notification', 'd_percentage', 'd_price', 'i_duration', 'b_listed_on_homepage', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}
