<?php

namespace App\Mail;

use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $default_lang;
    public $pass_code;
    public $user_id;

    /**
     * SendVerificationCode constructor.
     * @param $name
     * @param $default_lang
     * @param $pass_code
     * @param $user_id
     */
    public function __construct($name, $default_lang, $pass_code, $user_id)
    {
        $this->name = $name;
        $this->default_lang = $default_lang;
        $this->pass_code = $pass_code;
        $this->user_id = $user_id;
    }

    /**
     * SendVerificationCode constructor.
     * @param $pass_code
     */


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = Setting::all()->keyBy('s_key');
        return $this->view('email.admin_email')->with(['data' => $data, 'name' => $this->name, 'pass_code' => $this->pass_code, 'user_id' => $this->user_id, 'send' => 'sendVerificationCode']);
    }
}
