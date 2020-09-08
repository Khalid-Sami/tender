<?php

namespace App\Http\Controllers;

use App\ServiceProvider;
use App\ServiceProviderUser;
use App\User;
use App\UserVerification;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }

    public function restore()
    {
        return view('forget_password');
    }

    public function register()
    {
        return view('register');
    }

    public function participation()
    {
        return view('participation');
    }


    public function create(Request $request)
    {
        //
        $user_id = $request->input('user_id');
        $pass_code = $request->input('pass_code');
        $user = UserVerification::where(['fk_i_user_id' => $user_id, 's_passcode' => $pass_code])->first();

        if (!empty($user)) {
            $expiration_date = strtotime($user->dt_expiration_date);
            $current_date = strtotime(date('Y-m-d H:i:s'));
            if ($expiration_date >= $current_date) {
                UserVerification::where(['fk_i_user_id' => $user_id, 's_passcode' => $pass_code])
                    ->update([
                        'b_enabled' => 1,
                        'dt_modified_date' => date('Y-m-d H:i:s'),
                        'dt_confirmation_date' => date('Y-m-d H:i:s'),
                        's_ip_address' => $request->getClientIp()
                    ]);
                User::where(['pk_i_id' => $user_id])->update([
                    'dt_modified_date' => date('Y-m-d H:i:s'),
                    'b_enabled' => 1
                ]);
                $user = User::where('pk_i_id',$user_id)->first();
                if ($user->userRule->s_name_en == 'ServiceProviderAdmin') {
                    $service_provider_id = ServiceProviderUser::where(['fk_i_user_id' => $user_id, 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id']);
                    ServiceProvider::where('pk_i_id', $service_provider_id->fk_i_service_provider_id)->update(['i_status' => 19,'b_enabled' => 1]);
                    ServiceProviderUser::where(['fk_i_user_id' => $user_id, 'fk_i_role_id' => 6])->update(['b_enabled' => 1]);
                }
                session()->flash('msg', trans('lang.activation_success'));

            } else {
                $pass_code = str_random(6);
                UserVerification::where(['fk_i_user_id' => $user_id])
                    ->update([
                        'dt_modified_date' => date('Y-m-d H:i:s'),
                        'dt_expiration_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +48 hours")),
                        's_passcode' => $pass_code,
                        's_ip_address' => $request->getClientIp()
                    ]);
                session()->flash('resend', trans('lang.activation_expired'));
                session(['email' => $user->s_email, 'pass_code' => $pass_code, 'user_id' => $user_id]);
            }

        } else {
            session()->flash('error_msg', trans('lang.error'));
        }

        return redirect('/login');
    }


    public function check(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
//        $user = User::where(['s_email' => $request->input('email'),'s_password' => md5($request->input('password'))])->first(['pk_i_id']);
//        $userEnabled = UserVerification::where('fk_i_user_id',$user->pk_i_id)->first(['b_enabled']);
////        dd($userEnabled->b_enabled);
//        if($user){
//            switch($userEnabled->b_enabled){
//                case "0":
//                    session()->flash('error_msg', trans('lang.errorBlockedUser'));
//                    return back();
//                    break;
//                case "1":
//                    session()->flash('error_msg', trans('lang.managementApproval'));
//                    return back();
//                    break;
//                case "2":
//                    return redirect('/main');
////                    break;
//                case "3":
//                    $pass_code = str_random(6);
//                    UserVerification::where(['fk_i_user_id' => $user->pk_i_id])
//                        ->update([
//                            'dt_modified_date' => date('Y-m-d H:i:s'),
//                            'dt_expiration_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +48 hours")),
//                            's_passcode' => $pass_code,
//                            's_ip_address' => $request->getClientIp()
//                        ]);
//                    session()->flash('resend', trans('lang.activation_expired'));
//                    session(['email' => $user->s_email, 'pass_code' => $pass_code, 'user_id' => $user->pk_i_id]);
//                    return back();
////                    session()->flash('error_msg', trans('lang.activationAccount'));
//                    break;
//            }
//        }
        $user = User::where(['s_email' => $request->input('email')])->first();
        if ($user) {
            $notification = $user->dt_modified_date;
            if ((md5($request->input('password')) == $user->s_password) && (!empty($notification)) && ($user->b_enabled == "2")) {
                session(['user_id' => $user->pk_i_id, 'lang' => $user->s_default_language]);
                $user = User::where(['pk_i_id' => $user->pk_i_id])->first(['fk_i_role_id']);
                session(['role_id' => $user->fk_i_role_id]);
                if(session('make_request')){
                    return redirect()->route('request.getBookingData',session('service_id'));
                }
                return redirect('/main');
            }
            else if((md5($request->input('password')) == $user->s_password) && (!empty($notification)) && $user->b_enabled == "1"){
                session(['user_id' => $user->pk_i_id, 'lang' => $user->s_default_language]);
                $user = User::where(['pk_i_id' => $user->pk_i_id])->first(['fk_i_role_id']);
                $data['user'] = $user;
                session(['role_id' => $user->fk_i_role_id]);
//                session(['managementApprovalMSG' => trans('lang.managementApproval') ]);
//                session()->flash('managementApprovalMSG', trans('lang.managementApproval'));
                return redirect('/main');
            }
            else if (($request->input('password') == $user->s_password) && empty($notification)) {
                $pass_code = str_random(6);
                UserVerification::where(['fk_i_user_id' => $user->pk_i_id])
                    ->update([
                        'dt_modified_date' => date('Y-m-d H:i:s'),
                        'dt_expiration_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +48 hours")),
                        's_passcode' => $pass_code,
                        's_ip_address' => $request->getClientIp()
                    ]);
                session()->flash('resend', trans('lang.activation_expired'));
                session(['email' => $user->s_email, 'pass_code' => $pass_code, 'user_id' => $user->pk_i_id]);
            } else if((md5($request->input('password')) == $user->s_password) && $user->b_enabled == "3") {
                session()->flash('blockUser', trans('lang.activationAccount'));
                session(['email' => $user->s_email]);
            }
            else if((md5($request->input('password')) == $user->s_password) && $user->b_enabled == "0") {
                session()->flash('error_msg', trans('lang.errorBlockedUser'));
            }
            else{
                session()->flash('error_msg', trans('lang.error'));
            }
        } else {
            session()->flash('error_msg', trans('lang.error'));
        }
        return back();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
