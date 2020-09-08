<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SendNotificationView extends Model
{
    //
    protected $table = 'v_send_notification';
    protected $fillable = ['s_title','fk_i_actor_user_id', 'fk_i_notification_template_id', 'i_target_users_type', 'i_title_type', 's_title_en', 's_title_ar', 'i_action', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
        $lang = app()->getLocale();
        $user_id = session('user_id');
        DB::statement("SET @s_language_code ='$lang'");
        DB::statement("SET @i_user_id  ='$user_id'");
        Carbon::setLocale($lang);

    }

    public function getDtCreatedDateAttribute($date){

        return Carbon::parse($date)->setTimezone(session('timezone'))->diffForHumans();
    }

}
