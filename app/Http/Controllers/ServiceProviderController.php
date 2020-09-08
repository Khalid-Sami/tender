<?php

namespace App\Http\Controllers;

use App\Attachments;
use App\BankAccount;
use App\Category;
use App\CategoryView;
use App\CompanyCategories;
use App\CompanyView;
use App\ConversationUser;
use App\EvaluationData;
use App\ItemsView;
use App\Messages;
use App\Notification;
use App\NotificationUser;
use App\Offer;
use App\OfferItems;
use App\RequestAttachment;
use App\RequestQuestionAnswer;
use App\RequestQuotation;
use App\ReverseAuction;
use App\ReverseAuctionProposal;
use App\ReverseAuctionProposalItem;
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
use App\Tender;
use App\TenderItems;
use App\TenderProposal;
use App\TenderProposalItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
use Yajra\Datatables\Facades\Datatables;


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

    public function showAllUsers(Request $request)
    {
        $status = ConstantView::getIdNameData('STATUS')->prepend(trans('lang.show_all'), '');;
        $user_role = ConstantView::getIdNameData('USERS_ROLES')->forget(5)->prepend(trans('lang.show_all'), '');

        return view('admin.service_provider.users.showAll', compact('status', 'user_role'));
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
//        $data['working'] = SPWorkingHours::where('fk_i_service_provider_id', $data['provider_id'])->get();
        $data['profileMeta'] = ProfileMeta::where(['fk_i_ref_id' => $data['provider_id']])->get()->keyBy('s_key');
        $data['BankAccountInfo'] = BankAccount::where(['fk_i_company_id' => $data['provider_id']])->first();
        $data['cities'] = ConstantView::where('s_key', 'CITIES')->get(['pk_i_id', 's_name']);
        $categories = CategoryView::where('s_parent_id',0)->get(['pk_i_id','s_name','b_enabled']);
        $companyCategory = CompanyCategories::where('fk_i_comapny_id',$data['provider_id'])->get();
        $countries = ConstantView::where([
            ['fk_i_parent_id',8],
            ['b_enabled','<>',0]
        ])->get(['pk_i_id', 's_name_ar']);
//        $userStatus = User::find(1)->userRule()->where('pk_i_id', session('user_id'))->first();
        $data['userStatus'] = $data['user']->userRule;
        $selectCountry = array();
        foreach($countries as $country) {
            $selectCountry[$country->pk_i_id] = $country->s_name_ar;
        }
        $currencies = ConstantView::where([
            ['fk_i_parent_id',49],
            ['b_enabled',1]
        ])->get(['pk_i_id', 's_name']);
        $selectCurrency = array();
        foreach($currencies as $currency) {
//            if(app()->getLocale() == 'ar')
            $selectCurrency[$currency->pk_i_id] = $currency->s_name;
//            else
//                $selectCurrency[$curreny->pk_i_id] = $curreny->s_name;
        }
//        $data['country'] = $data['country']->toArray();
//        $result = array();
//        foreach($data['country'] as $item){
////            dd($item);
//            $temp  = [$item['pk_i_id'] => $item['s_name_ar']];
//            array_push($result , $temp);
//        }
//        $data['country'] = call_user_func_array('array_merge',$result);
//        dd( $data['country'] );
//        $data['country'] = array($result);
//        return view('user.provider_admin.profile', $data)->with("country", $selectCountry);
//        $data['country'] = $selectCountry;
        return view('admin.users.serviceProvider', $data)->with(["country" => $selectCountry, "currencies" => $selectCurrency,'categories' => $categories, 'companyCategory' => $companyCategory]);

    }

    public function updateSPInformation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            's_name_ar' => 'required',
            's_name_en' => 'required',
            's_fax' => 'required',
            's_email' =>'required|email',
//            's_company_name' => 'required',
            's_trade_license_no' => 'required|numeric',
            's_telephone_number' => 'required|numeric',
            's_mobile_number' => 'required|numeric',
            's_sales_representative_mobile' => 'numeric'
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
            's_fax' => $request->input('s_fax'),
            's_email' => $request->input('s_email'),
//            's_company_name' => $request->input('s_company_name'),
            's_telephone_number' => $request->input('s_telephone_number'),
            's_mobile_number' => $request->input('s_mobile_number'),
            's_trade_license_no' => $request->input('s_trade_license_no'),
            's_address_ar' => !empty($request->input('s_address_ar')) ? $request->input('s_address_ar') : null,
            's_address_en' => !empty($request->input('s_address_en')) ? $request->input('s_address_en') : null,
            's_country' => !empty($request->input('s_country')) ? $request->input('s_country') : null,
            's_city' => !empty($request->input('s_city')) ? $request->input('s_city') : null,
            's_zip_code' => !empty($request->input('s_zip_code')) ? $request->input('s_zip_code') : null,
            's_website' => !empty($request->input('s_website')) ? $request->input('s_website') : null,
            's_sales_representative_name' => !empty($request->input('s_sales_representative_name')) ? $request->input('s_sales_representative_name') : null,
            's_sales_representative_mobile' => !empty($request->input('s_sales_representative_mobile')) ? $request->input('s_sales_representative_mobile') : null,
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

    public function updateSPBankAccountInfo (Request $request, $id){
        $accountName = $request->input('s_bank_name');
        $accountNumber = $request->input('s_account_number');
        $accountCurrency = $request->input('s_currency');
        $accountNote = $request->input('s_note');

        BankAccount::where(['fk_i_company_id' => $id])->update([
            's_bank_name' => !empty($request->input('s_bank_name')) ? $request->input('s_bank_name') : null,
            's_account_number' => !empty($request->input('s_account_number')) ? $request->input('s_account_number') : null,
            's_currency' => !empty($request->input('s_currency')) ? $request->input('s_currency') : null,
            's_note' => !empty($request->input('s_note')) ? $request->input('s_note') : null
        ]);

        return back()->with([
            'msg' => trans('lang.updated'),
            'tab6_state' => 'active'
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
        $data['isEvaluated'] = EvaluationData::where('fk_i_request_id',$requestId)->count();
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

    public function setApprovedAccount($id){
        ServiceProvider::where('pk_i_id',$id)->update([
            'i_status' => '20'
        ]);
        return back();
    }

    public function insertOrUpdateCategory(Request $request, $id){
        if($request->input('category') == null) {
            CompanyCategories::where('fk_i_comapny_id', $id)->delete();
        }
        else {
            foreach ($request->input('category') as $category){
                 CompanyCategories::updateOrCreate(
                ['fk_i_comapny_id' => $id,'fk_i_categories_id' => (int)$category],
                     ['dt_created_at' => date('Y-m-d H:i:s')]
                 );
//                 dd($categoryCompany);
            }
            $categoriesComapny = CompanyCategories::where('fk_i_comapny_id', $id)->get();
            $check = 0;
            foreach ($categoriesComapny as $cc){
                    foreach ($request->input('category') as $category){
                        if($cc->fk_i_categories_id == $category)
                            $check = 1;
                    }
                    if($check == 0)
                    CompanyCategories::where('pk_i_id', $cc->pk_i_id)->delete();
                $check = 0;
            }
//            $category = CompanyCategories::updateOrCreate(
//                ['fk_i_comapny_id' => $id],['fk_i_categories_id' => ],['dt_modified_date' => date("Y-m-d H:i:s")]
//            );
        }
        return back()->with([
            'msg' => trans('lang.updated'),
            'tab7_state' => 'active'
        ]);
    }

    public function storeNewBankAccount(Request $request){
        $bankAccounts = BankAccount::where([
            's_bank_name' => $request->input('s_bank_name'),
            's_account_number' => $request->input('s_account_number'),
            'fk_i_company_id' => $request->input('fk_i_company_id')
        ])->first();

        if (count($bankAccounts) == 0) {
            $bank = BankAccount::create([
                's_bank_name' => $request->input('s_bank_name'),
                's_account_number' => $request->input('s_account_number'),
                's_currency' => $request->input('s_currency'),
                'fk_i_company_id' => $request->input('fk_i_company_id'),
                's_bank_address' => $request->input('s_bank_address'),
                's_iban' => $request->input('s_iban'),
                's_swift' => $request->input('s_swift'),
                's_note' => $request->input('s_note'),
                'dt_created_at' => date('Y-m-d H:i:s')
            ]);
            if ($file = $request->file('s_bankCertificate')) {
                $bank_file = time() . $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/bank', $bank_file);
                Attachments::create(array(
                    'fk_i_refe_id' => $bank->pk_i_id,
                    'i_attach_type' => 3,
                    's_url' => $bank_file,
                    's_name' => $file_name,
                    'dt_created_date' => date('Y-m-d H:i:s')
                ));
            }
            return back()->with([
                'msg' => trans('lang.added'),
                'tab6_state' => 'active'
            ]);
        }

        if($bankAccounts->b_enabled == 0){
                $bankAccounts->s_currency = $request->input('s_currency');
                $bankAccounts->s_note = $request->input('s_note');
                $bankAccounts->b_enabled = 1;
            if ($file = $request->file('s_bankCertificate')) {
                $bank_file = time() . $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/bank', $bank_file);
                $bankAccounts->attachment->s_url = $bank_file;
                $bankAccounts->attachment->s_name = $file_name;
            }
                $bankAccounts->save();
            return back()->with([
                'msg' => trans('lang.bank_account_already_exit'),
                'tab6_state' => 'active'
            ]);
        }

        return back()->with([
            'error_msg' => trans('lang.exists'),
            'tab6_state' => 'active'
        ]);
//        return back()->with('error_msg', trans('lang.exists'));
    }

    public function updateBankAccount(Request $request){

        $check = BankAccount::where([
            ['pk_i_id','<>', $request->input('pk_i_id')],
            ['s_account_number','=', $request->input('bankAccountNumber')],
            ['fk_i_company_id','=', $request->input('companyID')],
            ['s_bank_name' ,'=', $request->input('bankAccountName'),]
        ])->count();

        if ($check == 0) {
            BankAccount::where('pk_i_id', $request->input('pk_i_id'))->update([
                's_bank_name' => $request->input('bankAccountName'),
                's_account_number' => $request->input('bankAccountNumber'),
                's_currency' => $request->input('BankAccountCurrency'),
                's_bank_address' => $request->input('BankAddress'),
                's_iban' => $request->input('IBANBank'),
                's_swift' => $request->input('SWIFTBank'),
                's_note' => $request->input('BankAccountNotes'),
            ]);
            if ($file = $request->file('bankCertificate')) {
                $bank_file = time() . $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/bank', $bank_file);
                Attachments::updateOrCreate(
                    ['fk_i_refe_id' => $request->input('pk_i_id'), 'i_attach_type' => 3],
                    ['s_url' => $bank_file,'s_name' => $file_name,'dt_modified_date' => date('Y-m-d H:i:s')]
                );
//                Attachments::where('fk_i_refe_id',$request->input('pk_i_id'))->update([
//                    's_url' => $bank_file,
//                    's_name' => $file_name,
//                    'dt_modified_date' => date('Y-m-d H:i:s')
//                ]);

            }
            return back()->with([
                'msg' => trans('lang.updated'),
                'tab6_state' => 'active'
            ]);
        }
        return back()->with([
            'error_msg' => trans('lang.exists'),
            'tab6_state' => 'active'
        ]);
//        return back()->with('error_msg', trans('lang.exists'));

    }

    public function changeBankAccountStatus(Request $request){

        BankAccount::where('pk_i_id',$request->input('BankAccountID'))->update([
            'b_enabled' => $request->input('BankAccountStatus')
        ]);

        return response()->json(['status' => 1]);

    }

    public function getSubCategories($id){
            $status = 0;
            $subCategories = CategoryView::where('s_parent_id',$id)->get(['pk_i_id','s_name']);
            if(count($subCategories)){
                $status = 1;
            }
            return response()->json(['subCategories' => $subCategories, 'status' => $status]);
    }

    public function insertCompanySubCategories(Request $request, $id){
        $categoryAlreadyExist = 0;
        $certainTenders = [];
        $user = User::where('pk_i_id',session('user_id'))->first();
        $serviceProviderID = ServiceProviderUser::where('fk_i_service_provider_id',$request['companyID'])->first(['fk_i_user_id']);
        $check = CompanyCategories::where([
            'fk_i_categories_id' => $id,
            'fk_i_comapny_id' => $request['companyID']
        ])->count();
        $companyCategory = '';
        if(!$check){
            $companyCategory = CompanyCategories::create([
                'fk_i_comapny_id' => $request['companyID'],
                'fk_i_categories_id' => $id,
                'dt_created_at' => date("Y-m-d H:i:s")
            ]);

            $companyCategories = CompanyCategories::where('fk_i_comapny_id',$request['companyID'])->get();
            $comCats = array_column($companyCategories->toArray(), 'fk_i_categories_id');

            $tenderProposals = TenderProposal::where('fk_i_company_id',$request['companyID'])->get(['fk_i_tender_id']);
            $tenderProposals = array_column($tenderProposals->toArray(), 'fk_i_tender_id');
            $tenders = Tender::whereNotIn('pk_i_id', $tenderProposals)->get();

            $selectTenders = new Collection();
            foreach ($tenders as $key=>$tender){
                $nowDate = Carbon::now()->toDateTimeString();
                DB::statement('call update_tender_status(?,?)',array($tender->pk_i_id,$nowDate));
                $tender = Tender::findOrFail($tender->pk_i_id);
                $catIDS = [];
                if($tender->i_status == 97){
                    foreach ($tender->tenderItems as $item){
                        $catIDS[] = $item->item->fk_i_cat_id;
                    }
                }
                $bool = in_array($id, $catIDS);
                if($bool){
                    $categoryAlreadyExist = 1;
//                    $selectTenders->push($tender);
                    $englishMessage = 'There is a tender titled ('.$tender->s_title.') containing this category ending on '.$tender->dt_close_date;
//                    $arabicMessage = 'توجد هناك مناقصة بعنوان ('.$tender->s_title.') تحتوي على نفس التصنيف';
                    $arabicMessage = 'توجد مناقصة بعنوان ('.$tender->s_title.') تحتوي على نفس التصنيف تنتهي في تاريخ '.$tender->dt_close_date;
                    $certainTenders[$key]['id'] = $tender->pk_i_id;
                    $certainTenders[$key]['title'] = $tender->s_title;
                    $certainTenders[$key]['date'] = $tender->dt_close_date;
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
                        'fk_i_user_id' => $serviceProviderID->fk_i_user_id,
                        'dt_created_date' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            return response()->json(['status' => 1, 'companyCategory' => $companyCategory->category, 'categoryAlreadyExist' => $categoryAlreadyExist, 'tenders' => $certainTenders, 'userRole' => $user->userRule->s_name]);
        }
        return response()->json(['status' => 0,'companyCategory' => $companyCategory,'categoryAlreadyExist' => $categoryAlreadyExist]);
    }

    public function removeCompanySubCategories(Request $request, $id){
        $check = CompanyCategories::where('fk_i_categories_id',$id)->count();
        if($check){
             CompanyCategories::where([
                'fk_i_comapny_id' => $request['companyID'],
                'fk_i_categories_id' => $id
            ])->delete();
            return response()->json(['status' => 1]);
        }
        return response()->json(['status' => 0]);
    }

    public function getTenders(Request $request){
        $user_id = session('user_id');
        $data['user'] = User::where('pk_i_id',$user_id)->first();
        $companyUser = ServiceProviderUser::where('fk_i_user_id',$user_id)->first(['fk_i_service_provider_id']);
        $checkTenderProposal = TenderProposal::where('fk_i_company_id',$companyUser->fk_i_service_provider_id)->get(['pk_i_id','fk_i_tender_id','i_status']);

//        if($request->ajax()){
//            return response()->json(['status' => 1,'tenderProposal' => $checkTenderProposal]);
//        }

        return view('ServiceProvider.tenders', compact('checkTenderProposal'));

    }

    public function getServiceProviderTenders(){

        $user_id = session('user_id');
        $tenders = array();
        $data['user'] = User::where('pk_i_id',$user_id)->first();
        if($data['user']->userRule->s_name_en == 'ServiceProviderAdmin'){
              $companyID = $data['user']->company->fk_i_service_provider_id;
//              $tendersIDS = DB::table('t_company_tenders')->where('fk_i_company_id',$companyID)->get(['fk_i_tender_id']);
                $companyTenders = TenderProposal::where('fk_i_company_id',$companyID)->with(['tender'])->get();
                $coTend = array_column($companyTenders->toArray(), 'fk_i_tender_id');
                $catsIDS = CompanyCategories::where('fk_i_comapny_id',$companyID)->get(['fk_i_categories_id'])->toArray();
                $catsIDS = array_column($catsIDS, 'fk_i_categories_id');
                $tenders = Tender::whereNotIn('pk_i_id',$coTend)->with(['status'])->get();
//                $tenders = Tender::with(['status'])->get();
                $selectTenders = new Collection();
                foreach ($tenders as $tender){
                    $catIDS = [];
//                    $items = $tender->tenderItems->toArray();
                    foreach ($tender->tenderItems as $item){
                        $catIDS[] = $item->item->fk_i_cat_id;
                    }
//                    $items = array_column($items, 'fk_i_cat_id');
                    $bool = array_intersect($catsIDS, $catIDS);
                    if(count($bool)){
                        $selectTenders->push($tender);
                    }
                }

                foreach ($companyTenders as $tender){
                    $selectTenders->push($tender->tender);
                }

//                $tendersIDSArray = array();
//                foreach ($tendersIDS as $key=>$tender){
//                $tendersIDSArray[$key] = $tender->fk_i_tender_id;
//                }

                $nowDate = Carbon::now()->toDateTimeString();
//                $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();
                DB::statement('call update_tenders_status(?)',array($nowDate));
//                $tenders = Tender::whereIn('pk_i_id',$tendersIDSArray)->with(['status'])->get();
//                $tenderProposal = TenderProposal::where('fk_i_company_id',$companyID)->get();
                $tps = new Collection();
//                foreach ($companyTenders as $tp){
//                    $desired_tp_id = $selectTenders->filter(function($item) use ($tp) {
//                        return $item->pk_i_id == $tp->fk_i_tender_id;
//                    })->first();
//                    if(count($desired_tp_id)){
//                        $tps->push(collect($desired_tp_id)->union(['tenderProposalStatus' => $tp->i_status == 99 ? true : false, 'tenderProposalID' => $tp->pk_i_id, 'tenderStatus' => true]));
//                    }
//                    else{
//                        $tps->push(collect($desired_tp_id)->union(['tenderProposalStatus' =>false, 'tenderProposalID' => 0, 'tenderStatus' => false]));
//                    }
//                }
                foreach ($selectTenders as $ten){
                    $desired_tp_id = $companyTenders->filter(function($item) use ($ten) {
                            return $item->fk_i_tender_id == $ten->pk_i_id;
                        })->first();
                    if(count($desired_tp_id)){
                        $tps->push(collect($ten)->union(['tenderProposalStatus' => $desired_tp_id->i_status == 99 ? true : false, 'tenderProposalID' => $desired_tp_id->pk_i_id, 'tenderStatus' => true]));
                    }
                    else{
                        $tps->push(collect($ten)->union(['tenderProposalStatus' =>false, 'tenderProposalID' => 0, 'tenderStatus' => false]));
                    }
                }
//            $tenderItems = TenderItems::get();
//            $companyUser = ServiceProviderUser::where('fk_i_user_id',$user_id)->first(['fk_i_service_provider_id']);
//            $companyCategories = CompanyCategories::where('fk_i_comapny_id',$companyUser->fk_i_service_provider_id)->get();
//            foreach ($tenderItems as $tenderItem){
//                $item = ItemsView::where('pk_i_id',$tenderItem->fk_i_item_id)->first();
//                foreach ($companyCategories as $cc){
//                    $subCC = CategoryView::where('pk_i_id',$cc->fk_i_categories_id)->first();
//                    if($subCC->s_parent_id == 0){
//                        if($item->i_parent_cat_id == $subCC->s_parent_id){
//                            DB::statement('call update_tender_status(?)',array($tenderItem->fk_i_tender_id));
//                            $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->with(['status'])->first();
//                            array_push($tenders, $tenderForSpecificCompany);
//                        }
//                    }
//                    else{
//                        $subCategory = CategoryView::where('pk_i_id',$subCC->s_parent_id)->first();
//                        if($subCategory->s_parent_id == 0){
//                            if($subCategory->s_parent_id == $item->i_parent_cat_id){
//                                DB::statement('call update_tender_status(?)',array($tenderItem->fk_i_tender_id));
//                                $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->with(['status'])->first();
//                                array_push($tenders, $tenderForSpecificCompany);
//                            }
//                        }
//                        else{
//                            $subSubCategory = CategoryView::where('pk_i_id',$subCategory->s_parent_id)->first();
//                            if($subSubCategory->s_parent_id == 0){
//                                if($subSubCategory->pk_i_id == $item->i_parent_cat_id){
//                                    DB::statement('call update_tender_status(?)',array($tenderItem->fk_i_tender_id));
//                                    $tenderForSpecificCompany = Tender::where('pk_i_id',$tenderItem->fk_i_tender_id)->with(['status'])->first();
//                                    array_push($tenders, $tenderForSpecificCompany);
//                                }
//                            }
//                        }
//                    }
//                }
//            }
        }

        return Datatables::of(($tps))->make(true);

    }

    public function bidding($id){

        $nowDate = Carbon::now()->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();
        $tender = Tender::where('pk_i_id',$id)->first();
        if($tender->i_accept_offer != 1)
            DB::statement('call update_tender_status(?,?)',array($id,$nowDate));
        $tender = Tender::where('pk_i_id',$id)->first();
        $items = TenderItems::where('fk_i_tender_id',$id)->get();
//        $items = array();
//        foreach ($tenderItems as $tenderItem){
//            $item = ItemsView::where('pk_i_id',$tenderItem->fk_i_item_id)->first();
//            array_push($items,$item);
//        }
        return view('ServiceProvider.bidding', compact('items','tender'));
    }

    public function setSPBidding(Request $request){

        $user_id = session('user_id');
        $data['user'] = User::where('pk_i_id',$user_id)->first();
        $quantities = $request->input('itemQuantity');
        $itemIDS = $request->input('tenderItemID');
        $notes = $request->input('notes');
        $prices = $request->input('price');
        $isDiff = $request->input('isDiff');

        $statDate = Carbon::parse($request->input('startTenderDate'))->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($request->input('endTenderDate'))->format('Y-m-d H:i:s');
        $nowDate = Carbon::now()->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();

        $status = ( $nowDate > $endDate ) ? true : false;

        if($data['user']->userRule->s_name_en == 'ServiceProviderAdmin'){
            if(!$status){
                $companyID = ServiceProviderUser::where('fk_i_user_id',$data['user']->pk_i_id)->first();
                $id = DB::table('t_tender_proposals')->insertGetId(
                    [
                        'fk_i_tender_id' => $request->input('tenderID'),
                        's_notes' => $request->input('editor1'),
                        'fk_i_company_id' => $companyID->fk_i_service_provider_id,
                        'i_status' => 101,
                        'b_enabled' => 1,
                        'dt_created_date' => date('Y-m-d H:i:s')
                    ]
                );

                for ($i=1; $i <= count($itemIDS); $i++){
                    TenderProposalItems::create(array(
                        'fk_i_tender_proposal_id' => $id,
                        'fk_i_tender_item_id' => $itemIDS[''.$i.''],
//                        'i_quantity' => $quantities[''.$i.''],
                        'd_price' => $prices[''.$i.''],
                        's_note' => $notes[''.$i.''],
//                        'd_total' => $prices[''.$i.''] * $quantities[''.$i.''],
                        'dt_created_date' => date('Y-m-d H:i:s')
                    ));
                }

                if(count($isDiff)){
                    foreach ($isDiff as $diff){
                        TenderProposalItems::where([
                            'fk_i_tender_proposal_id' => $id,
                            'fk_i_tender_item_id' => $diff
                        ])->update(['b_is_different' => 1]);
                    }
                }

                if ($request->hasFile('tenderFile')) {
                    foreach ($request->file('tenderFile') as $file){
                        $file_path = time() .'-'. $file->getClientOriginalName();
                        $file_name = $file->getClientOriginalName();
                        $file->move('files/tender_proposal', $file_path);
                        Attachments::create(array(
                            'fk_i_refe_id' => $id,
                            'i_attach_type' => 2,
                            's_url' => $file_path,
                            's_name' => $file_name,
                            'dt_created_date' => date('Y-m-d H:i:s')

                        ));
                    }
                }

                return redirect()->route('SPTenders')->with('msg', trans('lang.biddingSuccessful'));
            }

        }

        return back()->with([
            'error_msg' => trans('lang.tenderExpiredDate'),
        ]);

    }

    public function editBidding($id){
        $user_id = session('user_id');
        $user = User::where('pk_i_id',$user_id)->first();
        $tenderProposal = TenderProposal::where([
            'fk_i_tender_id' => $id,
            'fk_i_company_id' => $user->company->fk_i_service_provider_id
        ])->first();
        $tenderProposalItems = [];
        foreach ($tenderProposal->tenderProposalItems as $tender){
            $tenderProposalItems[] = $tender->fk_i_tender_item_id;
        }
        $tenderItems = TenderItems::whereNotIn('pk_i_id',$tenderProposalItems)->where('fk_i_tender_id',$id)->get();
//        $tenderProposalItems = TenderProposalItems::where('fk_i_tender_proposal_id',$tenderProposal->pk_i_id)->get();
        return view('ServiceProvider.editBidding', compact('id','tenderProposal','tenderProposalItems','tenderItems'));
    }

    public function editSPBidding(Request $request, $id){

        $user_id = session('user_id');
        $data['user'] = User::where('pk_i_id',$user_id)->first();
        $quantities = $request->input('itemQuantity');
        $itemIDS = $request->input('tenderItemID');
        $notes = $request->input('notes');
        $prices = $request->input('price');
        $isDiff = $request->input('isDiff');
        
        $statDate = Carbon::parse($request->input('startTenderDate'))->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($request->input('endTenderDate'))->format('Y-m-d H:i:s');
        $nowDate = Carbon::now()->toDateTimeString();
        $currentDate = Carbon::parse($nowDate)->setTimezone(session('timezone'))->toDateTimeString();

        $status = ( $nowDate > $endDate ) ? true : false;

        if($data['user']->userRule->s_name_en == 'ServiceProviderAdmin'){
            if($status){
                return redirect()->route('SPTenders')->with(['error_msg' => trans('lang.tenderExpiredDate')]);
            }
        }

                TenderProposal::where('pk_i_id',$id)->update([
                   'dt_modified_date' => date('Y-m-d H:i:s')
                ]);

                for ($i=1; $i <= count($itemIDS); $i++){
                    $result = TenderProposalItems::updateOrCreate(
                        ['fk_i_tender_proposal_id' => $id, 'fk_i_tender_item_id' => $itemIDS[''.$i.'']],
                        ['d_price' => $prices[''.$i.''],'s_note' => $notes[''.$i.''],'b_is_different' => 0]
                    );
                    if($result->dt_created_date == null){
                        $result->dt_created_date = date('Y-m-d H:i:s');
                        $result->save();
                    }
                    else{
                        $result->dt_modified_date = date('Y-m-d H:i:s');
                    }
//                    TenderProposalItems::where('pk_i_id',$itemIDS[''.$i.''])->update(array(
//                        'd_price' => $prices[''.$i.''],
//                        's_note' => $notes[''.$i.''],
////                        'd_total' => $prices[''.$i.''] * $quantities[''.$i.''],
//                        'b_is_different' => 0,
//                        'dt_modified_date' => date('Y-m-d H:i:s')
//                    ));
                }

                if(count($isDiff)){
                    foreach ($isDiff as $diff){
//                        TenderProposalItems::where([
//                            'fk_i_tender_proposal_id' => $id,
//                            'fk_i_tender_item_id' => $diff
//                        ])->update(['b_is_different' => 1]);
                        TenderProposalItems::where([
                            'fk_i_tender_proposal_id' => $id,
                            'fk_i_tender_item_id' => $diff
                        ])->update(['b_is_different' => 1]);
                    }
                }

                if ($request->hasFile('tenderFile')) {
                    foreach ($request->file('tenderFile') as $file){
                        $file_path = time() .'-'. $file->getClientOriginalName();
                        $file_name = $file->getClientOriginalName();
                        $file->move('files/tender_proposal', $file_path);
                        Attachments::create(array(
                            'fk_i_refe_id' => $id,
                            'i_attach_type' => 2,
                            's_url' => $file_path,
                            's_name' => $file_name,
                            'dt_created_date' => date('Y-m-d H:i:s')

                        ));
                    }
                }

                return redirect()->route('SPTenders')->with(['msg' => trans('lang.updated')]);
//            }

//        }

//        return back()->with(['error_msg' => trans('lang.tenderExpiredDate')]);

    }

    public function removeTenderProposalFile(Request $request, $id){
        Attachments::where([
//            'fk_i_refe_id' => $id,
            'pk_i_id' => $request['attachmentID']
        ])->delete();
        return response()->json(['status' => 1]);

    }

    public function tenderProposalWithdrawal(Request $request, $id){
        $tenderProposal = TenderProposal::where('pk_i_id',$id)->first();
        $nowDate = Carbon::now()->toDateTimeString();
        if($nowDate > Carbon::parse($tenderProposal->tender->dt_close_date)->toDateTimeString()){
            return response()->json(['status' => 0]);
        }
        else{
            TenderProposal::where('pk_i_id',$id)->update(['i_status' => $request['status']]);
            return response()->json(['status' => 1]);
        }
    }

    public function newOffer(){
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();

        $categories = CategoryView::where('s_parent_id',0)->get();

        return view('ServiceProvider.newOffer', compact('currencies','categories'));
    }

    public function getAllOffers(){
        return view('ServiceProvider.allOffers');
    }

    public function getCompanyOffers(){
        $data = new Collection();
        $companyID = ServiceProviderUser::where('fk_i_user_id',session('user_id'))->first(['fk_i_service_provider_id']);
        $offers = Offer::where('fk_i_company_id',$companyID->fk_i_service_provider_id)->with(['status','currency'])->get();

        foreach ($offers as $offer){
            $total = OfferItems::where('fk_i_offer_id',$offer->pk_i_id)->select(DB::raw('sum(d_price*i_quantity) AS total_itemPrice'))->first();
            $data->push([
                'offerID' => $offer->pk_i_id,
                'offerTitle' => $offer->s_title,
                'total' => $total->total_itemPrice,
                'status' => $offer->status->s_name,
                'currency' => $offer->currency->s_name,
                'statusID' => $offer->i_status
            ]);
        }

        return Datatables::of($data)->make(true);
    }

    public function addNewOffer(Request $request){

        $companyID = ServiceProviderUser::where('fk_i_user_id',session('user_id'))->with(['serviceProvider'])->first(['fk_i_service_provider_id']);

        $quantities = $request->input('quantityItem');
        $prices = $request->input('price');
        $notes = $request->input('itemNotes');
        $ids = $request->input('ids');

        $offerID = DB::table('t_offer')->insertGetId([
            's_title' => $request->input('offerTitle'),
            's_notes' => $request->input('editor1'),
            'fk_i_company_id' => $companyID->fk_i_service_provider_id,
            'i_currency' => $request->input('currency'),
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

        foreach ($ids as $key=>$id){
            OfferItems::create([
               'fk_i_offer_id' => $offerID,
                'fk_i_item_id' => $id,
                'i_quantity' => $quantities[$key],
                'd_price' => $prices[$key],
                's_note' => $notes[$key],
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
        }

        if ($file = $request->file('offerFile')) {
            $offer_file = time() . $file->getClientOriginalName();
            $file->move('files/offer', $offer_file);
            $file_name = $file->getClientOriginalName();
            Attachments::create([
                'fk_i_refe_id' => $offerID,
                'i_attach_type' => 4,
                's_url' => $offer_file,
                's_name' => $file_name,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
        }

        $arabicMessage = "قامت شركة ".$companyID->serviceProvider->s_name." بتقديم عرض جديد ( ".$request->input('offerTitle')." )";
        $englishMessage = "".$companyID->serviceProvider->s_name." submitted a new offer (".$request->input('offerTitle').")";

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

        $userID = User::where('fk_i_role_id',5)->first(['pk_i_id']);

        NotificationUser::create([
            'fk_i_notification_id' => $notification->pk_i_id,
            'fk_i_user_id' => $userID->pk_i_id,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('allOffers.sp')->with('msg', trans('lang.added'));

    }

    public function getItemsUnderCategory($id){

        $categories = new Collection();
        $companyUser = ServiceProviderUser::where('fk_i_user_id',session('user_id'))->first(['fk_i_service_provider_id']);
        $companyCategories = CompanyCategories::where('fk_i_comapny_id',$companyUser->fk_i_service_provider_id)->get(['fk_i_categories_id']);
        foreach ($companyCategories as $comCats){
            $category = CategoryView::where('pk_i_id',$comCats->fk_i_categories_id)->with(['childrenRecursive'])->first();
            $categories->push($category);
        }
//        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($categories->toArray()));
        $catArray = array();
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($categories->toArray())) as $key=>$arr){
            if($key == 'pk_i_id')
                 $catArray[] = $arr;
        }
        $items = ItemsView::where('i_parent_cat_id',$id)->whereIn('fk_i_cat_id',$catArray)->with(['unit'])->get();
//        dd($iterator);
//        dd(iterator_to_array($iterator,true));
        if(count($items))
            return response()->json(['status' => 1, 'items' => $items]);
        else
            return response()->json(['status' => 0]);

    }

    public function getOffer($id){
        $offer = Offer::where('pk_i_id',$id)->first();
        $currencies = $data = ConstantView::where([
            ['s_key','=',"CURRENCY"],
            ['fk_i_parent_id','<>',0]
        ])->get();

        $categories = CategoryView::where('s_parent_id',0)->get();
        return view('ServiceProvider.editOffer',compact('offer','categories','currencies'));
    }

    public function editOffer(Request $request, $offerID){

        $quantities = $request->input('quantityItem');
        $prices = $request->input('price');
        $notes = $request->input('itemNotes');
        $ids = $request->input('ids');

        if($request->input('removedItems')){
            foreach ($request->input('removedItems') as $items){
                OfferItems::where('pk_i_id',$items)->delete();
            }
        }

         Offer::where('pk_i_id',$offerID)->update([
           's_title' => $request->input('offerTitle'),
            's_notes' => $request->input('editor1'),
            'i_currency' => $request->input('currency'),
            'dt_modified_date' => date('Y-m-d H:i:s')
        ]);

        foreach ($ids as $key=>$id){
            OfferItems::updateOrCreate(
                ['fk_i_offer_id' => $offerID, 'fk_i_item_id' => $id],
                [
                    'i_quantity' => $quantities[$key],
                    'd_price' => $prices[$key],
                    's_note' => $notes[$key]
                ]
            );
        }

        if ($file = $request->file('offerFile')) {
                $file_path = time() .'-'. $file->getClientOriginalName();
                $file_name = $file->getClientOriginalName();
                $file->move('files/offer', $file_path);

            Attachments::updateOrCreate(
                ['fk_i_refe_id' => $offerID, 'i_attach_type' => 4],
                [
                    's_url' => $file_path,
                    's_name' => $file_name,
                    'dt_modified_date' => date('Y-m-d H:i:s')
                ]
            );

              }

        return back()->with(['msg' => trans('lang.updated')]);
    }

    public function getOfferDetails($id){
        $offer = Offer::where('pk_i_id',$id)->first();
        return view('ServiceProvider.offerDetails', compact('offer'));
    }

    public function removeOrRetrieveOffer($operation,$id){

        if($operation == 'remove'){
            Offer::where('pk_i_id',$id)->update([
                'i_status' => 99
            ]);
        }
        else if($operation == 'retrieve'){
            Offer::where('pk_i_id',$id)->update([
                'i_status' => 101
            ]);
        }

        return response()->json(['status' => 1]);

    }

    public function showTenderProposalOffer($id){
        $tenderProposal = TenderProposal::where('pk_i_id',$id)->first();
        return view('ServiceProvider.tenderProposalDetails', compact('tenderProposal'));
    }

    public function spReverseAuctions(){
//            $companyID = ServiceProviderUser::where('fk_i_user_id',session('user_id'))->first(['fk_i_service_provider_id']);
        return view('ServiceProvider.reverseAuctions');
    }

    public function getSPReverseAuctions(){

        $user_id = session('user_id');
        $data['user'] = User::where('pk_i_id',$user_id)->first();
        if($data['user']->userRule->s_name_en == 'ServiceProviderAdmin'){
            $companyID = $data['user']->company->fk_i_service_provider_id;
            $nowDate = Carbon::now()->toDateTimeString();
            DB::statement('call update_auctions_status(?)',array($nowDate));
            $companyAuctions = ReverseAuctionProposal::where('fk_i_company_id',$companyID)->with(['auction'])->get();
            $coTend = array_column($companyAuctions->toArray(), 'fk_i_auction_id');
            $catsIDS = CompanyCategories::where('fk_i_comapny_id',$companyID)->get(['fk_i_categories_id'])->toArray();
            $catsIDS = array_column($catsIDS, 'fk_i_categories_id');
            $auctions = ReverseAuction::whereNotIn('pk_i_id',$coTend)->with(['status'])->get();
            $selectAuctions = new Collection();
            foreach ($auctions as $auction){
                $catIDS = [];
                $catIDS[] = $auction->auctionITem->item->fk_i_cat_id;
                $bool = array_intersect($catsIDS, $catIDS);
                if(count($bool)){
                    $selectAuctions->push($auction);
                }
            }

            foreach ($companyAuctions as $auction) {
                $selectAuctions->push($auction->auction);
            }
            $tps = new Collection();

            foreach ($selectAuctions as $ten){
                $desired_tp_id = $companyAuctions->filter(function($item) use ($ten) {
                    return $item->fk_i_auction_id == $ten->pk_i_id;
                })->first();

                if(count($desired_tp_id)){
//                    $desired_tp_id->auction->i_status = ($nowDate > $desired_tp_id->auction->dt_close_date) ? 98 : 97;
//                    $desired_tp_id->auction->save();
//                    $ten->i_status = ($nowDate > $ten->dt_close_date) ? 98 : 97;
//                    $ten->save();
                    $tps->push(collect($ten)->union(['reverseAuctionProposalStatus' => $desired_tp_id->i_status == 99 ? true : false, 'reverseAuctionProposalID' => $desired_tp_id->pk_i_id, 'reverseAuctionStatus' => true]));
                }
                else{
//                    $ten->i_status = ($nowDate > $ten->dt_close_date) ? 98 : 97;
//                    $ten->save();
                    $tps->push(collect($ten)->union(['reverseAuctionProposalStatus' =>false, 'reverseAuctionProposalID' => 0, 'reverseAuctionStatus' => false]));
                }
            }
        }

        return Datatables::of(($tps))->make(true);

    }

    public function pushAuctionPrice(Request $request){
        $nowDate = Carbon::now()->toDateTimeString();
        DB::statement('call update_auction_status(?,?)',array($request['auctionID'],$nowDate));
        $status = ReverseAuction::where('pk_i_id', $request['auctionID'])->first(['i_status']);
        if($status->i_status == 98){
            return response()->json(['status' => 0]);
        }
        $options = array(
            'encrypted' => true
        );
        $pusher = new \Pusher(
            env("PUSHER_KEY"),
            env("PUSHER_SECRET"),
            env("PUSHER_APP_ID"),
            $options
        );

        $companyID = ServiceProviderUser::where('fk_i_user_id', session('user_id'))->first(['fk_i_service_provider_id']);
        $companyName = CompanyView::where('pk_i_id', $companyID->fk_i_service_provider_id)->first();
        $auction = ReverseAuction::where('pk_i_id', $request['auctionID'])->first();
        $data['price'] = $request['price'];
        $data['id'] = session('user_id');
        $data['name'] = $companyName->s_name;
        $data['nameAr'] = $companyName->s_name_ar;
        $data['nameEn'] = $companyName->s_name_en;
        $data['time'] = date('Y-m-d H:i:s');
        $data['auction'] = $auction->s_title;

        $auctionOffer = ReverseAuctionProposal::firstOrNew([
            'fk_i_auction_id' => $request['auctionID'],
            'fk_i_company_id' => $companyID->fk_i_service_provider_id,
        ],
            [
                'i_status' => 101,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
        $auctionOffer->save();
        $reverseAuctionProposalItemID = ReverseAuctionProposalItem::insertGetId([
            'fk_i_auction_id' => $request['auctionID'],
            'fk_i_auction_proposal_id' => $auctionOffer->pk_i_id,
            'fk_i_auction_item_id' => $auction->auctionITem->pk_i_id,
            'd_price' => (float) $data['price'],
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);
        $data['itemID'] = $reverseAuctionProposalItemID;
        $proposals = ReverseAuctionProposal::where('fk_i_auction_id', $request['auctionID'])->get(['fk_i_company_id']);
        $proposalsArray = array();
        foreach ($proposals as $proposal){
            $proposalsArray[] = $proposal->fk_i_company_id;
        }
        $users = ServiceProviderUser::whereIn('fk_i_service_provider_id', $proposalsArray)->get(['fk_i_user_id']);
        $auctionUsers = array();
        foreach ($users as $user){
            if($user->fk_i_user_id != session('user_id'))
                $auctionUsers[] = $user->fk_i_user_id;
        }
        $auctionUsers[] = 'auctionChannel';
        $pusher->trigger($auctionUsers, 'auction', $data);
        return response()->json(['status' => 1, 'info' => $data]);
    }

    public function auctionDetails($id){
        $nowDate = Carbon::now()->toDateTimeString();
        DB::statement('call update_auction_status(?,?)',array($id,$nowDate));
        $auction = ReverseAuction::where('pk_i_id', $id)->first();
        return view('ServiceProvider.auctionDetails', compact('auction'));
    }

}
