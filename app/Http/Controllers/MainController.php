<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryView;
use App\Company;
use App\CompanyCategories;
use App\ConstantView;
use App\Notification;
use App\NotificationUser;
use App\NotificationView;
use App\SendNotificationView;
use App\ServiceProvider;
use App\ServiceProviderUser;
use App\RequestQuotation;
use App\CompanyView;
use App\SPServices;
use App\User;
use App\EvaluationView;
use App\Review;
use App\EvaluationData;
use App\Request as RequestClass;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MainController extends Controller
{
    //

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->middleware(['locale', 'is.login']);
    }

    public function index()
    {
        $data["title1"] = "Home Page";
        return view('_layout', $data);
    }

    public function showRating(Request $request, $requestId)
    {

        RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 58, 'dt_modified_date' => Carbon::now()]);
        $user = User::where('pk_i_id', session('user_id'))->first();
        $userRule = $user->userRule->s_name_en;
        if ($userRule == 'ServiceProviderAdmin') {
            $data['evaluation'] = EvaluationView::where('i_type', 1)->get();
        }
        if ($userRule == 'ServiceProviderUser') {
            $data['evaluation'] = EvaluationView::where('i_type', 2)->get();
        }
        $data['requestId'] = $requestId;
        $data['isEvaluated'] = EvaluationData::where('fk_i_request_id', $requestId)->count();
        $data['evaluationData'] = null;
        if ($data['isEvaluated'] != 0) {
            $data['evaluationData'] = EvaluationData::where('fk_i_request_id', $requestId)->get();
        }
        return view('rating', $data);
    }


    public function storeRating(Request $request, $requestId)
    {
        $byUserId = session('user_id');
        $iterator = $request->input('iterate');
        $review = $request->input('review');

        $user = User::where('pk_i_id', session('user_id'))->first();
        $userName = $user->s_first_name . ' ' . $user->s_last_name;
        RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 59, 'dt_modified_date' => Carbon::now()]);
        if ($user->userRule->s_name_en == 'ServiceProviderAdmin') {

            $forUserId = RequestClass::where('pk_i_id', $requestId)->first(['fk_i_user_id'])->fk_i_user_id;
            for ($i = 0; $i < $iterator; $i++) {
                $rate = $request->input('rating' . $i);
                $evalId = $request->input('evaluation' . $i);
                EvaluationData::create([
                    'fk_i_request_id' => $requestId,
                    'fk_i_evaluation_id' => $evalId,
                    'fk_i_by_user_id' => $byUserId,
                    'd_value' => $rate,
                    'fk_i_for_user_id' => $forUserId,
                    'b_enabled' => 1,
                    'dt_created_date' => Carbon::now(),
                ]);
                Review::create([
                    'fk_i_request_id' => $requestId,
                    's_review' => $review,
                    'fk_i_by_user_id' => $byUserId,
                    'fk_i_for_user_id' => $forUserId,
                    'i_approvied' => 1,
                    'b_enabled' => 1,
                    'dt_created_date' => Carbon::now(),
                ]);
            }
            $notification = Notification::create([
                'fk_i_actor_user_id' => $byUserId,
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_en' => 's_name_en>' . $userName,
                's_title_ar' => 's_name_ar>' . $userName,
                'i_action' => 3,
                'fk_i_notification_template_id' => 2,
                'request_id' => $requestId,
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $forUserId,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('quotations.show')->with(['msg' => trans('lang.eval_success')]);
        }
        if ($user->userRule->s_name_en == 'ServiceProviderUser') {

            $serviceProviderId = RequestQuotation::where(['fk_i_request_id' => $requestId, 'i_status' => 65])->first(['fk_i_company_id'])->fk_i_company_id;
            $forUserId = ServiceProviderUser::where(['fk_i_role_id' => 6, 'fk_i_company_id' => $serviceProviderId])->first(['fk_i_user_id'])->fk_i_user_id;
            for ($i = 0; $i < $iterator; $i++) {
                $rate = $request->input('rating' . $i);
                $evalId = $request->input('evaluation' . $i);
                EvaluationData::create([
                    'fk_i_request_id' => $requestId,
                    'fk_i_evaluation_id' => $evalId,
                    'fk_i_by_user_id' => $byUserId,
                    'd_value' => $rate,
                    'fk_i_for_user_id' => $forUserId,
                    'b_enabled' => 1,
                    'dt_created_date' => Carbon::now()
                ]);
                Review::create([
                    'fk_i_request_id' => $requestId,
                    's_review' => $review,
                    'fk_i_by_user_id' => $byUserId,
                    'fk_i_for_user_id' => $forUserId,
                    'i_approvied' => 1,
                    'b_enabled' => 1,
                    'dt_created_date' => Carbon::now(),
                ]);
            }

            $notification = Notification::create([
                'fk_i_actor_user_id' => $byUserId,
                'i_target_users_type' => 2,
                'i_title_type' => 2,
                's_title_en' => 's_name_en>' . $userName,
                's_title_ar' => 's_name_ar>' . $userName,
                'i_action' => 3,
                'fk_i_notification_template_id' => 2,
                'request_id' => $requestId,
                'b_enabled' => 1,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);
            NotificationUser::create([
                'fk_i_notification_id' => $notification->pk_i_id,
                'fk_i_user_id' => $forUserId,
                'dt_created_date' => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('quotations.show')->with(['msg' => trans('lang.eval_success')]);
        }

    }


    public function getNotifications()
    {
        return view('showNotifications', compact('notifications', 'send_notifications'));

    }


    public function getTableData(Request $request, $model)
    {

        $ids = $request['categoryIDS'];
        $allIDS = [];
        if($model == 'showCompanies'){
            $category = $request['categoryID'];
            $data = CompanyView::query();
            if($request->has('status') && count($ids)){
                if($request->input('status') == 1){
//                    $data = DB::table('t_company')->where('b_enabled',2)
//                        ->join('t_comapny_categories', function($join) use ($category)
//                        {
//                            $join->on('t_comapny_categories.fk_i_comapny_id', '=', 't_company.pk_i_id')
//                                ->where('t_comapny_categories.fk_i_categories_id', '=',$category);
//                        })
//                        ->get(array(
//                            'pk_i_id' => 't_company.pk_i_id',
//                            's_name_ar' => 't_company.s_name_ar',
//                            's_name_en' => 't_company.s_name_en',
//                            's_email' => 't_company.s_email',
//                            'b_enabled' => 't_company.b_enabled',
//                            'i_status' => 't_company.i_status'
//                        ));
                        $category = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with(['childrenRecursive'])->first();
                    $catArray = array();
                    foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($category->toArray())) as $key=>$arr){
                        if($key == 'pk_i_id')
                            $catArray[] = $arr;
                    }
//                    $cats = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with('childrenRecursive')->first();
//                    $allIDS[] = $cats->pk_i_id;
//                    if($cats->childrenRecursive != null){
//                        foreach ($cats->childrenRecursive as $cat){
//                            $allIDS[] = $cat->pk_i_id;
//                            if($cat->childrenRecursive != null){
//                                foreach ($cat->childrenRecursive as $subCat){
//                                    $allIDS[] = $subCat->pk_i_id;
//                                    if($subCat->childrenRecursive != null){
//                                        foreach ($subCat->childrenRecursive as $sub){
//                                            $allIDS[] = $sub->pk_i_id;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
                    $data = CompanyCategories::with('company')->whereIn('fk_i_categories_id', $catArray)->whereHas('company', function($query) {
                        $query->where('b_enabled', '=', 2);
                    })->groupBy('fk_i_comapny_id')->get();

                    foreach ($data as $key => $dt){
                        $data[$key] = $dt->company;
                    }
                }
//                    $data->where('b_enabled', 2)->get();
                else{
//                    $data = DB::table('t_company')->where(function ($query){
//                        $query->where('b_enabled', 0)->orWhere('b_enabled', 1)->orWhere('b_enabled', 3);
//                    })
//                        ->join('t_comapny_categories', function($join) use ($category)
//                        {
//                            $join->on('t_comapny_categories.fk_i_comapny_id', '=', 't_company.pk_i_id')
//                                ->where('t_comapny_categories.fk_i_categories_id', '=',$category);
//                        })
//                        ->get(array(
//                            'pk_i_id' => 't_company.pk_i_id',
//                            's_name_ar' => 't_company.s_name_ar',
//                            's_name_en' => 't_company.s_name_en',
//                            's_email' => 't_company.s_email',
//                            'b_enabled' => 't_company.b_enabled',
//                            'i_status' => 't_company.i_status'
//                        ));

                    $category = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with(['childrenRecursive'])->first();
                    $catArray = array();
                    foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($category->toArray())) as $key=>$arr){
                        if($key == 'pk_i_id')
                            $catArray[] = $arr;
                    }

//                    $cats = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with('childrenRecursive')->first();
//                    $allIDS[] = $cats->pk_i_id;
//                    if($cats->childrenRecursive != null){
//                        foreach ($cats->childrenRecursive as $cat){
//                            $allIDS[] = $cat->pk_i_id;
//                            if($cat->childrenRecursive != null){
//                                foreach ($cat->childrenRecursive as $subCat){
//                                    $allIDS[] = $subCat->pk_i_id;
//                                    if($subCat->childrenRecursive != null){
//                                        foreach ($subCat->childrenRecursive as $sub){
//                                            $allIDS[] = $sub->pk_i_id;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
                    $data = CompanyCategories::with('company')->whereIn('fk_i_categories_id', $catArray)->whereHas('company', function($query) {
                        $query->where('b_enabled', '=', 0)->orWhere('b_enabled', 1)->orWhere('b_enabled', 3);
                    })->groupBy('fk_i_comapny_id')->get();
                    foreach ($data as $key => $dt){
                        $data[$key] = $dt->company;
                    }
                }
//                    $data->where('b_enabled', 0)->orWhere('b_enabled', 1)->orWhere('b_enabled',3)->get();
            }
            else if($request->has('status')){
                if($request->input('status') == 1){
                    $data->where('b_enabled', 2)->get();
                }
                else {
                    $data->where('b_enabled', '<>', 2)->get();
                }
            }
            else if(count($ids)){
//                $data = DB::table('t_company')
//                    ->join('t_comapny_categories', function($join) use ($category)
//                    {
//                        $join->on('t_comapny_categories.fk_i_comapny_id', '=', 't_company.pk_i_id')
//                            ->where('t_comapny_categories.fk_i_categories_id', '=',$category);
//                    })
//                    ->get(array(
//                        'pk_i_id' => 't_company.pk_i_id',
//                        's_name_ar' => 't_company.s_name_ar',
//                        's_name_en' => 't_company.s_name_en',
//                        's_email' => 't_company.s_email',
//                        'b_enabled' => 't_company.b_enabled',
//                        'i_status' => 't_company.i_status'
//                    ));

                $category = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with(['childrenRecursive'])->first();
                $catArray = array();
                foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($category->toArray())) as $key=>$arr){
                    if($key == 'pk_i_id')
                        $catArray[] = $arr;
                }

//                $cats = CategoryView::where('pk_i_id',$ids[count($ids)-1])->with('childrenRecursive')->first();
//                $allIDS[] = $cats->pk_i_id;
//                if($cats->childrenRecursive != null){
//                    foreach ($cats->childrenRecursive as $cat){
//                        $allIDS[] = $cat->pk_i_id;
//                        if($cat->childrenRecursive != null){
//                            foreach ($cat->childrenRecursive as $subCat){
//                                $allIDS[] = $subCat->pk_i_id;
//                                if($subCat->childrenRecursive != null){
//                                    foreach ($subCat->childrenRecursive as $sub){
//                                        $allIDS[] = $sub->pk_i_id;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
                $data = CompanyCategories::with('company')->whereIn('fk_i_categories_id', $catArray)->groupBy('fk_i_comapny_id')->get();
                foreach ($data as $key => $dt){
                    $data[$key] = $dt->company;
                }
            }
            else{
                $data = CompanyView::with(['enabled','status'])->get();
            }
            return Datatables::of($data)->make(true);
        };

        if ($model == 'getCompany') {
            if ($request->has('company') || $request->has('status')) {
                $data = CompanyView::query();
                if ($request->has('company') && $request->has('status')) {
                    $data->where('s_name_en', 'like', "%" . $request->input('company') . "%")->orWhere('s_name_ar', 'like', "%" . $request->input('company') . "%");
                }
                if ($request->has('company')) {
                    $data->where('s_name_en', 'like', "%" . $request->input('company') . "%")->orWhere('s_name_ar', "like", "%" . $request->input('company') . "%");
                }
                if ($request->has('status')) {
                    $data->where('i_status', $request->input('status'));
                }

                $data = $data->with('status')->get();
            } else {
                $data = CompanyView::with('status')->get();
            }
            return Datatables::of($data)
                ->make(true);
        }
        if ($model == 'getCompanyUpdates') {
            $data = SPServices::getData();

            return Datatables::of($data)->make(true);
        }
        if ($model == 'showUsers') {
            $user = User::query();
            if ($request->has('role') || $request->has('status')) {
                $state = $request->input('status');
                if ($state == 47) {
                    $state = 1;
                } else if ($state == 48) {
                    $state = 0;
                }

                if ($request->has('role') && $request->has('status')) {
                    $user->where(['fk_i_role_id' => $request->input('role'), 'b_enabled' => $state]);
                }

                if ($request->has('role')) {
                    $user->where('fk_i_role_id', $request->input('role'));
                }
                if ($request->has('status')) {
                    $user->where('b_enabled', $state);
                }


                $data = $user->with(['gender', 'userRule'])->where('fk_i_role_id', '!=', 5)->get();
            } else {
                $data = $user->with(['gender', 'userRule'])->where('fk_i_role_id', '!=', 5)->get();
            }


            return Datatables::of($data)->addColumn('full_name', function ($row) {
                return $row->s_first_name . ' ' . $row->s_last_name;
            })->make(true);
        }
        if ($model == 'showServiceProviderUsers') {
            $user = User::query();
            if ($request->has('role') || $request->has('status')) {
                $state = $request->input('status');
                if ($state == 47) {
                    $state = 1;
                } else if ($state == 48) {
                    $state = 0;
                }

                if ($request->has('role') && $request->has('status')) {
                    $user->where(['fk_i_role_id' => $request->input('role'), 'b_enabled' => $state]);
                }

                if ($request->has('role')) {
                    $user->where('fk_i_role_id', $request->input('role'));
                }
                if ($request->has('status')) {
                    $user->where('b_enabled', $state);
                }


                $data = $user->with(['gender', 'userRule'])->where('fk_i_role_id', '=', 7)->get();
            } else {
                $data = $user->with(['gender', 'userRule'])->where('fk_i_role_id', '=', 7)->get();
            }


            return Datatables::of($data)->addColumn('full_name', function ($row) {
                return $row->s_first_name . ' ' . $row->s_last_name;
            })->make(true);
        }
        if ($model == 'getCompanyUsers') {
            $provider_id = $request->input('id');
            $data = ServiceProviderUser::with('user')->where('fk_i_company_id', $provider_id)->where('fk_i_role_id', '!=', 6)->get();

            return Datatables::of($data)->addColumn('full_name', function ($row) {
                return $row->user->s_first_name . ' ' . $row->user->s_last_name;
            })->addColumn('rule', function ($row) {
                $rule = isset($row->user->userRule->s_name) ? $row->user->userRule->s_name : '';
                return $rule;
            })->addColumn('gender', function ($row) {
                $gender = isset($row->user->gender->s_name) ? $row->user->gender->s_name : '';
                return $gender;
            })->make(true);
        }
        if ($model == 'showQuotations') {

            $userId = $request->input('userId');
            $company_id = ServiceProviderUser::where(['fk_i_user_id' => $userId, 'fk_i_role_id' => 6])->first(['fk_i_company_id'])->fk_i_company_id;
            $data = RequestQuotation::with('status')->orderBy('dt_created_date', 'desc')->where(['fk_i_company_id' => $company_id])->get();
            $user = User::where('pk_i_id', $userId)->first(['s_first_name', 's_last_name']);
            return Datatables::of($data)->addColumn('service_name', function ($row) {
                return $row->request->service->s_service;
            })->addColumn('provider_name', $user->s_first_name . ' ' . $user->s_last_name)->make(true);
        }

        if ($model == 'getAllRequest') {

            $user_id = session('user_id');
            $user = User::where('pk_i_id', $user_id)->first();
            if ($user->userRule->s_name_en == 'ServiceProviderAdmin') {
                $data = Notification::where('s_ids', '!=', null)->where('s_ids', 'not like', '%/%')->get()->map(function ($items) {
                    return $items->notificationUsers->where('fk_i_user_id', session('user_id'));
                });
                $request = collect(new RequestClass());
                $myId = 0;
                $data = $data->flatten();
                if (!$data->isEmpty()) {
                    foreach ($data as $d) {
                        $dd = Notification::where('pk_i_id', $d->fk_i_notification_id)->first();
                        if ($myId != $dd->fk_i_actor_user_id) {
                            $request->push(RequestClass::where('fk_i_user_id', $dd->fk_i_actor_user_id)->with(['status', 'service', 'user'])->get());
                            $myId = $dd->fk_i_actor_user_id;
                        }
                    }
                    $requests = $request[0];
                } else {
                    $requests = collect();
                }

            } else if ($user->userRule->s_name_en == 'ServiceProviderUser') {

                $requests = RequestClass::where('fk_i_user_id', $user_id)->with(['status', 'service', 'user'])->get();
            }


            return Datatables::of($requests)->addColumn('full_name', function ($row) {
                return $row->user->s_first_name . ' ' . $row->user->s_last_name;
            })->make(true);
        }
        if ($model == 'getRequest') {

            $user_id = session('user_id');
            $data = RequestClass::where('fk_i_user_id', $user_id)->with(['status', 'service', 'user'])->get();

            return Datatables::of($data)->make(true);
        }


        $modelName = '\App' . '\\' . $model;
        $class = new $modelName();

        $notifications = $class::orderBy('dt_created_date', 'desc')->get();
        return Datatables::of($notifications)
            ->make(true);

    }

    public function getCountries(){
        $countries = ConstantView::where('fk_i_parent_id',8)->get(['pk_i_id', 's_name_ar', 's_name_en']);
//        $selectCountry = array();
//        foreach($countries as $country) {
//            $selectCountry[$country->pk_i_id] = $country->s_name_ar;
//        }
        return response()->json(["country" => $countries]);
    }

    public function getCities(Request $request, $id){
        $cities = ConstantView::where([
            ['fk_i_parent_id',$id],
            ['b_enabled','<>',0]
        ])->get(['pk_i_id', 's_name']);
        $companyCity = ServiceProvider::where('pk_i_id',$request['companyID'])->first(['s_city']);
        return response()->json(["city" => $cities, 'companyCity' => $companyCity]);
    }

    public function getCategories(Request $request,$id){
//        $categories = CategoryView::where('s_parent_id',0)->get(['pk_i_id','s_name']);
        $companyCategory = CompanyCategories::where('fk_i_comapny_id',$id)->get();
//        $selectCategories = array();
//        foreach ($categories as $category) {
//            $selectCategories[$category->pk_i_id] = $category->s_name;
//        }
//        $selectComapnyCategories = array();
//        foreach ($companyCategory as $category) {
//            $selectComapnyCategories['categories_id'] = $category->fk_i_categories_id;
//        }
        return response()->json(['companyCategory' => $companyCategory]);
    }

}
