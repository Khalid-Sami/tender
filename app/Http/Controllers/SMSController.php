<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SMSController extends Controller
{

    /**
     * SMSController constructor.
     */
    public function __construct()
    {
        $this->middleware('locale');
    }

    public function send($to, $msg)
    {
        $sms_api_url = Setting::where('s_key', 'sms_api_url')->first();
        $sms_api_var1 = Setting::where('s_key', 'sms_api_var1')->first();
        $sms_api_var2 = Setting::where('s_key', 'sms_api_var2')->first();
        $sms_api_var3 = Setting::where('s_key', 'sms_api_var3')->first();
        $sms_api_var4 = Setting::where('s_key', 'sms_api_var4')->first();


        $sms_api_var_to = Setting::where('s_key', 'sms_api_var_to')->first();
        $sms_api_var_message = Setting::where('s_key', 'sms_api_var_message')->first();
        $vars = "";

            $vars .= $sms_api_var1->s_value . "&".$sms_api_var2->s_value . "&".$sms_api_var3->s_value . "&".$sms_api_var4->s_value;

//        $vars = rtrim($vars, '&');
        $msg =urlencode($msg);
        $url = $sms_api_url->s_value . "?" . $vars . '&' . $sms_api_var_to->s_value . $to . "&" . $sms_api_var_message->s_value."{$msg}";

        return $this->get_curl($url);
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function get_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        $data = (int)$data;
        curl_close($ch);
        if ($data == -2 || $data == -999 || $data == 'u') {
            return 0;
        } else {
            return 1;
        }

    }
}
