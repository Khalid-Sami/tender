<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_service_provider_id
 * @property integer $fk_i_user_id
 * @property integer $fk_i_subscription_package_id
 * @property string $dt_expired_date
 * @property integer $b_enabled
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TServiceProvider $tServiceProvider
 */
class Invoice extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 't_invoice';
    public $timestamps= false;

    /**
     * @var array
     */
    protected $fillable = ['fk_i_service_provider_id', 'fk_i_user_id', 'fk_i_subscription_package_id', 'dt_expired_date', 'b_enabled', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

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
    public function tServiceProvider()
    {
        return $this->belongsTo('App\TServiceProvider', 'fk_i_service_provider_id', 'pk_i_id');
    }
}
