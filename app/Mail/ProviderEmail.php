<?php
namespace App\Mail;

use App\Setting;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProviderEmail extends Mailable{
    use Queueable, SerializesModels;

    protected $default_lang;
    protected $msg;
    protected $name;
    protected $email;

    /**
     * SendVerificationCode constructor.
     * @param $default_lang
     * @param $email
     * @param $name
     * @param $msg
     */
    public function __construct($default_lang,$email, $name, $msg)
    {
        $this->default_lang = $default_lang;
        $this->email = $email;
        $this->name = $name;
        $this->msg = $msg;
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
        return $this->view('email.admin_email')->with(['default_lang' => $this->default_lang,'msg' => $this->msg, 'name' => $this->name, 'email' => $this->email, 'data' => $data,'send'=>'providerMSG']);
    }
}