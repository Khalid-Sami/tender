<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $pk_i_id
 * @property integer $i_supplier_id
 * @property integer $i_item_id
 * @property integer $i_quantity
 * @property double $d_price
 * @property string $s_description
 * @property string $dt_created_date
 * @property string $dt_modified_date
 */
class SuppliersOffers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_suppliers_offers';
    public $timestamps= false;
    protected $primaryKey = 'pk_i_id';

    /**
     * @var array
     */
    protected $fillable = ['pk_i_id','i_supplier_id','i_item_id','i_quantity', 'd_price', 's_description','dt_created_date','dt_modified_date'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function supplier()
    {
        return $this->belongsTo('App\CompanyView', 'i_supplier_id', 'pk_i_id');
    }

    public function item(){
        return $this->belongsTo('App\ItemsView', 'i_item_id', 'pk_i_id');
    }

}
