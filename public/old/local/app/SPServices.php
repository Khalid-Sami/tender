<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $fk_i_service_provider_id
 * @property integer $fk_i_service_id
 * @property integer $b_is_instant
 * @property float $d_price
 * @property integer $i_currency
 * @property integer $b_approved
 * @property string $dt_created_date
 * @property string $dt_modified_date
 * @property string $dt_deleted_date
 * @property TService $tService
 * @property TServiceProvider $tServiceProvider
 * @property TSpQuestionAnswer[] $tSpQuestionAnswers
 */
class SPServices extends Model
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
    protected $table = 't_sp_services';
    protected $primaryKey = 'pk_i_id';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['fk_i_service_id', 'fk_i_service_provider_id', 'b_is_instant', 'd_price', 'i_currency', 'b_approved', 'dt_created_date', 'dt_modified_date', 'dt_deleted_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\ServiceView', 'fk_i_service_id', 'pk_i_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceProvider()
    {
        return $this->belongsTo('App\ServiceProviderView', 'fk_i_service_provider_id', 'pk_i_id');
    }

    public function serviceProviderCondition()
    {
        return $this->belongsTo('App\ServiceProviderView', 'fk_i_service_provider_id', 'pk_i_id')->where('i_status', 19);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tSpQuestionAnswers()
    {
        return $this->hasMany('App\TSpQuestionAnswer', 'fk_i_service_id', 'fk_i_service_id');
    }

    public static function getData()
    {
        return DB::table('t_sp_services as tsps')
            ->join('v_service_provider as vsp', 'vsp.pk_i_id', '=', 'tsps.fk_i_service_provider_id')
            ->where('tsps.b_approved', 0)
            ->distinct()
            ->select('vsp.*')
            ->get();
    }
}
