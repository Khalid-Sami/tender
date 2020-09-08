<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Mail\AdminEmail;
use App\Mail\SendVerificationCode;
use App\Notification;
use App\NotificationUser;
use App\Company;
use App\ServiceProvider;
use App\ServiceProviderUser;
use App\Setting;
use App\User;
use App\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    public function store(Request $request)
    {

//        // the message
//        $msg = "Hello man\nthis is first email for you";
//
//// use wordwrap() if lines are longer than 70 characters
//        $msg = wordwrap($msg, 70);
//
//// send email
//        mail($request->input('email'), "My subject", $msg);
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:t_user,s_email',
            'mobile_number'=>'required|unique:t_user,s_mobile_number|numeric',
            'password'=>'required|min:6',
            'confirm'=>'required|min:6|same:password',
        ]);
        $user = new User();
        $pass_code = str_random(6);
        $user =$user->createUser($request, 7);
//       $userPermission = new UserPermissions();
//       $userPermission->createUserPermission($user->pk_i_id, $patientPermission);
        UserVerification::createUserVerification($user, $pass_code);
        $user_data = User::where('pk_i_id', $user->pk_i_id)->first();
        $user_name = $user_data->s_first_name.' '.$user_data->s_last_name;

        Mail::to($request->input('email'))->send(new SendVerificationCode($user_name,$user_data->s_default_language,$pass_code, $user->pk_i_id));

        session()->flash('msg', trans('lang.activation_code'));
        return back();
    }

    public function createServiceProvider()
    {
        return view('register_service_provider');
    }

    public function storeServiceProvider(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_email' => 'required|email|unique:t_user,s_email',
            'user_mobile_number' => 'required|unique:t_user,s_mobile_number',
            'password' => 'required|same:confirm|min:6',
            'confirm' => 'required|min:6',
//            'company_name' => 'required',
            'service_provider_name_ar' => 'required',
            'service_provider_name_en' => 'required',
            'service_provider_telephone_number' => 'required|unique:t_company,s_telephone_number',
            'service_provider_email' => 'required|email|unique:t_company,s_email',
            'service_provider_mobile_number' => 'required|unique:t_company,s_mobile_number'
        ]);
//        $clinicPermission = [93,108, 5, 7, 8, 9, 11, 15, 16, 38, 31, 36, 109, 56, 94, 95, 97, 98, 99, 27, 28, 40, 41, 42, 30, 39, 110, 111, 21, 22, 23,115,114,119,118,121,125,126,127,128,129,130,131,132,133,134,137];
//        $user = User::createUser($request, 15);
        $user = User::create([
            's_first_name' => $request->input('first_name'),
            's_last_name' => $request->input('last_name'),
            's_mobile_number' => $request->input('user_mobile_number'),
            's_email' => $request->input('user_email'),
            'fk_i_role_id' => 6,
            's_password' => md5($request->input('password')),
            'dt_created_date' => date('Y-m-d h:i:s')
        ]);

//        $userPermission = new UserPermissions();
//        $userPermission->createUserPermission($user->pk_i_id, $clinicPermission);
        $provider = ServiceProvider::create([
            's_name_en' => $request->input('service_provider_name_en'),
            's_name_ar' => $request->input('service_provider_name_ar'),
//            's_company_name' => $request->input('company_name'),
            's_telephone_number' => $request->input('service_provider_telephone_number'),
            's_mobile_number' => $request->input('service_provider_mobile_number'),
            's_email' => $request->input('service_provider_email'),
            'i_status' => 19,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

//        DB::table('t_company_bank_accounts')->insert([
//            'fk_i_company_id' => $provider->pk_i_id,
//            'dt_created_at' => date('Y-m-d H:i:s')
//        ]);


        ServiceProviderUser::createServiceProviderUser($provider->pk_i_id, $user->pk_i_id);
        $adminUser = User::where('fk_i_role_id',5)->first(['pk_i_id']);
        $notification = Notification::create([
            'fk_i_actor_user_id' => $adminUser->pk_i_id,
            'i_target_users_type' => 2,
            'i_title_type' => 1,
            's_title_en' => 's_provider_name_en>' . $request->input('service_provider_name_en'),
            's_title_ar' => 's_provider_name_ar>' . $request->input('service_provider_name_ar'),
            'fk_i_notification_template_id' => 1,
            'i_action' => 1,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

        $pass_code = str_random(6);
        UserVerification::createUserVerification($user, $pass_code);
        NotificationUser::create([
            'fk_i_notification_id' => $notification->pk_i_id,
            'fk_i_user_id' => $adminUser->pk_i_id,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);
        $email = Setting::where('s_key', 'super_admin_email')->first(['s_value']);

        $user_data = User::where('pk_i_id', $user->pk_i_id)->first();
        $user_name = $user_data->s_first_name . ' ' . $user_data->s_last_name;
        Mail::to($request->input('service_provider_email'))->send(new SendVerificationCode($user_name, $user_data->s_default_language, $pass_code, $user->pk_i_id));

        session()->flash('msg', trans('lang.activation_code'));
        $admin_user = User::where('s_email', $email->s_value)->first();
        $admin_name = $admin_user->s_first_name . ' ' . $admin_user->s_last_name;

        if ($admin_user->s_default_language == 'en') {
            $english_message = "New Company Account has been registered";
            Mail::to($email->s_value)->send(new AdminEmail($admin_user->s_default_language, $email->s_value, $admin_name, $english_message));
        }
        if ($admin_user->s_default_language == 'ar') {
            $arabic_message = "تم تسجيل حساب الشركة ";
            Mail::to($email->s_value)->send(new AdminEmail($admin_user->s_default_language, $email->s_value, $admin_name, $arabic_message));
        }

        return back();
    }
}
