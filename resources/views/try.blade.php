<?php

namespace App\Http\Controllers;

use App\Attachments;
use App\Offer;
use App\OfferItems;
use App\Permissions;
use App\ReverseAuction;
use App\ReverseAuctionItem;
use App\ReverseAuctionProposal;
use App\ReverseAuctionProposalItem;
use App\SuppliersWinners;
use App\Tender;
use App\TenderItems;
use App\Items;
use App\ItemsView;
use App\BankAccount;
use App\Category;
use App\CategoryView;
use App\CompanyCategories;
use App\Constant;
use App\ConstantView;
use App\NotificationUser;
use App\Notification;
use App\CompanyView;
use App\Mail\AdminEmail;
use App\Mail\ProviderEmail;
use App\Notifications\EmailNotification;
use App\RequestQuotation;
use App\Mail\SendVerificationCode;
use App\RequestProposedSP;
use App\Http\helpers;
use App\Invoice;
use App\ProfileMeta;
use App\ServiceCategory;
use App\ServiceProvider;
use App\ServiceProviderUser;
use App\TenderProposal;
use App\TenderProposalItems;
use App\UserPermissions;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;
use App\Setting;
use App\Request as RequestClass;
use App\SettingView;
use App\SPWorkingHours;
use App\SubscriptionPackage;
use App\SubscriptionPackageView;
use App\UserVerification;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Company;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;
use PDF;
use Excel;

class AdminController extends Controller
{

    public $ILLEGAL_ACCESS = "Illegal Access";
    public $DONE = "Done!";
    public $DONE_JSON_MESSAGE = ['status' => 200, 'message' => 'Done'];


    //

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);
    }

    public function addNewCompany()
    {
        return view("admin.service_provider.add");
    }

    public  function storeCompanyAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_email' => 'required|email|unique:t_user,s_email',
            'user_mobile_number' => 'required|unique:t_user,s_mobile_number',
            'password' => 'required|same:confirm|min:6',
            'confirm' => 'required|min:6',
            'company_name' => 'required',
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
        $provider = Company::create([
            's_name_en' => $request->input('service_provider_name_en'),
            's_name_ar' => $request->input('service_provider_name_ar'),
            's_company_name' => $request->input('company_name'),
            's_telephone_number' => $request->input('service_provider_telephone_number'),
            's_mobile_number' => $request->input('service_provider_mobile_number'),
            's_email' => $request->input('service_provider_email'),
            'i_status' => 19,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);


        ServiceProviderUser::createServiceProviderUser($provider->pk_i_id, $user->pk_i_id);
        $notification = Notification::create([
            'fk_i_actor_user_id' => $user->pk_i_id,
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
            'fk_i_user_id' => $user->pk_i_id,
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
            $arabic_message = "تم تسجيل حساب الشركة";
            Mail::to($email->s_value)->send(new AdminEmail($admin_user->s_default_language, $email->s_value, $admin_name, $arabic_message));
        }

        return back()->with('msg', trans('lang.added'));


    }

    public function createAccount()
    {

        $types = [];
        $genders = ConstantView::getIdNameData('USERS_GENDERS');
        return view('admin.users.add_new_user', compact('genders'));
    }

    public
    function storeAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:t_user,s_email',
            'mobile_number' => 'required|unique:t_user,s_mobile_number|numeric',
            'password' => 'required|min:6',
            'confirm' => 'required|min:6|same:password',
        ]);
        $serviceProviderUser = [9, 10, 11, 12, 13, 41, 56, 57, 58, 59, 64, 65];
        $u = new User();
        $user = $u->createUser($request, 7);
        User::where(['pk_i_id' => $user->pk_i_id])->update([
            'dt_modified_date' => date('Y-m-d H:i:s')
        ]);

        $user_data = User::where('pk_i_id', $user->pk_i_id)->first();
        $userPermission = new UserPermissions();
        $userPermission->createUserPermission($user->pk_i_id, $serviceProviderUser);
        $user_name = $user_data->s_first_name . ' ' . $user_data->s_last_name;

        $msg = trans('lang.activation_success');
        Mail::to($request->input('email'))->send(new AdminEmail($user_data->s_default_language, $user_data->s_email, $user_name, $msg));

        return back()->with('msg', trans('lang.added'));


    }


    public function systemSettings()
    {
        $settings = SettingView::all()->keyBy('s_key');
        return view('admin.setting', compact('settings'));
    }


    public function sendNotifications()
    {
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
//        $clinics = [];
//        $data['Company'] = User::where('b_enabled', 1)->get();
//        $data['clinics_User'] = [];
        $data['userCompany'] = ServiceProviderUser::where('b_enabled', 2)->get();
//        $data['categories'] = CategoryView::where('b_enabled', 2)->get();
//        $data['categories'] = CategoryView::where('b_enabled', 1)->pluck('s_name', 'pk_i_id')->prepend(trans('lang.selectCategory'), '');
        $data['categories'] = CategoryView::where('b_enabled', 1)->get(array('s_name', 'pk_i_id'));
        return view('admin.notifications.show', $data);
    }

    public function getAllNotifications(Request $request)
    {
        $last_date = $request->input('last_date');
        $user_id = session('user_id');
        $user = User::where('pk_i_id', $user_id)->first();
        $seen_date = $user->dt_notification_seen_date;
        DB::statement("SET @i_user_id ='$user er_id'");
        if (!empty($seen_date)) {
            $notifications_count = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification WHERE  v_notification.dt_created_date > '$seen_date'")));
        } else {
            $notifications_count = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification")));
        }
        $check = collect(DB::select(DB::raw(" SELECT * FROM v_notification WHERE dt_created_date > '$last_date' ORDER BY dt_created_date DESC ")))->first();
        $notifications = collect(DB::select(DB::raw(" SELECT * FROM v_notification  ORDER BY dt_created_date DESC ")))->take(20);
        if (!empty($check)) {
            $view = view('ajax.notification', compact('last_date', 'notifications', 'notifications_count'))->render();
            return response()->json(['last_date' => $check->dt_created_date, 'view' => $view, 'status' => 1]);
        }
        return response()->json(['status' => 0]);

    }

    public function updateNotifications(Request $request)
    {
        $user_id = session('user_id');
        User::where(['pk_i_id' => $user_id])->update(['dt_notification_seen_date' => date('Y-m-d H:i:s')]);
        $user = User::where('pk_i_id', $user_id)->first();
        $last_date = $request->input('last_date');
        $seen_date = $user->dt_notification_seen_date;
        DB::statement("SET @i_user_id ='$user_id'");
        $lang = app()->getLocale();
        DB::statement("SET @s_language_code ='$lang'");
        if (!empty($seen_date)) {
            $notifications_count = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification WHERE  v_notification.dt_created_date > '$seen_date'")));
        } else {
            $notifications_count = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification")));
        }
        $check = collect(DB::select(DB::raw(" SELECT * FROM v_notification WHERE dt_created_date>'$seen_date' ORDER BY dt_created_date DESC")))->first();
        $notifications = collect(DB::select(DB::raw(" SELECT * FROM v_notification  ORDER BY dt_created_date DESC ")))->take(20);
        if (!empty($check)) {
            $view = view('ajax.notification', compact('last_date', 'notifications', 'notifications_count'))->render();
            return response()->json(['last_date' => $check->dt_created_date, 'view' => $view, 'status' => 1]);
        }
        $view = view('ajax.notification', compact('last_date', 'notifications', 'notifications_count'))->render();
        return response()->json(['view' => $view, 'status' => 0]);


    }

    public function storeNotifications(Request $request)
    {
        $serviceType = $request->input('radio');
        $sendTo = $request->input('category');
        if($sendTo == 1){
            $userIds = $request->input('my_multi_select0');
        }
        else{
            $categoriesID = $request->input('my_multi_select1');
        }
//        $sendTo = $request->input('check');
        $arabicMessage = $request->input('messageArabic');
        $englishMessage = $request->input('messageEnglish');

        if (!empty($serviceType[0])) {
            switch ($serviceType[0]) {
                case 'email':
//                    foreach ($sendTo as $s) {
//                        foreach ($userIds as $id) {
//                            $user = User::where(['pk_i_id' => $id])->first(['s_default_language', 's_email', 's_first_name', 's_last_name']);
//                            $name = $user->s_first_name . ' ' . $user->s_last_name;
//                            if ($user->s_default_language == 'ar') {
//
//                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $arabicMessage));
//                            } else {
//                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $englishMessage));
//                            }
//
//                        }
//                    }

                    if($sendTo == 1){
                        foreach ($userIds as $id){
                            $user = User::where(['pk_i_id' => $id])->first(['s_default_language', 's_email', 's_first_name', 's_last_name']);
                            $name = $user->s_first_name . ' ' . $user->s_last_name;
                            if ($user->s_default_language == 'ar') {
                                dd('ddd');
                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $arabicMessage));
                            } else {
                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $englishMessage));
                            }
                        }
                    }
                    else if ($sendTo == 0){
                        foreach ($categoriesID as $categoryID){
                            $companiesID = CompanyCategories::where('fk_i_categories_id',$categoryID)->get(['fk_i_comapny_id']);
                            foreach ($companiesID as $companyID){
                                $user = ServiceProviderUser::where('fk_i_service_provider_id',$companyID->fk_i_comapny_id)->first();
                                $name = $user->user->s_first_name . ' ' . $user->user->s_last_name;
                                if ($user->user->s_default_language == 'ar') {
                                    Mail::to($user->user->s_email)->send(new AdminEmail($user->user->s_default_language, $user->user->s_email, $name, $arabicMessage));
//                                    Mail::send('email.contact',
//                                        array(
//                                            'name' => 'ddd',
//                                            'email' => 'dddd',
//                                            'user_message' => 'ccccc'
//                                        ), function($message) use ($request)
//                                        {
//                                            $message->from(env("MAIL_USERNAME"));
//                                            $message->to('khalid.sami@outlook.sa', 'Admin')->subject('Al-Makassed-Contact-US');
//                                        });
                                } else {
                                    Mail::to($user->user->s_email)->send(new AdminEmail($user->user->s_default_language, $user->user->s_email, $name, $englishMessage));
                                }
                            }
                        }
                    }

                    break;

                case 'sms':
                    $sms = new SMSController();
                    if($sendTo == 1){
                        foreach ($userIds as $id){
                            $user = User::where(['pk_i_id' => $id])->first(['s_default_language', 's_mobile_number']);
                            if ($user->s_default_language == 'ar') {
                                $sms->send($user->s_mobile_number, $arabicMessage);
                            } else {
                                $sms->send($user->s_mobile_number, $englishMessage);
                            }
                        }
                    }
                    else if ($sendTo == 0){
                        foreach ($categoriesID as $categoryID){
                            $companiesID = CompanyCategories::where('fk_i_categories_id',$categoryID)->get(['fk_i_comapny_id']);
                            foreach ($companiesID as $companyID){
                                $user = ServiceProviderUser::where('fk_i_service_provider_id',$companyID->fk_i_comapny_id)->first();
                                if ($user->user->s_default_language == 'ar') {
                                    $sms->send($user->user->s_mobile_number, $arabicMessage);
                                } else {
                                    $sms->send($user->user->s_mobile_number, $englishMessage);
                                }
                            }
                        }
                    }
                    break;

                case 'website':
//                    foreach ($sendTo as $s) {
//                        $notification = Notification::create([
//                            'fk_i_actor_user_id' => session('user_id'),
//                            'i_target_users_type' => 2,
//                            'i_title_type' => 2,
//                            's_title_en' => $englishMessage,
//                            's_title_ar' => $arabicMessage,
//                            'i_action' => 0,
//                            'b_enabled' => 1,
//                            'dt_created_date' => date('Y-m-d H:i:s')
//                        ]);
//                        $notification_data = [
//                            'i_notification_id' => $notification->pk_i_id
//                        ];
//
//                        foreach ($userIds as $id) {
//                            NotificationUser::create([
//                                'fk_i_notification_id' => $notification->pk_i_id,
//                                'fk_i_user_id' => $id,
//                                'dt_created_date' => date('Y-m-d H:i:s')
//                            ]);
//                        }
////                        $this->send_notification('http://clinics.newline.ps/api/v1/pns/push_notification/', $notification_data);
//                    }
                    if($sendTo == 1){
                        foreach ($userIds as $id){
                            $notification = Notification::create([
                                'fk_i_actor_user_id' => session('user_id'),
                                'i_target_users_type' => 2,
                                'i_title_type' => 2,
                                's_title_en' => $englishMessage,
                                's_title_ar' => $arabicMessage,
                                'i_action' => 0,
                                'b_enabled' => 1,
                                'dt_created_date' => date('Y-m-d H:i:s')
                            ]);
                            NotificationUser::create([
                                'fk_i_notification_id' => $notification->pk_i_id,
                                'fk_i_user_id' => $id,
                                'dt_created_date' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    else if ($sendTo == 0){
                        foreach ($categoriesID as $categoryID){
                            $companiesID = CompanyCategories::where('fk_i_categories_id',$categoryID)->get(['fk_i_comapny_id']);
                            foreach ($companiesID as $companyID){
                                $user = ServiceProviderUser::where('fk_i_service_provider_id',$companyID->fk_i_comapny_id)->first();
                                $notification = Notification::create([
                                    'fk_i_actor_user_id' => session('user_id'),
                                    'i_target_users_type' => 2,
                                    'i_title_type' => 2,
                                    's_title_en' => $englishMessage,
                                    's_title_ar' => $arabicMessage,
                                    'i_action' => 0,
                                    'b_enabled' => 1,
                                    'dt_created_date' => date('Y-m-d H:i:s')
                                ]);
                                NotificationUser::create([
                                    'fk_i_notification_id' => $notification->pk_i_id,
                                    'fk_i_user_id' => $user->user->pk_i_id,
                                    'dt_created_date' => date('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    }
                    break;

                case 'push':
                    ############ مافي اشي كان مكتوب هنا #############33
                    foreach ($sendTo as $s) {
                        $notification = Notification::create([
                            'fk_i_actor_user_id' => session('user_id'),
                            'i_target_users_type' => 2,
                            'i_title_type' => 2,
                            's_title_en' => $englishMessage,
                            's_title_ar' => $arabicMessage,
                            'i_action' => 0,
                            'b_enabled' => 1,
                            'dt_created_date' => date('Y-m-d H:i:s')
                        ]);
                        $notification_data = [
                            'i_notification_id' => $notification->pk_i_id
                        ];

                        foreach ($userIds as $id) {
                            NotificationUser::create([
                                'fk_i_notification_id' => $notification->pk_i_id,
                                'fk_i_user_id' => $id,
                                'dt_created_date' => date('Y-m-d H:i:s')
                            ]);
                        }
//                        $this->send_notification('http://clinics.newline.ps/api/v1/pns/push_notification/', $notification_data);
                    }
                    break;
            }
            return response()->json(['status' => 1]);
        }
        return response()->json(['status' => 0]);
    }

    public function storeSystemSettings(Request $request)
    {
        $method = $request->input('method');
        switch ($method) {
            case 'tab1':
                Setting::where('s_key', 'website_title')->update(['s_value' => $request->input('website_name'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'super_admin_email')->update(['s_value' => $request->input('website_email'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'website_url')->update(['s_value' => $request->input('website_url'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'facebook_url')->update(['s_value' => $request->input('facebook_url'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'twitter_url')->update(['s_value' => $request->input('facebook_url'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                break;
            case 'tab2':
                Setting::where('s_key', 'smtp_mail_server')->update(['s_value' => $request->input('smtp_mail_server'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'smtp_port')->update(['s_value' => $request->input('smtp_port'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'smtp_email')->update(['s_value' => $request->input('smtp_email'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'smtp_password')->update(['s_value' => $request->input('smtp_password'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                break;
            case 'tab3':
                Setting::where('s_key', 'sms_api_url')->update(['s_value' => $request->input('sms_api_url'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var1')->update(['s_value' => $request->input('sms_api_var1'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var2')->update(['s_value' => $request->input('sms_api_var2'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var3')->update(['s_value' => $request->input('sms_api_var3'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var4')->update(['s_value' => $request->input('sms_api_var4'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var_to')->update(['s_value' => $request->input('sms_api_var_to'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
                Setting::where('s_key', 'sms_api_var_message')->update(['s_value' => $request->input('sms_api_var_message'), 'dt_modified_date' => date('Y-m-d H:i:s')]);

                break;
        }

        return response()->json(['status' => 1]);
    }

    public function showConstant()
    {
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        return view('admin.country');
    }

    public function showCategories(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        $categories = CategoryView::where('s_parent_id',0)->get();
//        foreach ($categories as $category){
//            $subCategories = CategoryView::where('s_parent_id',$category->pk_i_id)->get();
//            if(count($subCategories)){
//                $subCategoriesLevel2[] = $subCategories;
//            }
//        }
        $subCategoriesLevel2 = CategoryView::get();
        return view('admin.category', compact('categories','subCategoriesLevel2'));
    }

    public function showCity($country_id)
    {
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        $name = "";
        $nam = ConstantView::where('pk_i_id', $country_id)->first(['s_name']);
        if (!empty($nam)) {
            $name = $nam->s_name;
        }
        return view('admin.city', compact('country_id', 'name'));
    }

    public function showDistrict($city_id)
    {
        $name2 = "";
        $name1 = "";
        $nam2 = ConstantView::where('pk_i_id', $city_id)->first(['s_name', 'fk_i_parent_id']);

        if (!empty($nam2)) {
            $name2 = $nam2->s_name;
            $nam1 = ConstantView::where('pk_i_id', $nam2->fk_i_parent_id)->first(['s_name']);
        }
        if (!empty($nam1)) {
            $name1 = $nam1->s_name;
        }
        return view('admin.district', compact('city_id', 'name1', 'name2'));
    }

    public function storeConstant(Request $request)
    {
        $this->validate($request, [
            'name_ar' => 'required',
            'name_en' => 'required',
            'c_status' => 'required'
        ]);
        $check = Constant::where('s_name_en', $request->input('name_en'))->orWhere('s_name_ar', $request->input('name_ar'))->count();

        if ($check == 0) {
            $table = [
                's_name_en' => $request->input('name_en'),
                's_name_ar' => $request->input('name_ar'),
                'b_enabled' => $request->input('c_status'),
                's_key' => $request->input('key'),
                'fk_i_parent_id' => $request->input('fk_i_parent_id'),
                'dt_created_date' => date('Y-m-d H:i:s')
            ];
            $constant = new Constant();
            $constant->storeConstant($table);
            return back()->with('msg', trans('lang.added'));
        }
        return back()->with('error_msg', trans('lang.exists'));
    }

    public function insertCategory(Request $request){
//        $this->validate($request, [
//            'name_ar' => 'required',
//            'name_en' => 'required',
//            'c_status' => 'required'
//        ]);
//        $check = Category::where('s_name_en', $request->input('name_en'))->orWhere('s_name_ar', $request->input('name_ar'))->count();
//
//        if ($check == 0) {
//            Category::create([
//                's_name_en' => $request->input('name_en'),
//                's_name_ar' => $request->input('name_ar'),
//                's_parent_id' => 0,
//                'b_enabled' => $request->input('c_status'),
//                'dt_created_date' => date('Y-m-d H:i:s')
//            ]);
//            return back()->with('msg', trans('lang.added'));
//        }
//        return back()->with('error_msg', trans('lang.exists'));
        $check = 0;
        $name_en = $request->input('name_en');
        $name_ar = $request->input('name_ar');
        $parentID = 0;
        if($request->input('subCategoryTypeAdding2')){
            $parentID = $request->input('subCategoryTypeAdding2');
        }
        else if ($request->input('subCategoryTypeAdding1')){
            $parentID = $request->input('subCategoryTypeAdding1');
        }
        else{
            $parentID = $request->input('categoryTypeAdding1');
        }
        $check = Category::where('s_parent_id',$parentID)->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();
        if(!$check){
            Category::create([
                's_name_en' => $request->input('name_en'),
                's_name_ar' => $request->input('name_ar'),
                's_parent_id' => $parentID,
                'b_enabled' => $request->input('c_status'),
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            return back()->with('msg', trans('lang.added'));
        }
        return back()->with('error_msg', trans('lang.exists'));
    }

    public function updateConstant(Request $request)
    {
        $this->validate($request, [
            'name_ar' => 'required',
            'name_en' => 'required',
            'c_status' => 'required'
        ]);
        $pk_i_id = $request->input('pk_i_id');
        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');
//        $check = Constant::where('pk_i_id', '<>', $pk_i_id)->where('s_name_en', $request->input('name_en'))->orWhere('s_name_ar', $request->input('name_ar'))->count();
        $check = Constant::where('pk_i_id', '!=', $pk_i_id)->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if ($check == 0) {

            $table = [
                's_name_en' => $request->input('name_en'),
                's_name_ar' => $request->input('name_ar'),
                'b_enabled' => $request->input('c_status'),
                'dt_modified_date' => date('Y-m-d H:i:s')
            ];
            $constant = new Constant();
            $constant->updateConstant($table, $pk_i_id);
            return back()->with('msg', trans('lang.updated'));
        }
        return back()->with('error_msg', trans('lang.exists'));

    }


    public function subscribePlan()
    {
        $subscription_packages = SubscriptionPackageView::all();
        return view('admin.subscribe_plan.show', compact('subscription_packages'));
    }


    public function getSubscribePlan($id)
    {
        $subscription_packages = SubscriptionPackageView::where('pk_i_id', $id)->first();
        return view('admin.subscribe_plan.iframe', compact('subscription_packages'))->render();
    }

    public function updateSubscribePlan(Request $request)
    {
        $method = $request->input('method');
        if ($method == 'update') {
            SubscriptionPackage::where('pk_i_id', $request->input('pk_i_id'))
                ->update([
                    's_name_en' => $request->input('subscription_package_en'),
                    's_name_ar' => $request->input('subscription_package_ar'),
                    'i_users_count' => $request->input('users_count'),
                    'i_services_count' => $request->input('services_count'),
                    'i_request_count' => $request->input('request_count'),
                    'i_sms_notification' => $request->input('sms_notification'),
                    'i_email_notification' => $request->input('email_notification'),
                    'd_percentage' => $request->input('percentage'),
                    'd_price' => $request->input('price'),
                    'i_duration' => $request->input('duration'),
                    'b_enabled' => $request->input('status'),
                    'b_listed_on_homepage' => $request->input('listed'),
                    'dt_modified_date' => date('Y-m-d H:i:s')
                ]);
            return back()->with([
                'msg' => trans('lang.updated')
            ]);
        } else if ($method == 'delete') {
            SubscriptionPackage::where('pk_i_id', $request->input('pk_i_id'))->update(['dt_deleted_date' => date('Y-m-d H:i:s'), 'b_enabled' => 0]);
            return response()->json();
        } else if ($method == 'updatePlan') {

        }

    }

    public function createSubscribePlan()
    {
        return view('admin.subscribe_plan.create');

    }

    public function storeSubscribePlan(Request $request)
    {
        $this->validate($request, [
            'subscription_package_en' => 'required',
            'subscription_package_ar' => 'required',
            'users_count' => 'required|integer|min:1',
            'services_count' => 'required|integer|min:1',
            'request_count' => 'required|integer|min:1',
            'sms_notification' => 'required|integer|min:1',
            'email_notification' => 'required|integer|min:1',
            'percentage' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'status' => 'required',
            'listed' => 'required'
        ]);

        $check = SubscriptionPackage::where('s_name_en', $request->input('subscription_package_en'))
            ->orWhere('s_name_ar', $request->input('subscription_package_ar'))
            ->count();
        if ($check == 0) {
            SubscriptionPackage::create([
                's_name_en' => $request->input('subscription_package_en'),
                's_name_ar' => $request->input('subscription_package_ar'),
                'i_users_count' => $request->input('users_count'),
                'i_services_count' => $request->input('services_count'),
                'i_request_count' => $request->input('request_count'),
                'i_sms_notification' => $request->input('sms_notification'),
                'i_email_notification' => $request->input('email_notification'),
                'd_percentage' => $request->input('percentage'),
                'd_price' => $request->input('price'),
                'i_duration' => $request->input('duration'),
                'b_enabled' => $request->input('status'),
                'b_listed_on_homepage' => $request->input('listed'),
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.subscribe_plan')->with('msg', trans('lang.added'));
        }
        return back()->with('error_msg', trans('lang.exists'));

    }

    public function Company()
    {
        $data['Company'] = Company::where('dt_deleted_date', '!=', null)->get();
        //$data['status'] = ConstantView::getIdNameData('COMPANY_STATUS')->prepend(trans('lang.choose_option'), "");
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->pluck('s_name', 'pk_i_id');
        // $data['subscription_package'] = SubscriptionPackageView::pluck('s_name', 'pk_i_id')->prepend(trans('lang.choose_option'), "");
        return view('admin.service_provider.show', $data);
    }

    public function showUsers($id)
    {
        $name = CompanyView::where('pk_i_id', $id)->first(['s_name'])->s_name;
        return view('admin.service_provider.users.show', compact('id', 'name'));
    }

    public function showAllUsers(Request $request)
    {
        $status = ConstantView::getIdNameData('STATUS')->prepend(trans('lang.show_all'), '');;
        $user_role = ConstantView::getIdNameData('USERS_ROLES')->forget(5)->prepend(trans('lang.show_all'), '');
        return view('admin.users.show', compact('status', 'user_role'));
    }

    public function showAllProviders(){
//        $status = ConstantView::getIdNameData('STATUS')->prepend(trans('lang.show_all'), '');
//        $categories = CategoryView::where('s_parent_id', 0)->pluck('s_name', 'pk_i_id')->prepend(trans('lang.show_all'), '');
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        $categories = CategoryView::where('s_parent_id',0)->get();
        return view('ServiceProvider.show', compact('categories'));
    }

    public function showQuotations(Request $request, $userId)
    {
        $data['userId'] = $userId;
        $user = User::where(['pk_i_id' => $userId])->first(['s_first_name', 's_last_name']);
        $data['user_name'] = $user->s_first_name . ' ' . $user->s_last_name;
        return view('admin.quotation.show', $data);
    }

    public function showStatistics(Request $request, $userId)
    {
        $data['userId'] = $userId;
        $user = User::where(['pk_i_id' => $userId])->first(['s_first_name', 's_last_name']);
        $data['user_name'] = $user->s_first_name . ' ' . $user->s_last_name;
        $CompanyId = ServiceProviderUser::where(['fk_i_user_id' => $userId, 'fk_i_role_id' => 6])->first(['fk_i_company_id'])->fk_i_company_id;
        $data['receiveRequests'] = NotificationUser::where(['fk_i_user_id' => $userId])->get()->map(function ($items) {
            return $items->notification->where('s_ids', 'not like', '%/%')->where('s_ids', '!=', null);
        })->count();
        $data['repliedRequests'] = RequestProposedSP::where(['fk_i_company_id' => $CompanyId, 'i_replied' => 1])->count();

        $data['inProcessRequests'] = collect(new RequestClass());
        $requestIds = collect();
        $nUser = NotificationUser::where(['fk_i_user_id' => $userId])->get();
        foreach ($nUser as $n) {
            $ids = $n->notification->where('s_ids', '!=', null)->where('s_ids', 'not like', '%/%')->get(['s_ids']);
            $requestIds->push($ids);
        }

        foreach ($requestIds as $d) {
            $myData = RequestClass::where(['i_status' => 57, 'pk_i_id' => $d[0]])->get();
            $data['inProcessRequests']->push($myData);
        }

        return view('admin.showStatistics', $data);
    }


    public function viewQuotations($quotationId)
    {
        $data['requestsQuotation'] = RequestQuotation::where(['pk_i_id' => $quotationId])->first();
        $data['requestId'] = $data['requestsQuotation']->fk_i_request_id;
        $data['CompanyId'] = $data['requestsQuotation']->fk_i_company_id;
        return view('admin.quotation.iframe', $data)->render();
    }

    /**
     * @param $id
     */

    public function CompanyProfile($id)
    {
        $data['user'] = User::where('pk_i_id', session('user_id'))->first();
        $data['service_provider'] = Company::where('pk_i_id', $id)->first();
        // $data['working'] = SPWorkingHours::where('fk_i_company_id', $id)->get();
        $data['profileMeta'] = ProfileMeta::where(['fk_i_ref_id' => $id])->get()->keyBy('s_key');
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->get();
        return view('user.provider_admin.profile', $data);

    }


    public function changeSubscriptionPackage(Request $request)
    {
        $provider_id = $request->input('pk_i_id');
        $subscription_id = $request->input('subscription');
        $user_id = ServiceProviderUser::where(['fk_i_company_id' => $provider_id, 'fk_i_role_id' => 6])->first()->fk_i_user_id;

        $last = Invoice::where(['fk_i_company_id' => $provider_id])->get()->last();
        if (isset($last) && !empty($last)) {
            Invoice::where(['pk_i_id' => $last->pk_i_id])->update(['fk_i_subscription_package_id' => $subscription_id]);
        } else {

            $d = SubscriptionPackage::where('pk_i_id', $subscription_id)->first(['i_duration']);
            $expire = date('Y-m-d h:i:s', strtotime("+$d->i_duration day"));
            Invoice::create([
                'fk_i_user_id' => $user_id,
                'fk_i_company_id' => $provider_id,
                'fk_i_subscription_package_id' => $subscription_id,
                'dt_created_date' => date('Y-m-d H:i:s'),
                'dt_seen_date' => date('Y-m-d H:i:s'),
                'dt_expired_date' => $expire,
            ]);
        }
        ServiceProvider::where('pk_i_id', $provider_id)->update([
            'fk_i_subscription_package_id' => $subscription_id,
            'dt_modified_date' => date('Y-m-d H:i:d')
        ]);
        return back()->with('msg', trans('lang.updated'));

    }

    public function changeStatus(Request $request, $id)
    {

        User::where(['pk_i_id' => $id])->update(['b_enabled' => $request->input('status'), 'dt_modified_date' => date('Y-m-d H:i:s')]);
        return response()->json(['status' => 1]);
    }

    public function changeCompanyStatus(Request $request, $id)
    {
//                dd($request->input('status'));
        ServiceProvider::where('pk_i_id',$id)->update([
            'b_enabled' => $request->input('status'),
            'i_roles_id' => $request->input('stID')
        ]);

        ServiceProviderUser::where('fk_i_service_provider_id',$id)->update([
            'b_enabled' => $request->input('status')
        ]);

        $userID = ServiceProviderUser::where('fk_i_service_provider_id',$id)->first(['fk_i_user_id']);

        User::where('pk_i_id',$userID->fk_i_user_id)->update(['b_enabled' => $request->input('status'), 'dt_modified_date' => date('Y-m-d H:i:s')]);

//        $providers = ServiceProvider::find(1)->tCompanyUsers()->where('fk_i_role_id',6)->first();
        $activeMessage = "تم تفعيل حساب الشركة لدى مستشفى جمعية المقاصد الخيرية";
        $deactivateMessage = "تم تعطيل حساب الشركة لدى مستشفى جمعية المقاصد الخيرية";
        $englishMessage = "Company Account was activated ..";
//                foreach ($providers as $provider){
        $sms = new SMSController();
//                    $user = ServiceProvider::where(['pk_i_id' => $id])->first(['s_default_language', 's_mobile_number']);
        $company = ServiceProvider::where(['pk_i_id' => $id])->first();
//                }
//                if ($company->s_default_language == 'ar') {
        $providerID = ServiceProviderUser::where('fk_i_service_provider_id',$company->pk_i_id)->first(['fk_i_user_id']);
        $notificationTemplateActivate = collect(DB::select(DB::raw("SELECT * FROM t_notification_template WHERE  pk_i_id = 3 ")));
        $notificationTemplateDeActivate = collect(DB::select(DB::raw("SELECT * FROM t_notification_template WHERE  pk_i_id = 4 ")));
        if($request->input('status') == 0) {
            $notification = Notification::create([
                'fk_i_actor_user_id' => $providerID->fk_i_user_id,
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_ar' => $notificationTemplateDeActivate[0]->s_template_ar,
                's_title_en' => $notificationTemplateDeActivate[0]->s_template_en,
                'fk_i_notification_template_id' => 4,
                'i_action' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $providerID->fk_i_user_id,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            $sms->send($company->s_mobile_number, $deactivateMessage);
            Mail::to($company->s_email)->send(new ProviderEmail("", $company->s_email, "", $deactivateMessage));
        }
        else {
            $notification = Notification::create([
                'fk_i_actor_user_id' => $providerID->fk_i_user_id,
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_ar' => $notificationTemplateActivate[0]->s_template_ar,
                's_title_en' => $notificationTemplateActivate[0]->s_template_en,
                'fk_i_notification_template_id' => 3,
                'i_action' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $providerID->fk_i_user_id,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            $sms->send($company->s_mobile_number, $activeMessage);
            Mail::to($company->s_email)->send(new ProviderEmail("", $company->s_email, "", $activeMessage));
        }
//                } else {
//                    $sms->send($user->s_mobile_number, $englishMessage);
//            }

        return response()->json(['status' => 1]);
    }

    public function showCategory()
    {
        return view('Category.index');
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getRoles());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->saveInstance($request);
        return view('welcome');


    }


    private function getRoles()
    {
        return [
            'categoryName_ar' => 'required',
            'categoryName_en' => 'required',
            'status' => 'required'
        ];
    }

    private function getMessages()
    {
        return [
            'categoryName_ar.required' => 'يجب تعبئة اسم التصنيف (عربي)',
            'categoryName_en.required' => 'يجب تعبئة اسم التصنيف (انجليزي)',
            'status.required' => 'يجب اختيار حالة التصنيف',

        ];
    }

    private function saveInstance($request)
    {
        $category = new Category();
        $category->s_category_name_ar = '' . $request->input('categoryName_ar');
        $category->s_category_name_en = $request->input('categoryName_en');
        $category->b_enabled = strcmp($request->input('status'), 'فعال') == 0 ? 1 : 0;
        $category->dt_created_date = Carbon::now();
        $category->dt_modified_date = Carbon::now();
        return $category->save();


    }

    public function getCategory(Request $request)
    {

        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;


        return response()->json(['data' => $this->convertFromObjectToArray(Category::where('dt_deleted_date', null)->get())]);
        //return Service::getServices();
    }

    private function convertFromObjectToArray($arrayOfObjects)
    {
        $result = Array();
        foreach ($arrayOfObjects as $object) {
            $temp = Array();
            $temp['id'] = $object->pk_i_id;
            $temp['category_name_en'] = $object->s_category_name_en;
            $temp['category_name_ar'] = $object->s_category_name_ar;
            $temp['enabled'] = strcmp($object->b_enabled, 1) == 0 ? 'فعال' : 'غير فعال';
            $temp['serviceNumber'] = ServiceCategory::where(['fk_i_category_id' => $object->pk_i_id, 'dt_deleted_date' => null])->get()->count();
            $temp['buttons'] = '';

            array_push($result, $temp);
        }
        return $result;

    }

    public function getCategoryInfo(Request $request)
    {
        //   dd($request['body']);
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;

        $result = Array();
        $category = Category::find(intval($request['id']));
        $result['category'] = $category;
        $temp = Array();
        $categoryOfService = ServiceCategory::where(['fk_i_category_id' => $category->pk_i_id, 'dt_deleted_date', null])->get();
        foreach ($categoryOfService as $key => $value) {
            $tempService = Array();
            $services = Service::find(intval($value->service_id));
            $tempService['serviceId'] = $services->pk_i_id;
            $tempService['serviceName'] = $services->s_service_name_ar;
            array_push($temp, $tempService);
        }
        array_push($result, $temp);
        return json_encode($result);

    }


    public function removeCategory(Request $request)
    {
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;

        echo $request['body'];
        $category = Category::find(intval($request['body']));
        $category->dt_deleted_date = Carbon::now();
        $category->save();

        $category = ServiceCategory::where('fk_i_category_id', $request['body'])->get();
        foreach ($category as $tempCategory) {
            $tempCategory->dt_deleted_date = Carbon::now();
            $tempCategory->save();
        }
        return json_encode('200');

    }

    public function addCategoryAjax(Request $request)
    {
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;
        // dd($request['body']);
        $validator = Validator::make($request['body'][0], $this->getRoles(), $this->getMessages());
        if ($validator->fails()) {
            return response()->json(['status' => 404, 'message' => $validator->errors()]);
        }
        $categorName_ar = $request['body'][0]['categoryName_ar'];
        $categorName_en = $request['body'][0]['categoryName_en'];
        $status = $request['body'][0]['status'];

        $category = new Category();
        $category->s_category_name_ar = $categorName_ar;
        $category->s_category_name_en = $categorName_en;
        $category->b_enabled = strcmp($status, 'فعال') == 0 ? 1 : 0;
        $category->dt_created_date = Carbon::now();
        $category->dt_modified_date = Carbon::now();
        $category->save();

        return response()->json($this->DONE_JSON_MESSAGE);

    }

    public function getSingleCategory(Request $request)
    {
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;

        return response()->json(['status' => 200, 'category' => Category::find(intval($request['body']))]);

    }

    public function editCategory(Request $request)
    {
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;

        $categoryId = intval($request['body'][0]['id']);
        $category = Category::find($categoryId);
        $category->s_category_name_ar = $request['body'][0]['categoryName_ar'];
        $category->s_category_name_en = $request['body'][0]['categoryName_en'];
        $category->b_enabled = strcmp($request['body'][0]['enabled'], 'فعال') == 0 ? 1 : 0;
        $category->dt_modified_date = Carbon::now();
        $category->save();

        return response()->json($this->DONE_JSON_MESSAGE);
    }


    public function getTableData(Request $request, $table, $key)
    {

        $modelName = '\App' . '\\' . $table;
        $class = new $modelName();
        if (is_numeric($key)) {
            $data = $class::getAllChildren($key);
        } else {
            $data = $class::getAllData($key);
        }

        return Datatables::of($data)
            ->make(true);

    }

    public function getConstantData(Request $request, $table, $key)
    {

//        $modelName = '\App' . '\\' . $table;
//        $class = new $modelName();
//        if (is_numeric($key)) {
//            $data = $class::getAllChildren($key);
//        } else {
//            $data = $class::getAllData($key);
//        }

        $data['itemsType'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','ITEM_TYPE']
        ])->get();

        $data['itemsUnit'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','ITEM_UNIT']
        ])->get();

        $data['status'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','STATUS']
        ])->get();

        $data['currencies'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','CURRENCY']
        ])->get();

        $data['categories'] = CategoryView::where('s_parent_id','=',0)->get();

        return response()->json(['itemsType' => $data['itemsType'], 'itemUnits' => $data['itemsUnit'], 'status' => $data['status'], 'categories' => $data['categories'], 'currencies' => $data['currencies']]);

    }

    public function getCategories(Request $request, $model){
        if($model == 'CATEGORY') {
            $categories = CategoryView::where('s_parent_id','=',0)->get();
            return Datatables::of($categories)->with(['cat' => $categories])
                ->make(true);
        }
        else if($model == 'SUBCATEGORY'){
            $subCategories = CategoryView::where('s_parent_id', $request['categoryID'])->get();
            return Datatables::of($subCategories)->make(true);
        }
    }

    public function updateCategory(Request $request){
        $catID = $request->input('pk_i_id');
        $catSeries = $request->input('categoriesSeries');
        $category = CategoryView::where('pk_i_id',$catID)->with(['childrenRecursive'])->first()->toArray();
        $catArray = array();
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($category)) as $key=>$arr){
            if($key == 'pk_i_id')
                $catArray[] = $arr;
        }
        $intArray = array_map(function($value) { return (int)$value; },
            explode(',', $catSeries[0])
        );
        $bool = array_intersect($intArray, $catArray);
        if(count($bool)){
            return back()->with('error_msg', trans('lang.conflictMovedCategory'));
        }
        $this->validate($request, [
            'name_ar' => 'required',
            'name_en' => 'required',
            'c_status' => 'required'
        ]);
        if($request->input('subCategoryTypeAdding2')){
            $parent_id = $request->input('subCategoryTypeAdding2');
        }
        else if($request->input('subCategoryTypeAdding1')){
            $parent_id = $request->input('subCategoryTypeAdding1');
        }
        else{
            $parent_id = $request->input('categoryTypeAdding1');
        }
        $pk_i_id = $request->input('pk_i_id');
        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');
//        $parent_id = $request->input('parentID');
        $check = Category::where([
            ['pk_i_id', '!=', $pk_i_id],
            ['s_parent_id','=',$parent_id]
        ])->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if ($check == 0) {
            Category::where('pk_i_id',$pk_i_id)->update([
                's_name_en' => $name_en,
                's_name_ar' => $name_ar,
                's_parent_id' => $parent_id,
                'b_enabled' => $request->input('c_status')
            ]);
            return back()->with('msg', trans('lang.updated'));
        }
        return back()->with('error_msg', trans('lang.exists'));
    }

    public function getBankAccounts($id){

        $user_id = session('user_id');
        $userStatus = User::where('pk_i_id',$user_id)->first()->userRule->s_name_en;

        if($userStatus == 'SuperAdmin'){
            $bankAccounts = BankAccount::where('fk_i_company_id',$id)->with(['status','attachment'])->get();
        }
        else{
            $bankAccounts = BankAccount::where([
                'fk_i_company_id' => $id,
                'b_enabled' => 1
            ])->with(['status','attachment'])->get();
        }
        return Datatables::of($bankAccounts)->make(true);

    }

    public function showSubCategories($categoryID){
        $name = "";
        $nam = CategoryView::where('pk_i_id', $categoryID)->first(['s_name']);
        if (!empty($nam)) {
            $name = $nam->s_name;
        }
        return view('admin.subCategory', compact('categoryID', 'name'));
    }

    public function insertSubCategory(Request $request){

        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');
        $check = Category::where('s_parent_id', '=', $request->input('s_parent_id'))->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();
        if ($check == 0) {
            Category::create([
                's_name_en' => $request->input('name_en'),
                's_name_ar' => $request->input('name_ar'),
                's_parent_id' => $request->input('s_parent_id'),
                'b_enabled' => $request->input('c_status'),
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            return back()->with('msg', trans('lang.added'));
        }
        return back()->with('error_msg', trans('lang.exists'));
    }

    public function updateSubCategory(Request $request){
        $pk_i_id = $request->input('pk_i_id');
        $parenID = $request->input('fk_parent_i_id');
        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');
        $check = Category::where([
            ['pk_i_id', '!=', $pk_i_id],
            ['s_parent_id', '=',$parenID ]
        ])->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if ($check == 0) {
            Category::where('pk_i_id',$pk_i_id)->update([
                's_name_en' => $name_en,
                's_name_ar' => $name_ar,
                'b_enabled' => $request->input('c_status')
            ]);
            return back()->with('msg', trans('lang.updated'));
        }
        return back()->with('error_msg', trans('lang.exists'));
    }

    public function getAllCategories($id){
        $data = new Collection;
        if($id == -1){
//            $parentCategories = CategoryView::where('s_parent_id',0)->get();
//            foreach ($parentCategories as $key1 => $categories){
//                $data->push([
//                    's_name_ar'         =>  $categories->s_name_ar,
//                    's_name_en'       => $categories->s_name_en,
//                    's_name'      => $categories->s_name,
//                    'pk_i_id' => $categories->pk_i_id,
//                    'b_enabled' => $categories->b_enabled,
//                ]);
//                $subCategories = CategoryView::where('s_parent_id',$categories->pk_i_id)->get();
//                if(count($subCategories)){
//                    foreach ($subCategories as $sub){
//                        $data->push([
//                            's_name_ar'         =>  $sub->s_name_ar,
//                            's_name_en'       => $sub->s_name_en,
//                            's_name'      => $sub->s_name,
//                            'pk_i_id' => $sub->pk_i_id,
//                            'b_enabled' => $sub->b_enabled,
//                        ]);
////                        $count++;
////                        $data[$count] = new CategoryView();
////                        $data[$count]->s_name_ar = $sub->s_name_ar;
////                        $data[$count]->s_name_en = $sub->s_name_en;
////                        $data[$count]->s_name = $sub->s_name;
////                        $data[$count]->pk_i_id = $sub->pk_i_id;
////                        $data[$count]->b_enabled = $sub->b_enabled;
//                    }
//                }
//            }
            $data = CategoryView::get();
        }
        else if ($id == 0){
            $data = CategoryView::where('s_parent_id',0)->get();
        }
        else{
            $data = CategoryView::where('s_parent_id',$id)->get();
        }
        return Datatables::of($data)->make(true);

    }

    public function newItem(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        return view('admin.newItem');

    }

    public function addNewItem(Request $request){

        if($request->input('subCategory3')){
            $categoryID = $request->input('subCategory3');
        }
        else if($request->input('subCategory2'))
            $categoryID = $request->input('subCategory2');
        else if ($request->input('subCategory1'))
            $categoryID = $request->input('subCategory1');
        else
            $categoryID = $request->input('superCategory');

        $superCategory = $request->input('superCategory');

//        $id = DB::table('t_items')->insertGetId(
//            array(
//                's_name_ar' => $request->input('s_name_ar'),
//                's_name_en' => $request->input('s_name_en'),
//                'fk_i_cat_id' => $categoryID,
//                'i_type' => $request->input('i_type'),
//                'i_unit' => $request->input('i_unit'),
//                'd_price' => $request->input('d_price'),
//                'i_currency' => $request->input('i_currency'),
//                's_description' => $request->input(),
//                'b_enabled' => $request->input('c_status'),
//                's_barcode' => $request->input('s_barcode'),
//                'dt_created_at' => date('Y-m-d h:i:s')
//            )
//        );
        $item = Items::create([
            's_name_ar' => $request->input('s_name_ar'),
            's_name_en' => $request->input('s_name_en'),
            'fk_i_cat_id' => $categoryID,
            'i_parent_cat_id' => $superCategory,
            'i_type' => $request->input('i_type'),
            'i_unit' => $request->input('i_unit'),
            'd_price' => $request->input('d_price'),
            'i_currency' => $request->input('i_currency'),
            's_description' => $request->input('s_description'),
            'b_enabled' => $request->input('c_status'),
            's_barcode' => $request->input('s_barcode'),
            's_brand' => $request->input('s_brand'),
            'dt_created_at' => date('Y-m-d h:i:s')
        ]);
        if ($file = $request->file('item_image')) {
            $image_name = time() . $file->getClientOriginalName();
            $file->move('images/items_images', $image_name);
            Items::where('pk_i_id', $item->pk_i_id)->update(['s_photo' => $image_name]);
        }

        return back()->with('msg', trans('lang.added'));
    }

    public function checkUniqueItem(Request $request){
        if($request['subCategory2'])
            $categoryID = $request['subCategory2'];
        else if ($request['subCategory1'])
            $categoryID = $request['subCategory1'];
        else
            $categoryID = $request['superCategory'];

        $name_ar = $request['itemNameAr'];
        $name_en = $request['itemNameEn'];

        $check1 = Items::where('fk_i_cat_id',$categoryID)->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

//            $check = ItemsView::where([
//                's_name_ar' => $request['itemNameAr'],
//                's_name_en' => $request['itemNameEn'],
//                'fk_i_cat_id' => $categoryID,
//                's_barcode' => $request['itemCode']
//            ])->count();


        if($check1)
            return response()->json(['msg' => 0]);

        $check2 = Items::where('s_barcode',$request['itemCode'])->count();

        if ($check2)
            return response()->json(['msg' => 1]);

        return response()->json(['msg' => 2]);

    }

    public function checkBarcodeItem(Request $request){
        $check = Items::where('s_barcode',$request['itemBarcode'])->count();
        if($check)
            return response()->json(['status' => true]);
        else{
            return response()->json(['status' => false]);
        }

    }

    public function showItems(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        $categories = CategoryView::where('s_parent_id',0)->get();
        $items = Items::get();

        return view('admin.items', compact('categories', 'items'));
    }

    public function getItems(){
        $data = ItemsView::where('b_enabled','<>',2)->with(['category'])->get();
        return Datatables::of($data)->make(true);
    }

    public function getItem(Request $request, $id){

        $data['item'] = Items::where('pk_i_id',$id)->first();
        $parents = CategoryView::where('pk_i_id','=',$data['item']->fk_i_cat_id)->with('parentRecursive2')->first(['pk_i_id','s_name','s_parent_id']);
//        $categoriesIDS = "";
//        $data['itemCategorylevel1'] = CategoryView::where('pk_i_id',$data['item']->fk_i_cat_id)->first();
//        $categoriesIDS = $data['itemCategorylevel1']->pk_i_id;
//        $data['itemCategoryFinalLevel'] = $data['itemCategorylevel1'];
//        if($data['itemCategorylevel1']->s_parent_id != 0) {
//            $data['itemCategorylevel2'] = CategoryView::where('pk_i_id', $data['itemCategorylevel1']->s_parent_id)->first();
//            $categoriesIDS = $categoriesIDS."-".$data['itemCategorylevel2']->pk_i_id;
//            $data['itemCategoryFinalLevel'] = $data['itemCategorylevel2'];
//            if($data['itemCategorylevel2']->s_parent_id != 0){
//                $data['itemCategorylevel3'] = CategoryView::where('pk_i_id', $data['itemCategorylevel2']->s_parent_id)->first();
//                $categoriesIDS = $categoriesIDS."-".$data['itemCategorylevel3']->pk_i_id;
//                $data['itemCategoryFinalLevel'] = $data['itemCategorylevel3'];
//            }
//        }

        $unit = $data['item']->i_unit;
        $type = $data['item']->i_type;
        $currency = $data['item']->i_currency;
        $status = $data['item']->i_status;

        $data['itemsType'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['s_key','=','ITEM_TYPE']
        ])->where(function ($query) use ($type){
            $query->where('b_enabled', 1)->orWhere('pk_i_id', $type);
        })->get();

        $data['itemsUnit'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['s_key','=','ITEM_UNIT']
        ])->where(function ($query) use ($unit){
            $query->where('b_enabled', 1)->orWhere('pk_i_id', $unit);
        })->get();

        $data['status'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['s_key','=','STATUS']
        ])->where(function ($query) use ($status){
            $query->where('b_enabled', 1)->orWhere('pk_i_id', $status);
        })->get();

        $data['currencies'] = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['s_key','=','CURRENCY']
        ])->where(function ($query) use ($currency){
            $query->where('b_enabled', 1)->orWhere('pk_i_id', $currency);
        })->get();

        $data['categories'] = CategoryView::where('s_parent_id','=',0)->get();

        return view('admin.editItem',$data)->with(['parents' => $parents]);
//        return view('admin.editItem',$data)->with(['categoriesIDS' => $categoriesIDS]);

    }

    public function updateItemInformation(Request $request, $id){
        if($request->input('subCategory3'))
            $categoryID= $request->input('subCategory3');
        else if($request->input('subCategory2'))
            $categoryID = $request->input('subCategory2');
        else if ($request->input('subCategory1'))
            $categoryID = $request->input('subCategory1');
        else
            $categoryID = $request->input('superCategory');

        $name_ar = $request->input('s_name_ar');
        $name_en = $request->input('s_name_en');

        $check = Items::where([
            ['pk_i_id','<>',$id],
            ['fk_i_cat_id','=',$categoryID]
        ])->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if($check){
            return back()->with('error_msg', trans('lang.exists'));
        }

        $check2 = Items::where([
            ['pk_i_id','<>',$id],
            ['s_barcode','=',$request->input('s_barcode')]
        ])->count();

        if ($check2){
            return back()->with('error_msg', trans('lang.itemBarcodeAlreadyExist'));
        }

        if(!$check){
            Items::where('pk_i_id',$id)->update([
                's_name_ar' => $request->input('s_name_ar'),
                's_name_en' => $request->input('s_name_en'),
                'fk_i_cat_id' => $categoryID,
                'i_type' => $request->input('i_type'),
                'i_unit' => $request->input('i_unit'),
                'd_price' => $request->input('d_price'),
                'i_currency' => $request->input('i_currency'),
                's_description' => $request->input('s_description'),
                'b_enabled' => $request->input('b_enabled'),
                's_barcode' => $request->input('s_barcode'),
                's_brand' => $request->input('s_brand'),
            ]);
            if ($file = $request->file('item_image')) {
                $image_name = time() . $file->getClientOriginalName();
                $file->move('images/items_images', $image_name);
                Items::where('pk_i_id', $id)->update(['s_photo' => $image_name]);
            }
            return back()->with('msg', trans('lang.updated'));
        }

        return back()->with('error_msg', trans('lang.exists'));

    }

    public function getAllItems($id){

        if($id == 0)
            $data = ItemsView::where('b_enabled',1)->orWhere('b_enabled',0)->with(['category'])->get();
        else
            $data = ItemsView::where(['fk_i_cat_id' => $id])->where(function ($query){
                $query->where('b_enabled', 1)->orWhere('b_enabled', 0);
            })->with(['category'])->get();

        return Datatables::of($data)->make(true);

    }

    public function deleteItem($id){
        Items::where('pk_i_id',$id)->update([
            'b_enabled' => 2
        ]);
        return response()->json(['status' => 1]);
    }

    public function constantManagement(){

        return view('admin.constantManagement');

    }

    public function unitsItemsManagement(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        return view('admin.unitsItems');
    }

    public function itemsTypeManagement(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        return view('admin.itemsType');
    }

    public function currenciesManagement(){
//        $user = User::where('pk_i_id', session('user_id'))->first();
//        if(!$user){
//            return redirect()->route('index');
//        }
//        if($user->userRule->s_name_en != 'SuperAdmin'){
//            return redirect('/main');
//        }
        return view('admin.currencies');
    }

    public function getConstant($key){
        $data = ConstantView::where([
            ['s_key','=',$key],
            ['fk_i_parent_id','<>',0]
        ])->get();
        return Datatables::of($data)->make(true);
    }

    public function editConstant(Request $request){

        $parentID = ConstantView::where([
            ['s_key', '=', $request->input('key')],
            ['fk_i_parent_id','=',0]
        ])->first(['pk_i_id']);

        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');

        $check = ConstantView::where([
            ['pk_i_id','<>',$request->input('pk_i_id')],
            ['fk_i_parent_id','=',$parentID->pk_i_id]
        ])->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if(!$check){
            Constant::where('pk_i_id',$request->input('pk_i_id'))->update([
                's_name_ar' => $name_ar,
                's_name_en' => $name_en,
                'b_enabled' => $request->input('c_status')
            ]);
            return back()->with('msg', trans('lang.updated'));
        }

        return back()->with('error_msg', trans('lang.exists'));

    }

    public function newConstant(Request $request){

        $name_ar = $request->input('name_ar');
        $name_en = $request->input('name_en');

        $parentID = ConstantView::where([
            ['s_key', '=', $request->input('key')],
            ['fk_i_parent_id','=',0]
        ])->first(['pk_i_id']);

        $check = ConstantView::where([
            ['s_key', '=', $request->input('key')],
            ['fk_i_parent_id','<>',0]
        ])->where(function ($query) use ($name_ar,$name_en){
            $query->where('s_name_en', $name_en)->orWhere('s_name_ar', $name_ar);
        })->count();

        if(!$check){
            Constant::create(array(
                's_name_ar' => $name_ar,
                's_name_en' => $name_en,
                's_key' => $request->input('key'),
                'fk_i_parent_id' => $parentID->pk_i_id,
                'b_enabled' => $request->input('c_status'),
                'dt_created_date' => date('Y-m-d H:i:s')
            ));
            return back()->with('msg', trans('lang.added'));
        }

        return back()->with('error_msg', trans('lang.exists'));

    }

    public function newTender(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();

        $categories = CategoryView::where('s_parent_id',0)->get();

        $items = ItemsView::where('b_enabled',1)->get();

        return view('admin.newTender', compact('currencies', 'items', 'categories'));

    }

    public function addNewTender(Request $request){

//            dd($request->input('startDate'));
        $statDate = Carbon::parse($request->input('startDate'))->format('Y-m-d H:i');
        $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i');

        $nowDate = Carbon::now()->toDateTimeString();
//            $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();

        $status = ( $nowDate > $endDate ) ? 98 : 97;

        $quantities = $request->input('quantityItem');
        $itemsIDS = $request->input('ids');

        $categoriesIDS = ItemsView::whereIn('pk_i_id',$itemsIDS)->get(['fk_i_cat_id'])->toArray();
        foreach ($categoriesIDS as $key=>$cat){
            $categoriesIDS[$key] = $cat['fk_i_cat_id'];
        }

        $companies = CompanyCategories::whereIn('fk_i_categories_id',$categoriesIDS)->with(['company','usercompany'])->get(['fk_i_comapny_id'])->toArray();
        $companiesIDS = array();
        foreach ($companies as $key=>$com){
            $companiesIDS[$key] = $com['fk_i_comapny_id'];
        }

        $id = DB::table('t_tender')->insertGetId(
            [
                's_title' => $request->input('tenderTitle'),
                's_description' => $request->input('editor1'),
                's_terms' => $request->input('tenderTerms'),
                'dt_open_date' => $statDate,
                'dt_close_date' => $endDate,
                'fk_i_currency_id' => $request->input('currency'),
                'fk_i_by_user_id' => session('user_id'),
                'i_status' => $status,
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]
        );


//            for($i=1;$i<=sizeof($quantities);$i++){
//
//                TenderItems::create(array(
//                   'fk_i_tender_id' => $id,
//                    'fk_i_item_id' => $itemsIDS[''.$i.''],
//                    'i_quantity' => $quantities[''.$i.''],
//                    'b_enabled' => 1,
//                    'dt_created_date' => date('Y-m-d H:i:s')
//                ));
//
//            }

        foreach ($quantities as $key=>$quantity){
            TenderItems::create(array(
                'fk_i_tender_id' => $id,
                'fk_i_item_id' => $itemsIDS[$key],
                'i_quantity' => $quantities[$key],
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ));
        }

        if ($request->hasFile('tenderFile')) {
            foreach ($request->file('tenderFile') as $file){
                $file_path = time() .'-'. $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/tender', $file_path);
                Attachments::create(array(
                    'fk_i_refe_id' => $id,
                    'i_attach_type' => 1,
                    's_url' => $file_path,
                    's_name' => $file_name,
                    'dt_created_date' => date('Y-m-d H:i:s')

                ));
            }
        }
        $arabicMessage = "تم تقديم مناقصة جديدة ".$request->input('tenderTitle')." تحتوي على تصنيفات الشركة";
        $englishMessage = "A new tender (".$request->input('tenderTitle').") has been submitted containing the categories of company";
        $sms = new SMSController();
        if(count($companies)){
            $notification = Notification::create([
                'fk_i_actor_user_id' => session('user_id'),
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_en' => $englishMessage,
                's_title_ar' => $arabicMessage,
                'i_action' => 0,
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
        }
        foreach ($companies as $company){
//                        DB::table('t_company_tenders')->insert([
//                           'fk_i_company_id' => $company['fk_i_comapny_id'],
//                            'fk_i_tender_id' => $id,
//                            'dt_created_date' => date('Y-m-d H:i:s')
//                        ]);
            if ($company['usercompany']['user']['s_default_language'] == 'ar') {
                $sms->send($company['company']['s_mobile_number'], $arabicMessage);
                Mail::to($company['company']['s_email'])->send(new AdminEmail($company['usercompany']['user']['s_default_language'], $company['company']['s_email'], $company['company']['s_name'], $arabicMessage));
            } else {
                $sms->send($company['company']['s_mobile_number'], $englishMessage);
                Mail::to($company['company']['s_email'])->send(new AdminEmail($company['usercompany']['user']['s_default_language'], $company['company']['s_email'], $company['company']['s_name'], $englishMessage));
            }
            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $company['usercompany']['user']['pk_i_id'],
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
//                        $sms->send($company['company']['s_mobile_number'], Lang::get('lang.newTenderForYourCategories', ['name' => $request->input('tenderTitle')]));

        }

        return Redirect::route('allTenders')->with('msg', trans('lang.added'));

//            return back()->with('msg', trans('lang.added'));

    }

    public function getItemDetails(Request $request){

        $data = new Collection;

        foreach ($request['itemsVal'] as $itemVal){
            $item = ItemsView::where('pk_i_id',$itemVal)->first();
            $data->push([
                'itemID' => $item->pk_i_id,
                'itemName' =>  $item->s_name,
                'itemUnit' => $item->unit->s_name
            ]);
        }

        return response()->json(['items' => $data]);

    }

    public function getDashboard(){
//            $user_id = session('user_id');
//            $tenders = array();
//            $data['user'] = User::where('pk_i_id',$user_id)->first();
//            if($data['user']->userRule->s_name_en == 'ServiceProviderAdmin'){
//                $tenderItems = TenderItems::get();
//                $companyUser = ServiceProviderUser::where('fk_i_user_id',$user_id)->first(['fk_i_service_provider_id']);
//                $companyCategories = CompanyCategories::where('fk_i_comapny_id',$companyUser->fk_i_service_provider_id)->get();
//                foreach ($tenderItems as $tenderItem){
//                    $item = ItemsView::where('pk_i_id',$tenderItem->fk_i_item_id)->first();
//                    foreach ($companyCategories as $cc){
//                        $subCC = CategoryView::where('pk_i_id',$cc->fk_i_categories_id)->first();
//                        if($subCC->s_parent_id == 0){
//                            if($item->i_parent_cat_id == $subCC->s_parent_id){
//                                 $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->first();
//                                 array_push($tenders, $tenderForSpecificCompany);
//                            }
//                        }
//                        else{
//                            $subCategory = CategoryView::where('pk_i_id',$subCC->s_parent_id)->first();
//                            if($subCategory->s_parent_id == 0){
//                                if($subCategory->s_parent_id == $item->i_parent_cat_id){
//                                    $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->first();
//                                    array_push($tenders, $tenderForSpecificCompany);
//                                }
//                            }
//                            else{
//                                $subSubCategory = CategoryView::where('pk_i_id',$subCategory->s_parent_id)->first();
//                                if($subSubCategory->s_parent_id == 0){
//                                    if($subSubCategory->pk_i_id == $item->i_parent_cat_id){
//                                        $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->first();
//                                        array_push($tenders, $tenderForSpecificCompany);
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//            return view('ServiceProviderDashboard', $data)->with(['tenders' => $tenders]);
    }

    public function allTenders(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        return view('admin.allTenders');
    }

    public function getAllTenders(){
        $nowDate = Carbon::now()->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();
        DB::statement('call update_tenders_status(?)',array($nowDate));
        $tenders = Tender::with(['status','currency','accetpoffer'])->get();

        return Datatables::of($tenders)->make(true);
    }

    public function allTenderProposalsPricesOffers($tenderID){

        $tender = Tender::where('pk_i_id',$tenderID)->first();

        return view('admin.pricesOffers', compact('tenderID','tender'));

    }

    public function getPricesOffers($id){
        $data = new Collection;
        $tenderProposals = TenderProposal::where('fk_i_tender_id',$id)->with(['company','tenderProposalItems'])->get();
        foreach ($tenderProposals as $tenderProposal){
            $sales = DB::table('t_tender_proposal_items')
                ->join('t_tender_items', 't_tender_items.pk_i_id', '=', 't_tender_proposal_items.fk_i_tender_item_id')
                ->select(DB::raw('sum(t_tender_proposal_items.d_price*t_tender_items.i_quantity) AS total_sales'))
                ->where('t_tender_proposal_items.fk_i_tender_proposal_id', $tenderProposal->pk_i_id)
                ->first();
            $isDiff = TenderProposalItems::where([
                'b_is_different' => 1,
                'fk_i_tender_proposal_id' => $tenderProposal->pk_i_id
            ])->count();
            $data->push([
                'tender_proposal_id' => $tenderProposal->pk_i_id,
                's_name' => $tenderProposal->company->s_name,
                'isDifferent' => (( $isDiff > 0 ) ? trans('lang.yes') : trans('lang.no')),
//                    'total_price' => $tenderProposal->tenderProposalItems->sum('d_price'),
                'total_price' => $sales->total_sales,
                'i_status' => $tenderProposal->status->s_name
            ]);
        }
        $data = $data->sortBy('total_price');
        return Datatables::of($data)->make(true);

    }

    public function getEditTender($id){
        $tender = Tender::where('pk_i_id',$id)->first();
        $categories = CategoryView::where('s_parent_id',0)->get();
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();
        $items = ItemsView::where('b_enabled',1)->get();
        return view('admin.editTender', compact('tender','currencies','items','categories'));
    }

    public function setEditTender(Request $request, $id){
//            date_default_timezone_set(session('timezone'));
//            dd(date_default_timezone_get());
        $nowDate = Carbon::now()->toDateTimeString();
        $tenderItemsIDS = $request->input('ids');

        $statDate = Carbon::parse($request->input('startDate'))->format('Y-m-d H:i');
        $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i');

        $endDateTime = Carbon::parse($endDate)->setTimezone(session('timezone'))->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();

        $status = ( $nowDate > $endDate ) ? 98 : 97;

//            $status = ( $endDate > $statDate ) ? 97 : 98;

        $quantities = $request->input('quantityItem');
        $itemsIDS = $request->input('itemsIds');

        if($request->input('removedItems')){
            foreach ($request->input('removedItems') as $items){
                TenderItems::where('pk_i_id',$items)->delete();
            }
        }

        Tender::where('pk_i_id',$id)->update([
            's_title' => $request->input('tenderTitle'),
            's_description' => $request->input('editor1'),
            's_terms' => $request->input('tenderTerms'),
            'dt_open_date' => $statDate,
            'dt_close_date' => $endDate,
            'fk_i_currency_id' => $request->input('currency'),
            'i_status' => $status,
            'dt_modified_date' => date('Y-m-d H:i:s')
        ]);


//            for($i=1;$i<=sizeof($quantities);$i++){
//                    TenderItems::updateOrCreate(
//                    ['fk_i_tender_id' => $id, 'fk_i_item_id' => $itemsIDS[''.$i.'']],
//                    ['i_quantity' => $quantities[''.$i.'']]
//                );

        foreach ($quantities as $key=>$quantity){
            TenderItems::updateOrCreate(
                ['fk_i_tender_id' => $id, 'fk_i_item_id' => $itemsIDS[$key]],
                ['i_quantity' => $quantities[$key]]);
        }
//                TenderItems::where([
//                    'pk_i_id' => $itemsIDS[''.$i.''],
//                    'fk_i_tender_id' => $id
//                ])->update([
//                    'i_quantity' => $quantities[''.$i.''],
//                    'b_enabled' => 1,
//                    'dt_created_date' => date('Y-m-d H:i:s')
//                ]);

        if ($request->hasFile('tenderFile')) {
            foreach ($request->file('tenderFile') as $file){
                $file_path = time() .'-'. $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/tender', $file_path);
                Attachments::create(array(
                    'fk_i_refe_id' => $id,
                    'i_attach_type' => 1,
                    's_url' => $file_path,
                    's_name' => $file_name,
                    'dt_created_date' => date('Y-m-d H:i:s')

                ));
            }
        }

        return back()->with('msg', trans('lang.success_edit_tender'));

    }

    public function getTenderProposal($id){

        $tenderProposal = TenderProposal::where('pk_i_id',$id)->first();

        return view('ServiceProvider.editBidding', compact('tenderProposal'));

    }

    public function getPricesOfferDetails($id){
        $tenderProposal = TenderProposal::where('pk_i_id',$id)->first();
        return view('admin.pricesOfferDetails',compact('tenderProposal'));
    }

    public function getCategoryIDSSeries($id){
        $series = [];
        $category = $certainCategory = CategoryView::where('pk_i_id',$id)->first();
        if($category->s_parent_id == 0){
            $series[] = $category->pk_i_id;
        }
        while($category->s_parent_id != 0){
            $series[] = $category->pk_i_id;
            $category = CategoryView::where('pk_i_id',$category->s_parent_id)->first();
            if($category->s_parent_id == 0)
                $series[] = $category->pk_i_id;
        }

        return response()->json(['series' => $series]);

    }

    public function getItemsUnderCategory($id){
        $items = ItemsView::where([
            ['i_parent_cat_id','=',$id],
            ['b_enabled','<>',0],
            ['b_enabled','<>',2]
        ])->with(['unit'])->get();
        return response()->json(['items' => $items, 'status' => 1]);
    }

    public function removeItem(Request $request){

        TenderItems::where('pk_i_id',$request['itemID'])->delete();

        return response()->json(['status' => 1]);

    }

    public function adoptionTenderProposal($id){

        TenderProposal::where('pk_i_id',$id)->update([
            'i_status' => 103
        ]);

        $tp = TenderProposal::where('pk_i_id',$id)->first();
        $nowDate = Carbon::now()->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();
        Tender::where('pk_i_id',$tp->fk_i_tender_id)->update([
            'i_accept_offer' => $id,
            'i_status' => 98,
            'dt_close_date' => $nowDate
        ]);

        SuppliersWinners::updateOrCreate(
            ['fk_i_company_id' => $tp->fk_i_company_id, 'i_type' => 1, 'fk_i_service_id' => $tp->fk_i_tender_id],
            ['dt_created_date' => date('Y-m-d H:i:s')]);

        $arabicMessage = "نهنئكم بقبول عرض السعر المقدم لـ مناقصة (".$tp->tender->s_title.")";
        $englishMessage = "Congratulate you accept the offer price offered for tender (".$tp->tender->s_title.")";

        $sms = new SMSController();

        if(count($tp)){
            $notification = Notification::create([
                'fk_i_actor_user_id' => session('user_id'),
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_en' => $englishMessage,
                's_title_ar' => $arabicMessage,
                'i_action' => 0,
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);

            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $tp->companyUser->user->pk_i_id,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);

            if ($tp->companyUser->user->s_default_language == 'ar') {
                $sms->send($tp->company->s_mobile_number, $arabicMessage);
                Mail::to($tp->company->s_email)->send(new AdminEmail($tp->companyUser->user->s_default_language, $tp->company->s_email, $tp->company->s_name, $arabicMessage));
            } else {
                $sms->send($tp->company->s_mobile_number, $englishMessage);
                Mail::to($tp->company->s_email)->send(new AdminEmail($tp->companyUser->user->s_default_language, $tp->company->s_email, $tp->company->s_name, $englishMessage));
            }

        }


        return response()->json(['status' => 1]);

    }

    public function reviewedTenderProposalPO($id){
        $tenderProposal = TenderProposal::where('pk_i_id',$id)->first();
        $tenderProposal->i_status = 102;
        $tenderProposal->save();
        return Redirect::route('reviewedPricesOffer',$tenderProposal->tender->pk_i_id);
    }

    public function showOffers(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        return view('admin.allOffers');
    }

    public function getAllOffers(Request $request){

        $offers = new Collection();
        $offersDB = Offer::where([
            ['i_status','<>',99]
        ])->with(['status','company','currency'])->get();

        foreach ($offersDB as $offer){
            $total = DB::table('t_offer_items')
                ->select(DB::raw('sum(d_price*i_quantity) AS total_price'))
                ->where('fk_i_offer_id', $offer->pk_i_id)
                ->first();
            $offers->push(collect($offer)->prepend($total->total_price, 'total'));
        }
        return Datatables::of($offers)->make(true);

    }

    public function getOfferDetails($id){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $offer = Offer::where('pk_i_id',$id)->first();
        $additionalItemCheck = OfferItems::where([
            'fk_i_offer_id' => $id,
            'fk_i_item_id' => 0
        ])->count();
        return view('admin.offerDetails', compact('offer','additionalItemCheck'));
    }

    public function reviewedOfferPO($id){
        $offer = Offer::where('pk_i_id',$id)->first();
        if($offer->i_status == 103){
            return back()->with(['error_msg' => trans('lang.alreadyAccepted')]);
        }
        $offer->i_status = 102;
        $offer->save();
        return Redirect::route('allOffers');
    }

    public function adoptionOffer($id){

        Offer::where('pk_i_id',$id)->update(['i_status' => 103]);
        $offer = Offer::where('pk_i_id',$id)->first();

        $arabicMessage = "نهنئكم بقبول عرض (".$offer->s_title.")";
        $englishMessage = "Congratulate you accept your offer (".$offer->s_title.")";

        $notification = Notification::create([
            'fk_i_actor_user_id' => session('user_id'),
            'i_target_users_type' => 2,
            'i_title_type' => 2,
            's_title_en' => $englishMessage,
            's_title_ar' => $arabicMessage,
            'i_action' => 0,
            'b_enabled' => 1,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

        NotificationUser::create([
            'fk_i_notification_id' => $notification->pk_i_id,
            'fk_i_user_id' => $offer->userCompany->user->pk_i_id,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

        return response()->json(['status' => 1]);
    }

    public function getOfferStatus($id){
        $status = Offer::where('pk_i_id',$id)->first(['i_status']);
        return response()->json(['status' => $status->i_status]);
    }

    public function newReverseAuction(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $categories = CategoryView::where('s_parent_id',0)->get();
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();
        return view('admin.newReverseAuction', compact('categories','currencies'));
    }

    public function addNewReverseAuction(Request $request){

        $startDateTime = Carbon::parse($request->input('startDate'))->format('Y-m-d H:i');
        $endDateTime = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i');

        $auction = ReverseAuction::insertGetId([
            's_title' => $request->input('reverseAuctionTitle'),
            's_description' => $request->input('editor1'),
            's_terms' => $request->input('reverseAuctionTerms'),
            'dt_open_date' => $startDateTime,
            'dt_close_date' => $endDateTime,
            'fk_i_currency_id' => $request->input('currency'),
            'i_status' => (Carbon::now()->toDateTimeString() > $endDateTime) ? 98 : 97,
            'fk_i_by_user_id' => session('user_id'),
            'dt_created_date' => date('Y-m-d H:i')
        ]);

        ReverseAuctionItem::create([
            'fk_i_auction_id' => $auction,
            'fk_i_item_id' => $request->input('ids'),
            'i_quantity' => $request->input('quantityItem'),
            's_notes' => $request->input('itemNotes'),
            'dt_created_date' => date('Y-m-d H:i')
        ]);

        if($request->hasFile('reverseAuctionFile')){
            foreach ($request->file('reverseAuctionFile') as $file){
                $file_path = time().'-'.$file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/reverse_auction', $file_path);
                Attachments::create([
                    'fk_i_refe_id' => $auction,
                    'i_attach_type' => 5,
                    's_url' => $file_path,
                    's_name' => $file_name,
                    'dt_created_date' => date('Y-m-d H:i')
                ]);
            }
        }

        return redirect()->route('allAuctions')->with(['msg' => trans('lang.added')]);

    }

    public function reverseAuctions(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        return view('admin.reverseAuctions');
    }

    public function getReverseAuctions(){
        $nowDate = Carbon::now()->toDateTimeString();
        DB::statement('call update_auctions_status(?)',array($nowDate));
        $auctions = ReverseAuction::with(['status','accetpoffer'])->get();
        return Datatables::of($auctions)->make(true);
    }

    public function getReverseAuctionDetails($id){
        $categories = CategoryView::where('s_parent_id',0)->get();
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();
        $reverseAuction = ReverseAuction::where('pk_i_id',$id)->first();
        return view('admin.editReverseAuction', compact('reverseAuction','categories','currencies'));
    }

    public function setEditReverseAuction(Request $request, $id){
        $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d H:i');
        $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i');
        $currentDate = Carbon::now()->toDateTimeString();
        ReverseAuction::where('pk_i_id', $id)->update([
            's_title' => $request->input('reverseAuctionTitle'),
            's_description' => $request->input('editor1'),
            's_terms' => $request->input('reverseAuctionTerms'),
            'dt_open_date' => Carbon::parse($request->input('startDate'))->format('Y-m-d H:i'),
            'dt_close_date' => Carbon::parse($request->input('endDate'))->format('Y-m-d H:i'),
            'i_status' => ($currentDate > $endDate) ? 98 : 97,
            'dt_modified_date' => date('Y-m-d H:i:s')
        ]);

        ReverseAuctionItem::where('fk_i_auction_id', $id)->update([
            'i_quantity' => $request->input('quantityItem'),
            's_notes' => $request->input('itemNotes'),
            'dt_modified_date' => date('Y-m-d H:i:s')
        ]);

        if($request->hasFile('reverseAuctionFile')){
            foreach ($request->file('reverseAuctionFile') as $file){
                $file_url = time().'-'.$file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('file/reverse_auction', $file_url);
                Attachments::create([
                    'fk_i_refe_id' => $id,
                    'i_attach_type' => 5,
                    's_url' => $file_url,
                    's_name' => $file_name,
                    'dt_created_date' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return back()->with(['msg' => trans('lang.updated')]);

    }

//        public function checkAttachment(Request $request){
//            $check = Attachments::where([
//                'fk_i_refe_id' => $request['id'],
//                'i_attach_type' => $request['type']
//            ])->count();
//            $check = (count($check)) ? 1 : 0;
//            return response()->json(['status' => $check]);
//        }

    public function allReverseAuctionProposalsPricesOffers($id){
        $nowDate = Carbon::now()->toDateTimeString();
        DB::statement('call update_auction_status(?,?)',array($id,$nowDate));
        $auction = ReverseAuction::where('pk_i_id', $id)->first();
        return view('admin.auctionDetails', compact('auction'));
    }

    public function adoptionReverseAuctionProposal($id){
        $item = ReverseAuctionProposalItem::where('pk_i_id', $id)->first();
        $reverseAuction = ReverseAuction::find($item->fk_i_auction_id);
//            ReverseAuction::where('pk_i_id', $item->fk_i_auction_id)->update([
//                'i_accept_offer' => $item->pk_i_id
//            ]);
        $currentDate = Carbon::now()->toDateTimeString();
        $reverseAuction->i_accept_offer = $item->pk_i_id;
        if($currentDate < $reverseAuction->dt_close_date){
            $reverseAuction->dt_close_date = date('Y-m-d H:i:s');
        }
        $reverseAuction->save();
        $auction = ReverseAuction::where('pk_i_id', $item->fk_i_auction_id)->first();
        $companyName = $item->auctionProposal->company->s_name;
        $proposals = ReverseAuctionProposal::where('fk_i_auction_id', $item->fk_i_auction_id)->get(['fk_i_company_id']);
        $proposalsArray = array();
        foreach ($proposals as $proposal){
            $proposalsArray[] = $proposal->fk_i_company_id;
        }
        $users = ServiceProviderUser::whereIn('fk_i_service_provider_id', $proposalsArray)->get(['fk_i_user_id']);
        $auctionUsers = array();
        foreach ($users as $user){
            $auctionUsers[] = $user->fk_i_user_id;
        }
        $auctionUsers[] = 'adoptAuctionChannel';
        $options = array(
            'encrypted' => true
        );
        $pusher = new \Pusher\Pusher(
            env("PUSHER_KEY"),
            env("PUSHER_SECRET"),
            env("PUSHER_APP_ID"),
            $options
        );
        $data['itemID'] = $id;
        $data['companyName'] = $companyName;
        $data['auctionName'] = $auction->s_title;
        $pusher->trigger($auctionUsers, 'adoptAuction', $data);

        return response()->json(['status' => 1]);
    }

    public function tenderReport(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $tenders = Tender::get(['pk_i_id As id' , 's_title as title']);
        return view('admin.report.tender', compact('tenders'));
    }

    public function getTenderReport($id){
        $tender = Tender::where('pk_i_id', $id)->with(['currency', 'accetpoffer'])->first(['s_title as title', 'dt_open_date as odate', 'dt_close_date as cdate','fk_i_currency_id', 'i_accept_offer']);
        $acceptoffer = "";
        if($tender->accetpoffer != null){
            $acceptoffer = array(
                'companyName' => $tender->accetpoffer->s_name,
                'date' => $tender->dt_accept_offer_date
            );
        }
        $tender = collect($tender)->union(['currencyName' => $tender->currency->s_name, 'acceptOffer' => $acceptoffer]);
        unset($tender['currency']);
        unset($tender['fk_i_currency_id']);
        unset($tender['i_accept_offer']);
        $tenderProposals = TenderProposal::where('fk_i_tender_id', $id)->get();
        $proposals = new Collection();
        foreach ($tenderProposals as $proposal){
            $proposals->push(collect($proposal)->union(['proposalItem' => $proposal->tenderProposalItems, 'companyInfo' => $proposal->companyWithAddress]));
        }
        for ($i=0;$i<sizeof($proposals);$i++){
            $proposals[$i]['id'] = $proposals[$i]['pk_i_id'];
            unset($proposals[$i]['pk_i_id']);
            unset($proposals[$i]['fk_i_tender_id']);
            unset($proposals[$i]['fk_i_company_id']);
            $proposals[$i]['companyInfo']['id'] = $proposals[$i]['companyInfo']['pk_i_id'];
            unset($proposals[$i]['companyInfo']['pk_i_id']);
            unset($proposals[$i]['companyInfo']['s_trade_license_no']);
            unset($proposals[$i]['companyInfo']['city']['pk_i_id']);
            unset($proposals[$i]['companyInfo']['city']['fk_i_parent_id']);
            unset($proposals[$i]['companyInfo']['city']['s_key']);
            unset($proposals[$i]['companyInfo']['city']['i_orginal_id']);
            unset($proposals[$i]['companyInfo']['country']['pk_i_id']);
            unset($proposals[$i]['companyInfo']['country']['fk_i_parent_id']);
            unset($proposals[$i]['companyInfo']['country']['s_key']);
            unset($proposals[$i]['companyInfo']['country']['i_orginal_id']);
            for ($x=0;$x<sizeof($proposals[$i]['proposalItem']);$x++){
                $proposals[$i]['proposalItem'][$x]['id'] = $proposals[$i]['proposalItem'][$x]['pk_i_id'];
                unset($proposals[$i]['proposalItem'][$x]['pk_i_id']);
                unset($proposals[$i]['proposalItem'][$x]['fk_i_tender_proposal_id']);
                unset($proposals[$i]['proposalItem'][$x]['fk_i_tender_item_id']);
                $proposals[$i]['proposalItem'][$x]['tenderItems']['id'] = $proposals[$i]['proposalItem'][$x]['tenderItems']['pk_i_id'];
                unset($proposals[$i]['proposalItem'][$x]['tenderItems']['pk_i_id']);
                unset($proposals[$i]['proposalItem'][$x]['tenderItems']['fk_i_tender_id']);
                unset($proposals[$i]['proposalItem'][$x]['tenderItems']['fk_i_item_id']);
                $proposals[$i]['proposalItem'][$x]['tenderItems']['item']['id'] = $proposals[$i]['proposalItem'][$x]['tenderItems']['item']['pk_i_id'];
                unset($proposals[$i]['proposalItem'][$x]['tenderItems']['item']['pk_i_id']);
                unset($proposals[$i]['proposalItem'][$x]['tenderItems']['item']['fk_i_cat_id']);
            }
        }
//            $tender = DB::table('t_tender')->get(['s_title As title']);
        return response()->json(['status' => 1 , 'proposals' => $proposals, 'tender' => $tender, 'found' => (count($tender) ? 1 : 0)]);
    }

    public function exportTenderReportPDF($id){
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        PDF::setLanguageArray($lg);
        $tender = Tender::where('pk_i_id', $id)->first();
        $proposalsNum = TenderProposal::where('fk_i_tender_id', $id)->count();
//            PDF::SetTitle($tender->s_title);
        PDF::AddPage();
//            PDF::SetFont('aefurat', '', 18);
        PDF::SetFont('dejavusans', '', 12);
        if(app()->getLocale() == "ar")
            PDF::setRTL(true);
        else
            PDF::setRTL(false);

        PDF::SetFontSize(10);
        PDF::writeHTML(view('admin.report.tenderReport', compact('tender','proposalsNum'))->render(), true, 0, true, 0);
//            PDF::Write(0, 'Hello World');
        PDF::Output('tender.pdf');
    }

    public function exportTenderReportExcel($id){

        $fullData = array();
        $tender = Tender::where('pk_i_id',$id)->first();
        $tenderArr = array();
        $fullData[] = array(trans('lang.tenderDetails'));
        $tenderArr[] = trans('lang.tender');
        $tenderArr[] = trans('lang.tenderStartDate');
        $tenderArr[] = trans('lang.tenderEndDate');
        $tenderArr[] = trans('lang.status');
        $tenderArr[] = trans('lang.currency');
        if(app()->getLocale() == "en"){
            $tenderArr[] = "Number Of Tender Proposals";
        }else{
            $tenderArr[] = "عدد المتقدمين للمناقصة";
        }
        $fullData[] = $tenderArr;
        $tenderArr = array();
        $tenderArr[] = $tender->s_title;
        $tenderArr[] = $tender->dt_open_date;
        $tenderArr[] = $tender->dt_close_date;
        $tenderArr[] = $tender->status->s_name;
        $tenderArr[] = $tender->currency->s_name;
        $tenderArr[] = TenderProposal::where('fk_i_tender_id', $id)->count();

        $fullData[] = $tenderArr;

        $tenderArr = array();
        $fullData[] = array(trans('lang.approval'));
        $tenderArr[] = trans('lang.company');
        if ($tender->accetpoffer != null)
            $tenderArr[] = $tender->accetpoffer->comapny->s_name;
        else
            $tenderArr[] = '----';
        $tenderArr[] = trans('lang.date');
        if($tender->acceptOffer != null)
            $tenderArr[] = $tender->dt_accept_offer_date;
        else
            $tenderArr[] = "----";
        $fullData[] = $tenderArr;
        $fullData[] = array("");

        $tenderArr = array();

        foreach ($tender->tenderProposal as $proposal){
            $fullData[] = array(trans('lang.company_account'));
            $tenderArr[] = trans('lang.company_name');
            $tenderArr[] = trans('lang.address');
            $tenderArr[] = trans('lang.city_ar');
            $tenderArr[] = trans('lang.country_ar');
            $tenderArr[] = trans('lang.E-mail');
            $tenderArr[] = trans('lang.phone');
            $tenderArr[] = trans('lang.mobile');
            $tenderArr[] = trans('lang.fax');
            $fullData[] = $tenderArr;
            $tenderArr = array();
            $tenderArr[] = $proposal->company->s_name;
            if(app()->getLocale() == "en")
                $tenderArr[] = $proposal->company->s_address_en;
            else
                $tenderArr[] = $proposal->company->s_address_ar;
            $tenderArr[] = $proposal->company->city->s_name;
            $tenderArr[] = $proposal->company->country->s_name;
            $tenderArr[] = $proposal->company->s_email;
            $tenderArr[] = $proposal->company->s_telephone_number;
            $tenderArr[] = $proposal->company->s_mobile_number;
            $tenderArr[] = $proposal->company->s_fax;
            $fullData[] = $tenderArr;
            $fullData[] = array(trans('lang.items'));
            $tenderArr = array();
            $tenderArr[] = '#';
            $tenderArr[] = trans('lang.item');
            $tenderArr[] = trans('lang.Notes');
            $tenderArr[] = trans('lang.quantity');
            $tenderArr[] = trans('lang.unitCost');
            $tenderArr[] = trans('lang.totalCost');
            $fullData[] = $tenderArr;
            $tenderArr = array();
            $total = 0;
            foreach ($proposal->tenderProposalItems as $key=>$item){
                $total =  $total + $item->tenderItems->i_quantity * $item->d_price;
                $tenderArr[] = $key+1;
                $tenderArr[] = $item->tenderItems->item->s_name;
                $tenderArr[] = $item->s_note;
                $tenderArr[] = $item->tenderItems->i_quantity;
                $tenderArr[] = $item->d_price;
                $tenderArr[] = $item->tenderItems->i_quantity * $item->d_price;
                $fullData[] = $tenderArr;
                $tenderArr = array();
            }

            $fullData[] = array("","","","",trans('lang.total'),$total);

        }

        Excel::create('tender', function($excel) use($fullData) {

            $excel->sheet('Sheetname', function($sheet) use($fullData) {
                $sheet->fromArray($fullData);
            });

        })->export('xls');

    }

    public function supplierReport(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $categories = CategoryView::where('s_parent_id',0)->get(['pk_i_id as id', 's_name as name']);
        return view('admin.report.supplier', compact('categories'));
    }

    public function getSubCategories($id){
        $status = 0;
        $subCategories = CategoryView::where('s_parent_id',$id)->get(['pk_i_id as id','s_name as name']);
        if(count($subCategories)){
            $status = 1;
        }
        return response()->json(['subCategories' => $subCategories, 'status' => $status]);
    }

    public function getSupplierReport($id){

        $categories = CategoryView::where('pk_i_id',$id)->with(['childrenRecursive'])->first()->toArray();
        $catArray = array();
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($categories)) as $key=>$arr){
            if($key == 'pk_i_id')
                $catArray[] = $arr;
        }
        $providers = new Collection();
        $cCatRelation = CompanyCategories::whereIn('fk_i_categories_id',$catArray)->groupby('fk_i_comapny_id')->get();
        foreach ($cCatRelation as $key=>$cc){
            $address = "";
            if(app()->getLocale() == 'en')
                $address = $cc->company->s_address_en;
            else
                $address = $cc->company->s_address_ar;
            $providers->push([
                'name' => $cc->company->s_name,
                'phone' => $cc->company->s_telephone_number,
                'mobile' => $cc->company->s_mobile_number,
                'fax' => $cc->company->s_fax,
                'email' => $cc->company->s_email,
                'address' => $address,
                'city' => $cc->company->city->s_name,
                'country' => $cc->company->country->s_name,
                'salesRepresentativeName' => $cc->company->s_sales_representative_name,
                'salesRepresentativeMobile' => $cc->company->s_sales_representative_mobile,
                'status' => $cc->company->status->s_name,
            ]);
        }

        return response()->json(['providers' => $providers, 'status' => 1, 'found' => count($cCatRelation) ? 1 : 0]);

    }

    public function exportSupplierReportPDF($id){
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        PDF::setLanguageArray($lg);
        $categoryName = CategoryView::where('pk_i_id',$id)->first(['s_name as name']);
        $categories = CategoryView::where('pk_i_id',$id)->with(['childrenRecursive'])->first()->toArray();
        $catArray = array();
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($categories)) as $key=>$arr){
            if($key == 'pk_i_id')
                $catArray[] = $arr;
        }
        $providers = CompanyCategories::whereIn('fk_i_categories_id',$catArray)->groupby('fk_i_comapny_id')->get();
//            PDF::SetTitle($tender->s_title);
        $reportHeader = Lang::get('lang.allSuppliersUnderCategory', ['name' => $categoryName->name]);
        PDF::AddPage();
//            PDF::SetFont('aefurat', '', 18);
        PDF::SetFont('dejavusans', '', 12);
        if(app()->getLocale() == "ar")
            PDF::setRTL(true);
        else
            PDF::setRTL(false);

        PDF::SetFontSize(10);
        PDF::writeHTML(view('admin.report.supplierReport', compact('providers','reportHeader'))->render(), true, 0, true, 0);
//            PDF::Write(0, 'Hello World');
        PDF::Output('supplier.pdf');
    }

    public function exportSupplierReportExcel($id){
        $categoryName = CategoryView::where('pk_i_id',$id)->first(['s_name as name']);
        $categories = CategoryView::where('pk_i_id',$id)->with(['childrenRecursive'])->first()->toArray();
        $catArray = array();
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($categories)) as $key=>$arr){
            if($key == 'pk_i_id')
                $catArray[] = $arr;
        }
        $providers = CompanyCategories::whereIn('fk_i_categories_id',$catArray)->groupby('fk_i_comapny_id')->get();
        $fullData[] = array("","","","",Lang::get('lang.allSuppliersUnderCategory', ['name' => $categoryName->name]));
        $tenderArr = array();
        $fullData[] = array(trans('lang.company_account'));
        $tenderArr[] = trans('lang.company_name');
        $tenderArr[] = trans('lang.address');
        $tenderArr[] = trans('lang.city_ar');
        $tenderArr[] = trans('lang.country_ar');
        $tenderArr[] = trans('lang.E-mail');
        $tenderArr[] = trans('lang.phone');
        $tenderArr[] = trans('lang.mobile');
        $tenderArr[] = trans('lang.fax');
        $tenderArr[] = trans('lang.salesRepresentativeName');
        $tenderArr[] = trans('lang.salesRepresentativeMobile');
        $tenderArr[] = trans('lang.status');
        $fullData[] = $tenderArr;
        foreach ($providers as $provider){
            $tenderArr = array();
            $tenderArr[] = $provider->company->s_name;
            if(app()->getLocale() == "en")
                $tenderArr[] = $provider->company->s_address_en;
            else
                $tenderArr[] = $provider->company->s_address_ar;
            $tenderArr[] = $provider->company->city->s_name;
            $tenderArr[] = $provider->company->country->s_name;
            $tenderArr[] = $provider->company->s_email;
            $tenderArr[] = $provider->company->s_telephone_number;
            $tenderArr[] = $provider->company->s_mobile_number;
            $tenderArr[] = $provider->company->s_fax;
            $tenderArr[] = $provider->company->s_sales_representative_name;
            $tenderArr[] = $provider->company->s_sales_representative_mobile;
            $tenderArr[] = $provider->company->status->s_name;
            $fullData[] = $tenderArr;
        }

        Excel::create('supplier', function($excel) use($fullData) {

            $excel->sheet('Sheetname', function($sheet) use($fullData) {
                $sheet->fromArray($fullData);
            });

        })->export('xls');
    }

    public function offerReport(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        $cats = CategoryView::where('s_parent_id', 0)->get(['pk_i_id as id','s_name as name']);
        return view('admin.report.offer', compact('cats'));
    }

    public function getOfferReport($id){

        $offers = OfferItems::where('fk_i_item_id', $id)->orderBy('d_price')->get();
        $offerItems = array();
        foreach ($offers as $offer){
            $company = array();
            $company['name'] = $offer->offer->company->s_name;
            $company['address'] = $offer->offer->company->s_address;
            $company['city'] = $offer->offer->company->city->s_name;
            $company['country'] = $offer->offer->company->country->s_name;
            $company['email'] = $offer->offer->company->s_email;
            $company['phone'] = $offer->offer->company->s_telephone_number;
            $company['mobile'] = $offer->offer->company->s_mobile_number;
            $company['fax'] = $offer->offer->company->s_fax;
            $company['sales_r_name'] = $offer->offer->company->s_sales_representative_name;
            $company['sales_r_mobile'] = $offer->offer->company->s_sales_representative_mobile;
            $offerItem = array();
            $offerItem['name'] = $offer->item->s_name;
            $offerItem['category'] = $offer->item->category->s_name;
            $offerItem['created_date'] = $offer->dt_created_date;
            $offerItem['quantity'] = $offer->i_quantity;
            $offerItem['price'] = $offer->d_price;
            $offerItem['total'] = (float)$offer->i_quantity * (float)$offer->d_price;
            $offerItem['currency'] = $offer->offer->currency->s_name;
            $offerItems[] = array('company'=>$company, 'offerItem'=>$offerItem);
        }
        $offerItem = ItemsView::where('pk_i_id',$id)->first();
        $item = array();
        $item['name'] = $offerItem->s_name;
        $item['category'] = $offerItem->category->s_name;
        $item['unit'] = $offerItem->unit->s_name;
        $item['type'] = $offerItem->type->s_name;
        $item['description'] = $offerItem->s_description;
        $offersOb = json_decode(json_encode($offerItems));
        $itemOb = json_decode(json_encode($item));

        return response()->json(['offers' => $offersOb, 'item' => $itemOb,'status' => 1, 'found' => (count($offers) ? 1 : 0)]);

    }

    public function exportOfferReportPDF($id){
        $offerItems = OfferItems::where('fk_i_item_id', $id)->get();
        $item = ItemsView::where('pk_i_id', $id)->first();
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        PDF::setLanguageArray($lg);
        PDF::AddPage();
//            PDF::SetFont('aefurat', '', 18);
        PDF::SetFont('dejavusans', '', 12);
        if(app()->getLocale() == "ar")
            PDF::setRTL(true);
        else
            PDF::setRTL(false);

        PDF::SetFontSize(10);
        PDF::writeHTML(view('admin.report.offerReport', compact('offerItems','item'))->render(), true, 0, true, 0);
//            PDF::Write(0, 'Hello World');
        PDF::Output('offer.pdf');
    }

    public function exportOfferReportExcel($id){
        $offerItems = OfferItems::where('fk_i_item_id', $id)->get();
        $item = ItemsView::where('pk_i_id', $id)->first();
        $fullData[] = array(trans('lang.productDetails'));
        $tenderArr = array();
        $tenderArr[] = trans('lang.item');
        $tenderArr[] = trans('lang.category');
        $tenderArr[] = trans('lang.unit');
        $tenderArr[] = trans('lang.type');
        $tenderArr[] = trans('lang.description');
        $fullData[] = $tenderArr;
        $tenderArr = array();
        $tenderArr[] = $item->s_name;
        $tenderArr[] = $item->category->s_name;
        $tenderArr[] = $item->unit->s_name;
        $tenderArr[] = $item->type->s_name;
        $tenderArr[] = $item->s_description;
        $fullData[] = $tenderArr;
        $fullData[] = array("","");
        $tenderArr = array();
        $fullData[] = array(trans('lang.company_account'));
        $tenderArr[] = trans('lang.company_name');
        $tenderArr[] = trans('lang.address');
        $tenderArr[] = trans('lang.city_ar');
        $tenderArr[] = trans('lang.country_ar');
        $tenderArr[] = trans('lang.E-mail');
        $tenderArr[] = trans('lang.phone');
        $tenderArr[] = trans('lang.mobile');
        $tenderArr[] = trans('lang.fax');
        $tenderArr[] = trans('lang.salesRepresentativeName');
        $tenderArr[] = trans('lang.salesRepresentativeMobile');
        $fullData[] = $tenderArr;
        $tenderArr = array();
        foreach ($offerItems as $offer){
            $tenderArr[] = $offer->offer->company->s_name;
            $tenderArr[] = $offer->offer->company->s_address;
            $tenderArr[] = $offer->offer->company->city->s_name;
            $tenderArr[] = $offer->offer->company->country->s_name;
            $tenderArr[] = $offer->offer->company->s_email;
            $tenderArr[] = $offer->offer->company->s_telephone_number;
            $tenderArr[] = $offer->offer->company->s_mobile_number;
            $tenderArr[] = $offer->offer->company->s_fax;
            $tenderArr[] = $offer->offer->company->s_sales_representative_name;
            $tenderArr[] = $offer->offer->company->s_sales_representative_mobile;
            $fullData[] = $tenderArr;
            $tenderArr = array();
            $fullData[] = array(trans('lang.productDetails'));
            $tenderArr[] = trans('lang.item');
            $tenderArr[] = trans('lang.category');
            $tenderArr[] = trans('lang.currency');
            $tenderArr[] = trans('lang.quantity');
            $tenderArr[] = trans('lang.price');
            $tenderArr[] = trans('lang.total');
            $fullData[] = $tenderArr;
            $tenderArr = array();
            $tenderArr[] = $offer->item->s_name;
            $tenderArr[] = $offer->item->category->s_name;
            $tenderArr[] = $offer->offer->currency->s_name;
            $tenderArr[] = $offer->i_quantity;
            $tenderArr[] = $offer->d_price;
            $tenderArr[] = (float)$offer->d_price * (float)$offer->i_quantity;
            $fullData[] = $tenderArr;
            $fullData[] = array("","");
            $fullData[] = array("","");
            $fullData[] = array("","");
            $tenderArr = array();
        }

        Excel::create('offer', function($excel) use($fullData) {

            $excel->sheet('Sheetname', function($sheet) use($fullData) {
                $sheet->fromArray($fullData);
            });

        })->export('xls');
    }

    public function winnerReport(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
        return view('admin.report.winners');
    }

    public function getWinnerReport(Request $request){
        $fromDate = Carbon::parse($request['fromDate'])->format('Y-m-d H:i');
        $toDate = Carbon::parse($request['toDate'])->format('Y-m-d H:i');
        $offers = Offer::whereBetween('dt_created_date', array($fromDate, $toDate))->where('i_status', 103)->get();
        $items = array();
        foreach ($offers as $offer){
            $company = array();
            $company['name'] = $offer->company->s_name;
            $company['address'] = $offer->company->s_address;
            $company['city'] = $offer->company->city->s_name;
            $company['country'] = $offer->company->country->s_name;
            $company['email'] = $offer->company->s_email;
            $company['phone'] = $offer->company->s_telephone_number;
            $company['mobile'] = $offer->company->s_mobile_number;
            $company['fax'] = $offer->company->s_fax;
            $company['sales_r_name'] = $offer->company->s_sales_representative_name;
            $company['sales_r_mobile'] = $offer->company->s_sales_representative_mobile;
            $offerItems = array();
            foreach ($offer->items as $item){
                $offerItem = array();
                $offerItem['name'] = $item->item->s_name;
                $offerItem['category'] = $item->item->category->s_name;
                $offerItem['created_date'] = $item->dt_created_date;
                $offerItem['quantity'] = $item->i_quantity;
                $offerItem['price'] = $item->d_price;
                $offerItem['total'] = (float)$item->i_quantity * (float)$item->d_price;
                $offerItem['currency'] = $item->offer->currency->s_name;
                $offerItems[] = $offerItem;
            }
            $items[] = array('company'=>$company, 'offerItem'=>$offerItems);
        }
        return response()->json(['winners' => $items, 'status' => 1, 'found' => (count($offers) ? 1 : 0)]);
    }

    public function exportWinnerReportPDF($from, $to){
        $fromDate = Carbon::parse($from)->format('Y-m-d H:i');
        $toDate = Carbon::parse($to)->format('Y-m-d H:i');
        $offers = Offer::whereBetween('dt_created_date', array($fromDate, $toDate))->where('i_status', 103)->get();
        $header = Lang::get('lang.winnersOffersOnDateReport', ['from' => $from, 'to' => $to]);
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        PDF::setLanguageArray($lg);
        PDF::AddPage();
//            PDF::SetFont('aefurat', '', 18);
        PDF::SetFont('dejavusans', '', 12);
        if(app()->getLocale() == "ar")
            PDF::setRTL(true);
        else
            PDF::setRTL(false);

        PDF::SetFontSize(10);
        PDF::writeHTML(view('admin.report.winnerReport', compact('offers','header'))->render(), true, 0, true, 0);
//            PDF::Write(0, 'Hello World');
        PDF::Output('winners.pdf');
    }

    public function exportWinnerReportExcel($from, $to){
        $fromDate = Carbon::parse($from)->format('Y-m-d H:i');
        $toDate = Carbon::parse($to)->format('Y-m-d H:i');
        $offers = Offer::whereBetween('dt_created_date', array($fromDate, $toDate))->where('i_status', 103)->get();
        $winnerArr = array();
        $fullData[] = array(trans('lang.company_account'));
        $winnerArr[] = trans('lang.company_name');
        $winnerArr[] = trans('lang.address');
        $winnerArr[] = trans('lang.city_ar');
        $winnerArr[] = trans('lang.country_ar');
        $winnerArr[] = trans('lang.E-mail');
        $winnerArr[] = trans('lang.phone');
        $winnerArr[] = trans('lang.mobile');
        $winnerArr[] = trans('lang.fax');
        $winnerArr[] = trans('lang.salesRepresentativeName');
        $winnerArr[] = trans('lang.salesRepresentativeMobile');
        $fullData[] = $winnerArr;
        $winnerArr = array();
        foreach ($offers as $offer){
            $winnerArr[] = $offer->company->s_name;
            $winnerArr[] = $offer->company->s_address;
            $winnerArr[] = $offer->company->city->s_name;
            $winnerArr[] = $offer->company->country->s_name;
            $winnerArr[] = $offer->company->s_email;
            $winnerArr[] = $offer->company->s_telephone_number;
            $winnerArr[] = $offer->company->s_mobile_number;
            $winnerArr[] = $offer->company->s_fax;
            $winnerArr[] = $offer->company->s_sales_representative_name;
            $winnerArr[] = $offer->company->s_sales_representative_mobile;
            $fullData[] = $winnerArr;
            $winnerArr = array();
            $fullData[] = array(trans('lang.productDetails'));
            $winnerArr[] = trans('lang.item');
            $winnerArr[] = trans('lang.category');
            $winnerArr[] = trans('lang.currency');
            $winnerArr[] = trans('lang.quantity');
            $winnerArr[] = trans('lang.price');
            $winnerArr[] = trans('lang.total');
            $fullData[] = $winnerArr;
            foreach ($offer->items as $item){
                $winnerArr = array();
                $winnerArr[] = $item->item->s_name;
                $winnerArr[] = $item->item->category->s_name;
                $winnerArr[] = $item->offer->currency->s_name;
                $winnerArr[] = $item->i_quantity;
                $winnerArr[] = $item->d_price;
                $winnerArr[] = (float)$item->d_price * (float)$item->i_quantity;
                $fullData[] = $winnerArr;
                $winnerArr = array();
            }
            $fullData[] = array("","");
            $fullData[] = array("","");
            $fullData[] = array("","");
            $winnerArr = array();
        }

        Excel::create('winners', function($excel) use($fullData) {

            $excel->sheet('Sheetname', function($sheet) use($fullData) {
                $sheet->fromArray($fullData);
            });

        })->export('xls');

    }

    public function deleteTender($id){

        $checkProposals = TenderProposal::where('fk_i_tender_id', $id)->count();
        if($checkProposals){
            Tender::where('pk_i_id', $id)->update([
                'i_status' => 99,
                'b_enabled' => 0
            ]);
            return response()->json(['status' => 0]);
        }
        else{
            Tender::where('pk_i_id', $id)->delete();
            return response()->json(['status' => 1]);
        }

    }

//        public function checkAuth(){
//            $user = User::where('pk_i_id', session('user_id'))->first();
//            if(!$user){
//                return redirect()->route('index');
//            }
//            if($user->userRule->s_name_en != 'SuperAdmin'){
//                return redirect('/main');
//            }
//            return redirect()->route('index');
//        }

    public function newUser(){
        $countries = ConstantView::where([
            ['fk_i_parent_id','=',8],
            ['b_enabled','=',1],
        ])->get(['pk_i_id as id' , 's_name as name']);
        $gender = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','USERS_GENDERS']
        ])->get(['pk_i_id as id' , 's_name as name']);
        $permissions = Permissions::where('i_parent_id',0)->get(['pk_i_id as id','s_title_e as etitle','s_title_a as atitle','i_parent_id as pid','dt_created_date as cdate']);
        return view('admin.newUser', compact('permissions', 'countries' , 'gender'));
    }

    public function storeNewUserWithPermissions(Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:t_user,s_email',
            'mobile' => 'required|unique:t_user,s_mobile_number',
        ]);

        $permissions = $request->input('my_multi_select0');

        $user = DB::table('t_user')->insertGetId([
            's_first_name' => $request->input('fname'),
            's_last_name' => $request->input('lname'),
            's_mobile_number' => $request->input('mobile'),
            's_email' => $request->input('email'),
            'fk_i_gender_id' => $request->input('gender'),
            'i_country_id' => !empty($request->input('country')) ? $request->input('country') : null,
            'i_city_id' => !empty($request->input('city')) ? $request->input('city') : null,
            's_address' => !empty($request->input('address')) ? $request->input('address') : null,
            'dt_birth_date' => !empty($request->input('bdate')) ? $request->input('bdate') : null,
            'fk_i_role_id' => 111,
            's_password' => md5($request->input('password')),
            'dt_created_date' => date('Y-m-d h:i:s'),
            'dt_modified_date' => date('Y-m-d h:i:s'),
            'b_enabled' => 1
        ]);

        UserVerification::create([
            'fk_i_user_id' => $user,
            's_passcode' => str_random(6),
            'dt_expiration_date' => date('Y-m-d h:i:s'),
            'dt_confirmation_date' => date('Y-m-d h:i:s'),
            'dt_created_date' => date('Y-m-d h:i:s'),
            'b_enabled' => 1
        ]);

        foreach ($permissions as $permission){
            UserPermissions::create([
                'fk_i_user_id' => $user,
                'fk_i_permission_id' => $permission,
                'dt_created_date' => date('Y-m-d h:i:s')
            ]);
        }

        return back()->with('msg', trans('lang.added'));

    }

    public function getCitiesToNewUser($id){
        $cities = ConstantView::where([
            'fk_i_parent_id' => $id,
            'b_enabled' => 1
        ])->get(['pk_i_id as id', 's_name as name']);

        return response()->json(['status' => 1, 'cities' => $cities, 'found' => count($cities) ? 1 : 0]);
    }

    public function customAdmins(){
        return view('admin.showAdmins');
    }

    public function getCustomAdmins(){
        $admins = User::where('fk_i_role_id',111)->get(['pk_i_id as id', 's_first_name as fname', 's_last_name as lname', 's_email as email' ,'b_enabled as enabled']);
        return Datatables::of($admins)->make(true);
    }

    public function changeCustomAdminStatus(Request $request,$id){
        User::where('pk_i_id',$id)->update(['b_enabled' => $request['status']]);
        return response()->json(['status' => 1]);
    }

    public function getCustomAdmin($id){
        $data['user'] = User::where('pk_i_id',$id)->first(['s_first_name as fname','s_last_name as lname','s_mobile_number as mobile','s_email as email','i_country_id as country','i_city_id as city','dt_birth_date as bdate','fk_i_gender_id as gender','pk_i_id as id','s_address as address']);
        $user = User::where('pk_i_id',$id)->first();
        $countries = ConstantView::where([
            ['fk_i_parent_id','=',8]
        ])->where(function ($query) use ($data){
            $query->where('b_enabled', 1)->orWhere('pk_i_id', $data['user']->country);
        })->get(['pk_i_id as id' , 's_name as name']);
        $gender = ConstantView::where([
            ['fk_i_parent_id','<>',0],
            ['b_enabled','=',1],
            ['s_key','=','USERS_GENDERS']
        ])->get(['pk_i_id as id' , 's_name as name']);
        $userPermissions = $user->permissions;
        $userPermission = array();
        foreach ($userPermissions as $per){
            $userPermission[] = $per->fk_i_permission_id;
        }
        $permissions = Permissions::where('i_parent_id',0)->get(['pk_i_id as id','s_title_e as etitle','s_title_a as atitle','i_parent_id as pid','dt_created_date as cdate']);
        return view('admin.editCustomUserAdmin',$data)->with(['userPermissions' => $userPermission,'countries' => $countries,'permissions' => $permissions,'gender' => $gender]);
    }

    public function updateCustomAdminInformation(Request $request,$id){
//            $this->validate($request,[
//                'email' => 'required|email|unique:t_user,s_email',
//                'mobile' => 'required|unique:t_user,s_mobile_number',
//            ]);

        $permissions = $request->input('my_multi_select0');

//        User::where('pk_i_id',$id)->update([
//            's_first_name' => $request->input('fname'),
//            's_last_name' => $request->input('lname'),
//            's_mobile_number' => $request->input('mobile'),
//            's_email' => $request->input('email'),
//            'fk_i_gender_id' => $request->input('gender'),
//            'dt_birth_date' => !empty($request->input('bdate')) ? $request->input('bdate') : null,
//            'fk_i_role_id' => 111,
//            'dt_modified_date' => date('Y-m-d h:i:s'),
//            'b_enabled' => 1
//        ]);
//
//        if($request->input('password')){
//            User::where('pk_i_id',$id)->update([
//                's_password' => md5($request->input('password'))
//            ]);
//        }

        foreach ($permissions as $permission){
            UserPermissions::where('fk_i_user_id',$id)->whereNotIn('fk_i_permission_id',$permissions)->delete();
            UserPermissions::updateOrCreate(
                ['fk_i_user_id' => $id, 'fk_i_permission_id' => $permission],
                ['dt_created_date' => date('Y-m-d h:i:s')]
            );
        }
        return back()->with('msg', trans('lang.updated'));
    }


}
