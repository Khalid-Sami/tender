<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryView;
use App\ConversationUser;
use App\Messages;
use App\Notification;
use App\RequestAttachment;
use App\RequestQuestionAnswer;
use App\RequestQuotation;
use App\Service;
use App\ServiceCategory;
use App\Request as RequestClass;
use App\ServiceQuestion;
use App\ServiceQuestionOptions;
use App\ServiceQuestionView;
use App\ServiceView;
use App\SPCities;
use App\SPQuestionAnswer;
use App\SPServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Validator;
use App\ConstantView;
use App\ProfileMeta;
use App\ServiceProvider;
use App\ServiceProviderUser;
use App\SPWorkingHours;
use App\User;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    //
    public function __construct()
    {
//        $this->middleware(['locale']);
        $this->middleware(['is.login', 'locale']);

    }


    public function messageIndex()
    {
        $user_id1 = session('user_id');
        $count_m = 0;
        $u1 = User::where("pk_i_id", $user_id1)->first();
        $users = User::whereNotIn("pk_i_id", [$user_id1])->get();
        $con_id = 0;
        $cc1 = ConversationUser::where("user_id", $user_id1)
            ->select('*', 'conversation_user.updated_at as updated_at1')
            ->orderBy("conversation_user.updated_at", "desc")
            ->get();
        $count_c = count($cc1);
        return view('Chat/index', compact("cc1", "count_c", 'user_id1', 'users', 'con_id', 'u1', 'count_m'));
    }
    public function messageIndex1($providerId)
    {
        $userId2  = ServiceProviderUser::where(['fk_i_service_provider_id'=>$providerId,'fk_i_role_id'=>6])->first(['fk_i_user_id'])->fk_i_user_id;
        $user_id1 = session('user_id');
        $count_m = 0;
        $u1 = User::where("pk_i_id", $user_id1)->first();
        $users = User::whereNotIn("pk_i_id", [$user_id1])->get();
        $con_id = 0;
        $cc1 = ConversationUser::where("user_id", $user_id1)
            ->select('*', 'conversation_user.updated_at as updated_at1')
            ->orderBy("conversation_user.updated_at", "desc")
            ->get();
        $count_c = count($cc1);
        return view('Chat/specificChat', compact("cc1", "count_c", 'user_id1', 'users', 'con_id', 'u1', 'count_m','userId2'));
    }

    public function getMessage(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $user_id2 = $post_data['user_id'];
            $con_id = $post_data['con_id'];
            $json['count_m'] = Messages::where([
                "conversation_id" => $con_id,
                "user_id" => $user_id2
            ])->count();
            $json['messages'] = Messages::where("conversation_id", $con_id)
                ->join('t_user', 't_user.pk_i_id', '=', 'messages.user_id')->get();
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }
        echo json_encode($json);
    }

    public function getConversations(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $user_id1 = $post_data['user_id'];
            $user_id2 = $post_data['user_id2'];
            $cc1 = ConversationUser::where("user_id", $user_id1)
                ->select('*', 'conversation_user.updated_at as updated_at1')
                ->orderBy("conversation_user.updated_at", "desc")
                ->get();
            // $view = view('Chat/index', compact("cc1"));
            $html = View::make('Chat/conversation', ['cc1' => $cc1, 'user_id1' => $user_id1, 'user_id2' => $user_id2])->render();
            //$contents = (String)$view;
            //$v=view('Chat/index', compact("cc1"))->render();
            $json['view1'] = $html;
            $json['count_c'] = count($cc1);
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }

        echo json_encode($json);

    }

    public function sendMessage(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $user_id1 = $post_data['user_id1'];
            $user_id2 = $post_data['user_id2'];
            $con_id = $post_data['con_id'];
            if ($con_id == 0) {
                $chat = App::make('chat');
                $conversation = $chat->createConversation([$user_id1, $user_id2]);
                $con_id = $conversation->id;
            }
            ConversationUser::where("conversation_id", $con_id)->update([
                "updated_at" => date("Y-m-d H:i:s")
            ]);
            $text = $post_data['text'];
            $chat = App::make('chat');
            $chat->send($con_id, $text, $user_id1);
            $json['con_id'] = $con_id;
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }

        echo json_encode($json);

    }

    public function checkCountM(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $user_id = $post_data['user_id'];
            $con_id = $post_data['con_id'];
            $count = $post_data['count'];
            $max_id = $post_data['max_id'];
            $count_m = Messages::where([
                "conversation_id" => $con_id,
                "user_id" => $user_id
            ])->where("id", ">", $max_id)->count();
            $json['messages'] = array();
            $json['count'] = $count_m;
            if ($count != $count_m) {
                $json['messages'] = Messages::where([
                    "conversation_id" => $con_id,
                    "user_id" => $user_id,
                ])->where("id", ">", $max_id)->join('t_user', 't_user.pk_i_id', '=', 'messages.user_id')->get();
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }
        echo json_encode($json);

    }

    public function getPreviousMessages(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $con_id = $post_data['con_id'];
            $user_id = $post_data['user_id'];
            $cc1 = ConversationUser::where("conversation_id", $con_id)
                ->join('t_user', 't_user.pk_i_id', '=', 'conversation_user.user_id')->get();
            if ($user_id == $cc1[0]->user_id) {
                $json['user_id'] = $cc1[1]->user_id;
            } else {
                $json['user_id'] = $cc1[0]->user_id;
            }
            $count_m = Messages::where([
                "conversation_id" => $con_id,
            ])->count();
            $json['messages'] = array();
            $json['messages'] = Messages::where([
                "conversation_id" => $con_id,
            ])->join('t_user', 't_user.pk_i_id', '=', 'messages.user_id')->get();
            $json['con_id'] = $con_id;
            $json['count'] = $count_m;
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }
        echo json_encode($json);

    }

    public function search(Request $request)
    {
        $user_id = session('user_id');
        $user_role = User::where(['pk_i_id' => session('user_id')])->first(['fk_i_role_id'])->fk_i_role_id;
        switch ($user_role) {
            case '5':
                $users = User::select("pk_i_id as user_id", DB::raw('CONCAT(s_first_name," ",s_last_name) AS name'))->where('pk_i_id', '!=',$user_id)->where('fk_i_role_id', '!=', 5)->get();
                break;
            case '6':
//                $serviceProviderId = ServiceProviderUser::where(['fk_i_role_id' => 15, 'fk_i_user_id' => $user_id])->first(['fk_i_service_provider_id'])->fk_i_service_provider_id;
                $users = User::select("pk_i_id as user_id", DB::raw('CONCAT(s_first_name," ",s_last_name) AS name'))->where('pk_i_id', '!=',$user_id)->get();

//                $users = DB::table('t_user as tu')->select("pk_i_id as user_id", DB::raw('CONCAT(s_first_name," ",s_last_name) AS name'))
//                    ->leftJoin('t_sp_user as tspu', 'tu.pk_i_id', '=', 'tspu.fk_i_user_id')
//                    ->where('tspu.fk_i_service_provider_id', $serviceProviderId)
//                    ->where('tu.fk_i_role_id', '!=', 16)
//                    ->where('tu.pk_i_id', '!=', $user_id)
//                    ->get();
                break;
            case '7':
//                $serviceProviderId = ServiceProviderUser::where(['fk_i_role_id' => 7, 'fk_i_user_id' => $user_id])->pluck('fk_i_service_provider_id');
                $users = User::select("pk_i_id as user_id", DB::raw('CONCAT(s_first_name," ",s_last_name) AS name'))->where('pk_i_id', '!=',$user_id)->where('fk_i_role_id', '!=', 5)->get();

//                $users = DB::table('t_user as tu')->select("pk_i_id as user_id", DB::raw('CONCAT(s_first_name," ",s_last_name) AS name'))
//                    ->join('t_sp_user as tspu', 'tu.pk_i_id', '=', 'tspu.fk_i_user_id')
//                    ->whereIn('tspu.fk_i_service_provider_id', [$serviceProviderId])
//                    ->where('tu.fk_i_role_id', '!=', 5)
//                    ->where('tu.fk_i_role_id', '!=', 7)
//                    ->whereNotIn('tu.pk_i_id', [$user_id])
//                    ->get();
                break;

        }
        header('Content-Type: application/json');
        //$text = $get_data['query'];
        //        ->where('s_first_name', $text)->orWhere('s_first_name', 'like', '%' . $text . '%')


        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public
    function getPreviousMessagesFromSelect(Request $request)
    {
        $post_data = $request->input();
        header('Content-Type: application/json');
        if (isset($post_data['id'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم احضار المعلومات';
            $user_id1 = $post_data['user_id1'];
            $json['user_id'] = $user_id1;

            $user_id2 = $post_data['user_id2'];
            $json['user_id2'] = $user_id2;
            $cc1 = ConversationUser::where("user_id", $user_id1)
                ->join('t_user', 't_user.pk_i_id', '=', 'conversation_user.user_id')->get();
            $flag = true;

            if (count($cc1) > 0) {
                foreach ($cc1 as $c) {
                    $cc2 = ConversationUser::where("conversation_id", $c->conversation_id)
                        ->join('t_user', 't_user.pk_i_id', '=', 'conversation_user.user_id')->get();
                    foreach ($cc2 as $c2) {
                        if ($c2->user_id == $user_id2) {
                            $flag = false;
                            $json['user_id2'] = $user_id2;
                            $count_m = Messages::where([
                                "conversation_id" => $c->conversation_id,
                            ])->count();
                            $json['messages'] = array();
                            $json['messages'] = Messages::where([
                                "conversation_id" => $c->conversation_id,
                            ])->join('t_user', 't_user.pk_i_id', '=', 'messages.user_id')->get();
                            $json['con_id'] = $c->conversation_id;
                            $json['count'] = $count_m;
                        }
                    }
                }
                if ($flag) {
                    $json['con_id'] = 0;
                    $json['count'] = 0;
                }
            } else {

                $json['user_id2'] = $user_id2;
                $json['count'] = 0;
                $json['con_id'] = 0;
            }


        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في ارسال البيانات';
        }
        echo json_encode($json);

    }


    ///////////////////////////////////////////////
    public function serviceProviderProfile()
    {
        $data['user'] = User::where('pk_i_id', session('user_id'))->first();
        $data['provider_id'] = ServiceProviderUser::where(['fk_i_user_id' => $data['user']->pk_i_id, 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id'])->fk_i_service_provider_id;
        $data['service_provider'] = ServiceProvider::where('pk_i_id', $data['provider_id'])->first();
        $data['working'] = SPWorkingHours::where('fk_i_service_provider_id', $data['provider_id'])->get();
        $data['profileMeta'] = ProfileMeta::where(['fk_i_ref_id' => $data['provider_id']])->get()->keyBy('s_key');
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->get(['pk_i_id', 's_name']);
        return view('user.provider_admin.profile', $data);

    }

    public function updateSPInformation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            's_name_ar' => 'required',
            's_name_en' => 'required',
            's_company_name' => 'required',
            's_trade_license_no' => 'required|numeric',
            's_telephone_number' => 'required|numeric',
            's_mobile_number' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with(['error_msg' => trans('lang.error_msg'), 'tab1_state' => 'active'])
                ->withInput();
        }

        ServiceProvider::where('pk_i_id', $id)->update([
            's_name_ar' => $request->input('s_name_ar'),
            's_name_en' => $request->input('s_name_en'),
            's_company_name' => $request->input('s_company_name'),
            's_telephone_number' => $request->input('s_telephone_number'),
            's_mobile_number' => $request->input('s_mobile_number'),
            's_trade_license_no' => $request->input('s_trade_license_no'),
            's_address_ar' => !empty($request->input('s_address_ar')) ? $request->input('s_address_ar') : null,
            's_address_en' => !empty($request->input('s_address_en')) ? $request->input('s_address_en') : null,
        ]);
        if ($file = $request->file('service_provider_image')) {
            $image_name = time() . $file->getClientOriginalName();
            $file->move('images/service_provider_images', $image_name);
            ServiceProvider::where('pk_i_id', $id)->update(['s_image' => $image_name]);
        }

        return back()->with([
            'msg' => trans('lang.updated'),
            'tab1_state' => 'active'
        ]);

    }

    public function updateSPCities(Request $request, $id)
    {
        $cities = $request->input('cities');
        SPCities::where('fk_i_service_provider_id', $id)->delete();
        foreach ($cities as $city) {
            SPCities::create([
                'fk_i_service_provider_id' => $id,
                'fk_i_city_id' => $city,
                'dt_created_date' => date('Y-m-d H:i:s'),
            ]);
        }
        return back()->with([
            'msg' => trans('lang.updated'),
            'tab2_state' => 'active'
        ]);

    }

    public function updateSPLocation(Request $request, $id)
    {
        session()->flash('tab3_state', 'active');
        $this->validate($request, [
            'lng' => 'required',
            'lat' => 'required'
        ]);
        ServiceProvider::where('pk_i_id', $id)->update([
            'd_longitude' => $request->input('lng'),
            'd_latitude' => $request->input('lat')
        ]);
        return back()->with([
            'msg' => trans('lang.updated'),
            'tab3_state' => 'active'
        ]);

    }

    public function storeTimeOfWork(Request $request, $id)
    {
        $provider = SPWorkingHours::where('fk_i_service_provider_id', $id)->get();

        if (!$provider->isEmpty()) {
            for ($i = 1; $i <= 7; $i++) {
                $from = $request->input('from' . $i);
                $to = $request->input('to' . $i);
                SPWorkingHours::where(['i_day' => $i, 'fk_i_service_provider_id' => $id])->update([
                    'fk_i_service_provider_id' => $id,
                    't_from' => isset($from) ? $from : '',
                    't_to' => isset($to) ? $to : '',
                    'i_day' => $i,
                ]);
            }
        } else {
            for ($i = 1; $i <= 7; $i++) {
                $from = $request->input('from' . $i);
                $to = $request->input('to' . $i);
                SPWorkingHours::create([
                    'fk_i_service_provider_id' => $id,
                    't_from' => isset($from) ? $from : '',
                    't_to' => isset($to) ? $to : '',
                    'i_day' => $i,
                ]);
            }
        }
        return back()->with([
            'msg' => trans('lang.updated'),
            'tab4_state' => 'active'
        ]);

    }

    public function updateSPAdditionalInfo(Request $request, $id)
    {
        $about_service_provider = $request->input('about_service_provider');
        $foundation_year = $request->input('foundation_year');
        $qualifications = $request->input('qualifications');
        $certifications = $request->input('certifications');
        $accredited_by = $request->input('accredited_by');
        $check = ProfileMeta::where(['fk_i_ref_id' => $id, 'i_type' => 1])->get();
        if ($check->isEmpty()) {
            ProfileMeta::create(['i_type' => 1, 's_key' => 'AboutServiceProvider', 'fk_i_ref_id' => $id, 's_value' => $about_service_provider, 'dt_created_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::create(['i_type' => 1, 's_key' => 'FoundationYear', 'fk_i_ref_id' => $id, 's_value' => $foundation_year, 'dt_created_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::create(['i_type' => 1, 's_key' => 'Qualifications', 'fk_i_ref_id' => $id, 's_value' => $qualifications, 'dt_created_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::create(['i_type' => 1, 's_key' => 'Certifications', 'fk_i_ref_id' => $id, 's_value' => $certifications, 'dt_created_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::create(['i_type' => 1, 's_key' => 'AccreditedBy', 'fk_i_ref_id' => $id, 's_value' => $accredited_by, 'dt_created_date' => date('Y-m-d H:i:s')]);
        } else {
            ProfileMeta::where(['fk_i_ref_id' => $id, 's_key' => 'AboutServiceProvider', 'i_type' => 1])->update(['s_value' => $about_service_provider, 'dt_modified_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::where(['fk_i_ref_id' => $id, 's_key' => 'FoundationYear', 'i_type' => 1])->update(['s_value' => $foundation_year, 'dt_modified_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::where(['fk_i_ref_id' => $id, 's_key' => 'Qualifications', 'i_type' => 1])->update(['s_value' => $qualifications, 'dt_modified_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::where(['fk_i_ref_id' => $id, 's_key' => 'Certifications', 'i_type' => 1])->update(['s_value' => $certifications, 'dt_modified_date' => date('Y-m-d H:i:s')]);
            ProfileMeta::where(['fk_i_ref_id' => $id, 's_key' => 'AccreditedBy', 'i_type' => 1])->update(['s_value' => $accredited_by, 'dt_modified_date' => date('Y-m-d H:i:s')]);
        }

        return back()->with([
            'msg' => trans('lang.updated'),
            'tab5_state' => 'active'
        ]);

    }

    public function showModalQuotations($quotationId)
    {
        $data['requestsQuotation'] = RequestQuotation::where(['pk_i_id' => $quotationId])->first();
        $data['requestId'] = $data['requestsQuotation']->fk_i_request_id;
        $data['serviceProviderId'] = $data['requestsQuotation']->fk_i_service_provider_id;
        return view('user.quotation.iframe', $data)->render();
    }

    public function showQuotations()
    {

        return view('user.quotation.showAll');
    }

    public function showAllQuotations($requestId)
    {
        $data['requests'] = RequestClass::where('pk_i_id', $requestId)->first();
        if(empty($data['requests'])){
            return back()->with('error_msg',trans('lang.url_error'));
        }

        $data['attachment'] = RequestAttachment::where('fk_i_request_id', $requestId)->get();
        $data['requestQuestionAnswer'] = RequestQuestionAnswer::where('fk_i_request_id', $requestId)->get();
        $data['requestId'] = $requestId;
        $data['requestQuotation'] = RequestQuotation::where('fk_i_request_id', $requestId)->get();
        return view('user.quotation.showAllQuotations', $data);
    }

    public function showServices(Request $request)
    {
        $service_provider_id = ServiceProviderUser::where(['fk_i_user_id' => session('user_id'), 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id'])->fk_i_service_provider_id;
        if ($request->ajax()) {
            $action = $request->input('action');
            $category_id = $request->input('category_id');
            if ($action == 'getServices') {
                $data['services'] = ServiceCategory::where('fk_i_category_id', $category_id)->get();
                $view = view('user.provider_admin.ajax.service', $data)->render();
                return response()->json(['status' => 1, 'view' => $view]);
            }
            if ($action == 'getInstant') {
                $service_id = $request->input('service_id');
                if (!empty($service_id)) {
                    $is_instant = Service::where('pk_i_id', $service_id)->first(['b_is_instant'])->b_is_instant;
                    $price = SPServices::where(['fk_i_service_provider_id' => $service_provider_id, 'fk_i_service_id' => $service_id])->first(['d_price'])->d_price;
                    $questions = ServiceQuestionView::where('fk_i_service_id', $service_id)->get();
                    $question_view = view('user.provider_admin.ajax.questions', compact('questions', 'service_id', 'service_provider_id'))->render();
                    return response()->json(['status' => 1, 'is_instant' => $is_instant, 'question_view' => $question_view, 'price' => $price]);
                }
                return response()->json(['status' => 1, 'is_instant' => '', 'question_view' => '', 'price' => '']);
            }

        }

        $data['category'] = CategoryView::pluck('s_category', 'pk_i_id')->prepend(trans('lang.choose_option'), '');
        return view('user.provider_admin.services.show', $data);
    }

    public function addServices(Request $request)
    {
        $service_provider_id = ServiceProviderUser::where(['fk_i_user_id' => session('user_id'), 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id'])->fk_i_service_provider_id;
        $questionsCheckbox = $request->input('questionsCheckbox');
        $service_id = $request->input('service');
        $category_id = $request->input('category');
        $price = $request->input('price');
        $is_instant = $request->input('urgent');
        $check = SPServices::where(['fk_i_service_provider_id' => $service_provider_id, 'fk_i_service_id' => $service_id])->count();
        if ($check == 0) {
            SPServices::create([
                'fk_i_service_provider_id' => $service_provider_id,
                'fk_i_service_id' => $service_id,
                'b_is_instant' => $is_instant,
                'd_price' => $price,
                'i_currency' => 1,
                'b_approved' => 0,
                'dt_created_date' => date('Y-m-d H:i:s'),
            ]);
        } else {
            SPServices::where(['fk_i_service_provider_id' => $service_provider_id, 'fk_i_service_id' => $service_id])->update([
                'b_is_instant' => $is_instant,
                'd_price' => $price,
                'i_currency' => 1,
                'b_approved' => 0,
                'dt_modified_date' => date('Y-m-d H:i:s'),
            ]);
        }

        foreach ($questionsCheckbox as $i => $question) {
            foreach ($request->input("optionsCheckbox$i") as $option) {
                $check = SPQuestionAnswer::where([
                    'fk_i_service_provider_id' => $service_provider_id,
                    'fk_i_service_id' => $service_id,
                    'fk_i_question_id' => $question,
                    'fk_i_option_id' => $option,
                ])->count();
                if ($check == 0) {
                    SPQuestionAnswer::create([
                        'fk_i_service_provider_id' => $service_provider_id,
                        'fk_i_service_id' => $service_id,
                        'fk_i_question_id' => $question,
                        'fk_i_option_id' => $option,
                        'b_enabled' => 1,
                        'dt_created_date' => date('Y-m-d H:i:s'),

                    ]);
                } else {
                    SPQuestionAnswer::where([
                        'fk_i_service_provider_id' => $service_provider_id,
                        'fk_i_service_id' => $service_id,
                        'fk_i_question_id' => $question,
                        'fk_i_option_id' => $option,
                    ])->update(['b_enabled' => 1, 'dt_modified_date' => date('Y-m-d H:i:s')]);
                }
            }
        }
        return response()->json();
    }

    public function showRequests(Request $request)
    {

        return view('user.requests.showAll');
    }


}
