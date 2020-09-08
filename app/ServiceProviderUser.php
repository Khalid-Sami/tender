<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $fk_i_company_id
 * @property integer $fk_i_user_id
 * @property integer $fk_i_role_id
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TServiceProvider $tServiceProvider
 */
class ServiceProviderUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 't_company_user';

    /**
     * @var array
     */
    protected $fillable = ['fk_i_role_id','fk_i_user_id','fk_i_service_provider_id','b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }




    public static function createServiceProviderUser($company_id, $user_id)
    {
        ServiceProviderUser::create([
            'fk_i_service_provider_id' => $company_id,
            'fk_i_user_id' => $user_id,
            'fk_i_role_id' => 6,
            'b_enabled' => 1,
            'dt_created_date' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceProvider()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_service_provider_id', 'pk_i_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'fk_i_user_id', 'pk_i_id');
    }

}
