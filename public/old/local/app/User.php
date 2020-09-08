<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_role_id
 * @property integer $fk_i_gender_id
 * @property string $s_first_name
 * @property string $s_last_name
 * @property integer $s_mobile_number
 * @property string $s_email
 * @property string $s_password
 * @property integer $s_district
 * @property string $dt_birth_date
 * @property float $d_latitude
 * @property float $d_longitude
 * @property string $dt_notification_seen_date
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property string $s_address
 * @property integer $i_country_id
 * @property integer $i_city_id
 * @property string $s_pic
 * @property TConstant $tConstant
 * @property TNotification[] $tNotifications
 * @property TNotificationUser[] $tNotificationUsers
 * @property TPermissionsUser[] $tPermissionsUsers
 * @property TSpUser[] $tSpUsers
 * @property TUserDevice[] $tUserDevices
 * @property TUserVerification[] $tUserVerifications
 * @property TUserVerificationLog[] $tUserVerificationLogs
 */
class User extends Model
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_user';

    /**
     * @var array
     */
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    protected $fillable = ['fk_i_role_id', 'fk_i_gender_id', 's_first_name', 's_last_name', 's_mobile_number', 's_email', 's_password', 's_district', 'dt_birth_date', 'd_latitude', 'd_longitude', 'dt_notification_seen_date', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date', 's_address', 'i_country_id', 'i_city_id', 's_pic'];

   

    public  function createUser($request,$status){
        $gender = $request->input('gender');
        $birth_date = $request->input('birth_date');
        $user = User::create([
            's_first_name' => $request->input('first_name'),
            's_last_name' => $request->input('last_name'),
            's_mobile_number' => $request->input('mobile_number'),
            's_email' => $request->input('email'),
            'fk_i_role_id' => $status,
            'fk_i_gender_id' => isset($gender) ? $gender : null,
            'dt_birth_date' => isset($birth_date) ? $birth_date : null,
            's_password' => md5($request->input('password')),
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);
        return $user;
    }
//    public function getSPasswordAttribute($password)
//    {
//        return decrypt($password);
//    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRule()
    {
        return $this->belongsTo('App\ConstantView', 'fk_i_role_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo('App\ConstantView', 'fk_i_gender_id', 'pk_i_id');
    }

}
