<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserVerification;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //
    public function redirectToProvider($provider,Request $request)
    {
//        dd(Socialite::driver($provider));
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback(Request $request,$provider)
    {

        //dd(Socialite::driver($provider)->user()->token);
        $user = Socialite::driver($provider)->stateless()->user();
//        $user = Socialite::driver($provider)->userFromToken($token);

//        $user->getId();
//        $user->getNickname();
//        $user->getName();
//        $user->getEmail();
//        $user->getAvatar();

        $check = User::where('s_email', $user->getEmail())->first();
        if (!empty($check)) {
            session(['user_id' => $check->pk_i_id]);
            session(['lang' => $check->s_default_language]);
            session(['role_id' => $check->fk_i_role_id]);
            session(['social' =>'social']);
            return redirect('/main');

        } else {

            $name = explode(' ', $user->getName());
            $first_name = $name[0];
            $last_name = $name[1];
            $pass_code = str_random(6);
            $u = User::create([
                's_first_name' => $first_name,
                's_last_name' => $last_name,
                's_mobile_number' => null,
                's_email' => $user->getEmail(),
                'fk_i_role_id' => 7,
                'fk_i_gender_id' => null,
                'dt_birth_date' => null,
                's_password' => 000000,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            UserVerification::createUserVerification($u, $pass_code);

            UserVerification::where(['fk_i_user_id' => $u->pk_i_id, 's_passcode' => $pass_code])
                ->update([
                    'b_enabled' => 1,
                    'dt_modified_date' => date('Y-m-d H:i:s'),
                    'dt_confirmation_date' => date('Y-m-d H:i:s'),
                    's_ip_address' => $request->getClientIp()
                ]);
            User::where(['pk_i_id' => $u->pk_i_id])->update([
                'dt_modified_date' => date('Y-m-d H:i:s')
            ]);
            session(['user_id' => $u->pk_i_id]);
            session(['lang' => $u->s_default_language]);
            session(['role_id' => $u->fk_i_role_id]);
            session(['social' =>'social']);
            return redirect('/main');
        }

    }

}