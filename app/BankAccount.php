<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder\Class_;

/**
 * @property integer $pk_i_id
 * @property integer $fk_i_company_id
 * @property string $s_currency
 * @property string $s_bank_name
 * @property string $s_bank_address
 * @property string $s_iban
 * @property string $s_swift
 * @property string $s_account_number
 * @property string $s_note
 * @property string $dt_created_at
 * @property string $dt_modified_date
 */

class BankAccount extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_company_bank_accounts';
    public $timestamps = false;
    protected $primaryKey = 'pk_i_id';

    protected $fillable = ['fk_i_company_id','s_currency','s_bank_name','s_account_number','s_bank_address','s_iban','s_swift','s_note','dt_created_at'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
//        $lang = app()->getLocale();
//        DB::statement("SET @s_language_code ='$lang'");
//        Carbon::setLocale($lang);
    }

    public function tCompany(){
        return $this->belongsTo('App\ServiceProvider','fk_i_company_id','pk_i_id');
    }

    public function status()
    {
        return $this->belongsTo('App\ConstantView','s_currency','pk_i_id');
    }

    public function attachment(){
        return $this->belongsTo('App\Attachments','pk_i_id','fk_i_refe_id')->where('i_attach_type',3);
    }
//    public function tCurrency(){
//        return $this->belongsTo('App\ConstantView','s_currency','pk_i_id');
//    }

}