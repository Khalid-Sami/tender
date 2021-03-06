<?php

namespace App\Http\Controllers;

use App\ConstantView;
use Validator;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //


    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
//        $this->middleware(['locale']);
//
        $this->middleware(['is.login', 'locale']);

    }

    public function index()
    {
        $data['user'] = User::where('pk_i_id', session('user_id'))->first();
        $data['gender'] = ConstantView::getIdNameData('USERS_GENDERS');
        $data['country'] = ConstantView::getIdNameData('COUNTRIES');
        return view('user.profile', $data);
    }

    public function updatePersonalInfo(Request $request, $id)
    {

        if ($request->ajax()) {
            $method = $request->input('method');
            $pk_i_id = $request->input('id');
            $data = ConstantView::where('fk_i_parent_id', $pk_i_id)->get(['s_name', 'pk_i_id']);
            $u_id = $request->input('u_id');
            if ($method == 'getCity'){
                $option_id = User::where('pk_i_id',$u_id)->first(['i_city_id'])->i_city_id;
                $view = view('user.ajax.get_options_data', compact('data','option_id'))->render();
            }
            if ($method == 'getDistrict'){
                $option_id = User::where('pk_i_id',$u_id)->first(['i_district_id'])->i_district_id;
                $view = view('user.ajax.get_options_data', compact('data','option_id'))->render();
            }
            return response()->json(['view' => $view]);
        }

        $validator = Validator::make($request->all(), [
            's_first_name' => 'required',
            's_last_name' => 'required',
            's_mobile_number' => 'required|numeric',
            'dt_birth_date' => 'required',
            'fk_i_gender_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error_msg', trans('lang.error_msg'))
                ->withInput();
        }
        $table = [
            's_first_name' => $request->input('s_first_name'),
            's_last_name' => $request->input('s_last_name'),
            's_mobile_number' => $request->input('s_mobile_number'),
            'dt_birth_date' => !empty($request->input('dt_birth_date')) ? $request->input('dt_birth_date') : null,
            'i_city_id' => !empty($request->input('city')) ? $request->input('city') : null,
            'fk_i_gender_id' => !empty($request->input('fk_i_gender_id')) ? $request->input('fk_i_gender_id') : null,
            'i_country_id' => !empty($request->input('i_country_id')) ? $request->input('i_country_id') : null,
            'i_district_id' => !empty($request->input('district')) ? $request->input('district') : null,
            's_address' => !empty($request->input('s_address')) ? $request->input('s_address') : null,
            'dt_modified_date'=> date('Y-m-d H:i:s')
        ];
        User::where('pk_i_id', $id)->update($table);
        return back()->with([
            'msg' => trans('lang.updated'),
            'tab1_state' => 'active'
        ]);

    }


    public function changePicture(Request $request, $id)
    {

        if($request->ajax()){
            $user = User::where('pk_i_id',$id)->first(['s_pic']);
            if(isset($user->s_pic) && !empty($user->s_pic)){
                $image = $user->s_pic;
                unlink('images/users_images/'.$image);
                User::where('pk_i_id',$id)->update(['s_pic'=>null]);
            }
            return response()->json(['status'=>1]);


        }

        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with(['error_msg'=>trans('lang.error_msg'), 'tab2_state' => 'active'])
                ->withInput();
        }


        if ($file = $request->file('file')) {
            $image_name = time().$file->getClientOriginalName();
            $file->move('images/users_images', $image_name);
            User::where('pk_i_id', $id)->update(['s_pic' => $image_name, 'dt_modified_date'=> date('Y-m-d H:i:s')]);

            return back()->with([
                'msg' => trans('lang.updated'),
                'tab2_state' => 'active'
            ]);
        }
        return back();
    }

    public function changePassword(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|same:confirm|min:6',
            'confirm' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with(['error_msg'=>trans('lang.error_msg'), 'tab3_state' => 'active'])
                ->withInput();
        }


        $password = User::where('pk_i_id', $id)->first(['s_password']);
        if ($password->s_password) {
            if ($password->s_password == md5($request->input('password'))) {
                User::where('pk_i_id', $id)->update(['s_password' => md5($request->input('new_password')), 'dt_modified_date'=> date('Y-m-d H:i:s')]);
                return back()->with([
                    'msg' =>trans('lang.password_change'),
                    'tab3_state' => 'active'
                ]);
            }
        }
        return back()->with([
            'error_msg' =>trans('lang.password_wrong'),
            'tab3_state' => 'active'
        ]);
    }

    public function addUserLocation(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'lng' => 'required',
            'lat' => 'required'
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with(['error_msg'=>trans('lang.error_msg'), 'tab4_state' => 'active'])
                ->withInput();
        }

        User::where('pk_i_id',$id)->update([
            'd_longitude'=> $request->input('lng'),
            'd_latitude'=> $request->input('lat'),
            'dt_modified_date'=> date('Y-m-d H:i:s')

        ]);
        return back()->with([
            'msg' =>trans('lang.updated'),
            'tab4_state' => 'active'
        ]);

    }

    public function getUser($id)
    {

        //
        $data['user'] = User::where('pk_i_id', $id)->first();
        $data['gender'] = ConstantView::getIdNameData('USERS_GENDERS');
        $data['country'] = ConstantView::getIdNameData('COUNTRIES');
        return view('user.profile', $data);
    }
}
