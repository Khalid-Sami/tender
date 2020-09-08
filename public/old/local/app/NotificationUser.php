<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $fk_i_notification_id
 * @property integer $fk_i_user_id
 * @property string $dt_seen_date
 * @property string $dt_read_date
 * @property string $dt_created_date
 * @property TUser $tUser
 * @property TNotification $tNotification
 */
class NotificationUser extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }
    public $timestamps = false;
    protected $table = 't_notification_user';
    /**
     * @var array
     */
    protected $fillable = ['fk_i_user_id','fk_i_notification_id','dt_seen_date', 'dt_read_date', 'dt_created_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'fk_i_user_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification()
    {
        return $this->belongsTo('App\Notification', 'fk_i_notification_id', 'pk_i_id');
    }
}
