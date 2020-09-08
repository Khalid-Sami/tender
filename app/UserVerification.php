<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_user_id
 * @property string $s_udid
 * @property string $s_passcode
 * @property string $s_ip_address
 * @property string $dt_expiration_date
 * @property string $dt_confirmation_date
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_deleted_date
 * @property string $dt_modified_date
 * @property TUser $tUser
 */
class UserVerification extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_user_verification';

    /**
     * @var array
     */
    protected $fillable = ['fk_i_user_id', 's_udid', 's_passcode', 's_ip_address', 'dt_expiration_date', 'dt_confirmation_date', 'b_enabled', 'dt_created_date', 'dt_deleted_date', 'dt_modified_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public static function createUserVerification($user, $pass_code){

        UserVerification::create([
            'fk_i_user_id' => $user->pk_i_id,
            's_passcode' => $pass_code,
            'dt_expiration_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +48 hours")),
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'fk_i_user_id', 'pk_i_id');
    }
}
