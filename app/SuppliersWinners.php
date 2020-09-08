<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_company_id
 * @property integer $i_type
 * @property integer $fk_i_service_id
 * @property string $dt_created_date
 * @property string $dt_modified_date
 */
class SuppliersWinners extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_suppliers_winners';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';
    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','fk_i_company_id','i_type', 'fk_i_service_id','dt_created_date','dt_modified_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
//        $lang = app()->getLocale();
//        DB::statement("SET @s_language_code ='$lang'");
//        Carbon::setLocale($lang);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function company()
    {
        return $this->belongsTo('App\CompanyView', 'fk_i_company_id', 'pk_i_id');
    }

    public function tender()
    {
        return $this->belongsTo('App\Tender', 'fk_i_service_id', 'pk_i_id');
    }

    public function auction()
    {
        return $this->belongsTo('App\ReverseAuction', 'fk_i_service_id', 'pk_i_id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer', 'fk_i_service_id', 'pk_i_id');
    }
}
