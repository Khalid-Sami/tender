<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_actor_user_id
 * @property integer $fk_i_notification_template_id
 * @property integer $i_target_users_type
 * @property integer $i_title_type
 * @property string $s_title_en
 * @property string $s_title_ar
 * @property integer $i_action
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TUser $tUser
 * @property TNotificationTemplate $tNotificationTemplate
 * @property TNotificationUser[] $tNotificationUsers
 */
class Notification extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_notification';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['s_ids','fk_i_actor_user_id', 'fk_i_notification_template_id', 'i_target_users_type', 'i_title_type', 's_title_en', 's_title_ar', 'i_action', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'fk_i_actor_user_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tNotificationTemplate()
    {
        return $this->belongsTo('App\TNotificationTemplate', 'fk_i_notification_template_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificationUsers()
    {
        return $this->hasMany('App\NotificationUser', 'fk_i_notification_id', 'pk_i_id');
    }
}
