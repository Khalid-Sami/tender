<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConversationUser extends Model
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        Carbon::setLocale($lang);
    }
    protected $table = "conversation_user";
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->timezone(session('timezone'))->toDateTimeString();
    }
}
