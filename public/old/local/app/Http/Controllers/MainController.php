<?php

namespace App\Http\Controllers;

use App\Notification;
use App\NotificationView;
use App\SendNotificationView;
use App\ServiceProvider;
use App\ServiceProviderUser;
use App\ServiceProviderView;
use App\SPServices;
use App\User;
use App\Request as RequestClass;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class MainController extends Controller
{
    //

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->middleware(['locale','is.login']);
    }

    public function index()
    {

        return view('_layout');
    }

    public function getNotifications()
    {
        return view('showNotifications', compact('notifications', 'send_notifications'));

    }


    public function getTableData(Request $request, $model)
    {


        if ($model == 'getServiceProvider') {
            if ($request->has('service_provider') || $request->has('status')) {
                $data = ServiceProviderView::query();
                if ($request->has('service_provider') && $request->has('status')) {
                    $data->where(['s_name_en' => $request->input('service_provider'), 'i_status' => $request->input('status')])->orWhere(['s_name_ar' => $request->input('service_provider'), 'i_status' => $request->input('status')]);
                }
                if ($request->has('service_provider')) {
                    $data->where('s_name_en', $request->input('service_provider'))->orWhere('s_name_ar', $request->input('service_provider'));
                }
                if ($request->has('status')) {
                    $data->where('i_status', $request->input('status'));
                }

                $data = $data->with('status')->get();
            } else {
                $data = ServiceProviderView::with('status')->get();
            }
            return Datatables::of($data)
                ->make(true);
        }
        if ($model == 'getServiceProviderUpdates') {
        $data = SPServices::getData();

            return Datatables::of($data)->make(true);
        }
        if ($model == 'showUsers') {
            $user = User::query();
            if ($request->has('role') || $request->has('status')) {
                $state = $request->input('status');
                if ($state == 47) {
                    $state = 1;
                } else if($state == 48){
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


                $data = $user->with(['gender', 'userRule'])->get();
            } else {
                $data = $user->with(['gender', 'userRule'])->get();
            }


            return Datatables::of($data)->addColumn('full_name', function ($row) {
                return $row->s_first_name . ' ' . $row->s_last_name;
            })->make(true);
        }
        if ($model == 'getServiceProviderUsers') {

            $provider_id = $request->input('id');
            $data = ServiceProviderUser::with('user')->where('fk_i_service_provider_id', $provider_id)->where('fk_i_role_id', '!=', 6)->get();

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

        if ($model == 'getAllRequest') {

            $user_id = session('user_id');
            $user = User::where('pk_i_id', $user_id)->first();
            if ($user->userRule->s_name_en == 'ServiceProviderAdmin') {
                $data = Notification::where('s_ids', '!=', null)->where('s_ids', 'not like', '%/%')->get()->map(function ($items) {
                    return $items->notificationUsers->where('fk_i_user_id', session('user_id'));
                });
                $request = collect(new RequestClass());
                $myId = 0;
                foreach ($data as $d) {
                    $dd = Notification::where('pk_i_id', $d[0]->fk_i_notification_id)->first();
                    if ($myId != $dd->fk_i_actor_user_id) {
                        $request->push(RequestClass::where('fk_i_user_id', $dd->fk_i_actor_user_id)->with(['status','service','user'])->get());
                        $myId = $dd->fk_i_actor_user_id;
                    }
                }
                $requests = $request[0];

            } else if ($user->userRule->s_name_en == 'ServiceProviderUser') {

              $requests =  RequestClass::where('fk_i_user_id', $user_id)->with(['status','service','user'])->get();

            }

            return Datatables::of($requests)->addColumn('full_name', function ($row) {
                return $row->user->s_first_name . ' ' . $row->user->s_last_name;
            })->make(true);
        }
        if ($model == 'getRequest') {
            
            $user_id = session('user_id');
            $data = RequestClass::where('fk_i_user_id', $user_id)->with(['status','service','user'])->get();

            return Datatables::of($data)->make(true);
        }
      


        $modelName = '\App' . '\\' . $model;
        $class = new $modelName();

        $notifications = $class::orderBy('dt_created_date', 'desc')->get();
        return Datatables::of($notifications)
            ->make(true);

    }

}
