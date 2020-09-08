<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubscriptionPackageView extends Model
{
    //
    public $timestamps = false;
    protected $table = 'v_subscription_package';
    protected $primaryKey = 'pk_i_id';
    protected $fillable = ['s_name_ar', 's_name_en', 'i_users_count', 'i_services_count', 'i_request_count', 'i_sms_notification', 'i_email_notification', 'd_percentage', 'd_price', 'i_duration', 'b_listed_on_homepage', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    /**
     * SubscriptionPackageView constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
    }

    public function getDtCreatedDateAttribute($date){
        return Carbon::parse(Carbon::parse($date)->timezone(session('timezone'))->toDateTimeString());
    }
    public function getDtModifiedDateAttribute($date){
        return  Carbon::parse(Carbon::parse($date)->timezone(session('timezone'))->toDateTimeString());
    }
    public function getDtDeletedDateAttribute($date){
        return Carbon::parse( Carbon::parse($date)->timezone(session('timezone'))->toDateTimeString());
    }

}
