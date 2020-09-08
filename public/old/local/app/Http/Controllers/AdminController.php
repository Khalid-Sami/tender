<?php

namespace App\Http\Controllers;

use App\Category;
use App\Constant;
use App\ConstantView;
use App\Http\helpers;
use App\Invoice;
use App\ProfileMeta;
use App\ServiceCategory;
use App\ServiceProviderUser;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;
use App\Setting;
use App\SettingView;
use App\SPWorkingHours;
use App\SubscriptionPackage;
use App\SubscriptionPackageView;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ServiceProvider;
use Yajra\Datatables\Facades\Datatables;

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

    public function systemSettings()
    {
        $settings = SettingView::all()->keyBy('s_key');
        return view('admin.setting', compact('settings'));
    }


    public function sendNotifications()
    {
        $clinics = [];
        $clinics_User = [];

        return view('admin.notifications.show', compact('clinics', 'clinics_User'));
    }

    public function getAllNotifications(Request $request)
    {

        $last_date = $request->input('last_date');
        $user_id = session('user_id');
        $user = User::where('pk_i_id', $user_id)->first();
        $seen_date = $user->dt_notification_seen_date;
        DB::statement("SET @i_user_id ='$user_id'");
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
        $sendTo = $request->input('check');
        $userIds = $request->input('my_multi_select');
        $arabicMessage = $request->input('messageArabic');
        $englishMessage = $request->input('messageEnglish');

        if (!empty($serviceType[0])) {
            switch ($serviceType[0]) {
                case 'email':
                    foreach ($sendTo as $s) {
                        foreach ($userIds as $id) {
                            $user = User::where(['pk_i_id' => $id])->first(['s_default_language', 's_email', 's_first_name', 's_last_name']);
                            $name = $user->s_first_name . ' ' . $user->s_last_name;
                            if ($user->s_default_language == 'ar') {

                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $arabicMessage));
                            } else {
                                Mail::to($user->s_email)->send(new AdminEmail($user->s_default_language, $user->s_email, $name, $englishMessage));
                            }

                        }
                    }
                    break;

                case 'sms':
                    foreach ($sendTo as $s) {
                        foreach ($userIds as $id) {
                            $sms = new SMSController();
                            $user = User::where(['pk_i_id' => $id])->first(['s_default_language', 's_mobile_number']);
                            if ($user->s_default_language == 'ar') {
                                $sms->send($user->s_mobile_number, $arabicMessage);
                            } else {
                                $sms->send($user->s_mobile_number, $englishMessage);

                            }

                        }
                    }
                    break;

                case 'website':
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
                        $this->send_notification('http://clinics.newline.ps/api/v1/pns/push_notification/', $notification_data);
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
                        $this->send_notification('http://clinics.newline.ps/api/v1/pns/push_notification/', $notification_data);
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

        return response()->json(['status'=>1]);
    }

    public function showConstant()
    {
        return view('admin.country');
    }

    public function showCity($country_id)
    {
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

    public function updateConstant(Request $request)
    {
        $this->validate($request, [
            'name_ar' => 'required',
            'name_en' => 'required',
            'c_status' => 'required'
        ]);
        $pk_i_id = $request->input('pk_i_id');
        $check = Constant::where('pk_i_id', '!=', $pk_i_id)->where('s_name_en', $request->input('name_en'))->orWhere('s_name_ar', $request->input('name_ar'))->count();
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

    public function serviceProvider()
    {
        $data['serviceProvider'] = ServiceProvider::where('dt_deleted_date', '!=', null)->get();
        $data['status'] = ConstantView::getIdNameData('SERVICE_PROVIDER_STATUS')->prepend(trans('lang.choose_option'), "");
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->pluck('s_name', 'pk_i_id');
        $data['subscription_package'] = SubscriptionPackageView::pluck('s_name', 'pk_i_id')->prepend(trans('lang.choose_option'), "");
        return view('admin.service_provider.show', $data);
    }

    public function showUsers($id)
    {
        return view('admin.service_provider.users.show', compact('id'));
    }

    public function showAllUsers(Request $request)
    {
        $status = ConstantView::getIdNameData('STATUS')->prepend(trans('lang.show_all'), '');;
        $user_role = ConstantView::getIdNameData('USERS_ROLES')->forget(5)->prepend(trans('lang.show_all'), '');

        return view('admin.users.show', compact('status', 'user_role'));
    }

    /**
     * @param $id
     */

    public function serviceProviderProfile($id)
    {
        $data['user'] = User::where('pk_i_id', session('user_id'))->first();
        $data['service_provider'] = ServiceProvider::where('pk_i_id', $id)->first();
        $data['working'] = SPWorkingHours::where('fk_i_service_provider_id', $id)->get();
        $data['profileMeta'] = ProfileMeta::where(['fk_i_ref_id' => $id])->get()->keyBy('s_key');
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->get(['pk_i_id', 's_name']);
        return view('user.provider_admin.profile', $data);

    }


    public function changeSubscriptionPackage(Request $request)
    {
        $provider_id = $request->input('pk_i_id');
        $subscription_id = $request->input('subscription');
        $user_id = ServiceProviderUser::where(['fk_i_service_provider_id' => $provider_id, 'fk_i_role_id' => 6])->first()->fk_i_user_id;

        $last = Invoice::where(['fk_i_service_provider_id' => $provider_id])->get()->last();
        if (isset($last) && !empty($last)) {
            Invoice::where(['pk_i_id' => $last->pk_i_id])->update(['fk_i_subscription_package_id' => $subscription_id]);
        } else {

            $d = SubscriptionPackage::where('pk_i_id', $subscription_id)->first(['i_duration']);
            $expire = date('Y-m-d h:i:s', strtotime("+$d->i_duration day"));
            Invoice::create([
                'fk_i_user_id' => $user_id,
                'fk_i_service_provider_id' => $provider_id,
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
            $temp['serviceNumber'] = ServiceCategory::where(['fk_i_category_id' => $object->pk_i_id ,'dt_deleted_date' => null ])->get()->count();
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
}
