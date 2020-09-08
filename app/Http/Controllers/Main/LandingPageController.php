<?php

namespace App\Http\Controllers\Main;

use App\Category;
use App\CategoryView;
use Illuminate\Support\Facades\DB;
use App\CompanyView;
use Validator;
use App\Notification;
use App\NotificationUser;
use App\RequestAttachment;
use App\RequestHistory;
use App\RequestProposedSP;
use App\RequestQuestionAnswer;
use App\RequestQuotation;
use App\RequestQuotationAttachment;
use App\Service;
use App\Request as RequestClass;
use App\ServiceProviderUser;
use App\ServiceQuestionOptions;
use App\ServiceQuestionView;
use App\SPQuestionAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{


    public $ERROR_RESPONSE = ['status' => 404, 'message' => 'Empty result'];
    public $IMAGE_PATH = '/images/';

    /**
     * LandingPageController constructor.
     */
    public function __construct()
    {
//                $this->middleware(['locale']);
//        $this->middleware(['locale']);
    }

    public function index()
    {
        $data['addresses'] = $this->getServiceProviderLocations();
        return view('main.index', $data);
    }


    // gets the first services of current address
    // unfortunately, it gets O(n^2) time
    public function getServices(Request $request)
    {
        $address = $request['body'];
        $services = $this->getServicesFromAddress($address);
        $purServices = array();
        if (empty($services))
            return response()->json(['status' => 404, 'message' => $services]);

        foreach ($services as $service) {
            foreach ($service['services'] as $tempService) {
                $temp = $tempService['service'];
                //     $temp->s_pic = $this->IMAGE_PATH . $temp->s_pic;
                array_push($purServices, $temp);
            }

        }

        return response()->json(['status' => 200, 'message' => $purServices]);
    }

    //gets the Address of Service Providers in the System
    private function getServiceProviderLocations()
    {

        return CompanyView::where('dt_deleted_date', null)->get(['s_address']);

    }

    //gets the available services according to the chosen Address
    private function getServicesFromAddress($address)
    {
        $result = CompanyView::where(['dt_deleted_date' => null, 's_address_en' => $address])->get()
            ->each(function ($item, $value) {
                return $item->services->each(function ($items, $value) {
                    return $items->service->each(function ($item, $value) {
                        return $item->where('b_enabled', '=', '1')->where('dt_deleted_date', null)->get();
                    });
                });
            });

        if ($result->count() == 0) {
            return [];
        }
        return $result;
    }

    public function getTheCategoryOfServiceProvider(Request $request)
    {
        $requiredData = ['fk_i_service_provider_id', 'fk_i_service_id', 's_company_name', 's_address', 's_name'];
        $address = $request['body'];


        //returns categoryId for Categories in the given address
        $categoryId = DB::table('t_sp_services')->where(['t_sp_services.dt_deleted_date' => null, 's_address_en' => $address])
            ->leftJoin('v_service_provider', 'v_service_provider.pk_i_id', '=', 't_sp_services.fk_i_service_provider_id')
            ->where('v_service_provider.dt_deleted_date', null)
            ->leftJoin('t_service_category', 't_sp_services.fk_i_service_id', '=', 't_service_category.fk_i_service_id')
            ->where('t_service_category.dt_deleted_date', null)
            ->leftJoin('t_category', 't_service_category.fk_i_category_id', '=', 't_category.pk_i_id')
            ->where(['t_category.dt_deleted_date' => null])->where('fk_i_category_id', '!=', null)->get(['fk_i_category_id', 's_category_name_en', 's_category_name_ar']);

        if ($categoryId->count() == 0)
            return response()->json($this->ERROR_RESPONSE);
        $services = array();
        foreach ($categoryId as $id) {
            $temp = CategoryView::find($id->fk_i_category_id)->service()->where('t_service.dt_deleted_date', null)->get();
            array_push($services, $temp);
        }
        return response()->json(['status' => 200, 'message' => $services, 'category' => $categoryId]);
//        var_dump($services);
    }

    public function getBookingData(Request $request, $id)
    {

        if ($request->ajax()) {
            $user_id = session('user_id');
            $service_id = $id;
            $description = $request->input('description');
            $quotation = $request->input('quotation_number');
            $iterate = $request->input('iterate');
            $from = $request->input('from');
            $to = $request->input('to');

            $req = $this->createRequest($user_id, $service_id, $description, $quotation, $from, $to);


            $this->createRequestHistory($req, $user_id);

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images/request_attachment', $name);
                    $this->createRequestAttachment($req, $name);
                }
            }
            $service_check_id = 0;
            for ($i = 1; $i <= $iterate; $i++) {
                if (!$request->has('text')) {
                    $this->createRequestQuestionAnswer($request, $req, $i);
                }
                $service = SPQuestionAnswer::where([
                    'fk_i_question_id' => $request->input('question' . $i),
                    'fk_i_option_id' => $request->input('option' . $i),
                ])->get();

                foreach ($service as $item) {
                    if ($item->fk_i_service_provider_id != $service_check_id) {
                        $title_ar = "هناك طلبات في قائمة الانتظار";
                        $title_en = "There are requests in the queue";
                        $i_action = 1;
                        $notification = $this->createNotification($user_id, $title_en, $title_ar, $req->pk_i_id, $i_action);
                        $service_user_id = ServiceProviderUser::where('fk_i_service_provider_id', $item->fk_i_service_provider_id)->first(['fk_i_user_id']);
                        $this->createNotificationUser($notification, $service_user_id->fk_i_user_id);

                        RequestProposedSP::firstOrCreate([
                            'fk_i_request_id' => $req->pk_i_id,
                            'fk_i_service_provider_id' => $item->fk_i_service_provider_id,
                            'i_replied' => 0,
                        ]);
                    }
                    $service_check_id = $item->fk_i_service_provider_id;
                }
            }
            if (!empty($notification->pk_i_id)) {
                RequestClass::where('pk_i_id', $req->pk_i_id)->update(['i_status' => 55, 'dt_modified_date' => Carbon::now()]);
            }

            return response()->json(['status' => '1']);
        }

        $data['booking'] = ServiceQuestionView::where(['fk_i_service_id' => $id, 'dt_deleted_date' => null])->get()->each(function ($items, $key) {
            return $items->questionOptions->where('dt_deleted_date', null);
        });
        $data['serviceId'] = $id;
        $data['serviceName'] = Service::where('pk_i_id', $id)->first(['s_service_name_en'])->s_service_name_en;
        $data['serviceDesc'] = Service::where('pk_i_id', $id)->first(['s_description_en'])->s_description_en;
        $data['user_id'] = session('user_id');
        if (!empty($data['user_id'])) {
            session(['service_id' => null, 'make_request' => null]);
            return view('main.booking.book', $data);
        }

        session(['service_id' => $id, 'make_request' => 'request']);
        return redirect('/login')->with('error_msg', 'You must login first to make request');
    }


    public function getRequestData($requestId)
    {

        $data['requests'] = RequestClass::where('pk_i_id', $requestId)->first();
        if (empty($data['requests'])) {
            return back()->with('error_msg', trans('lang.request_error'));
        }
        $data['attachment'] = RequestAttachment::where('fk_i_request_id', $requestId)->get();
        $data['requestQuestionAnswer'] = RequestQuestionAnswer::where('fk_i_request_id', $requestId)->get();
        $data['requestId'] = $requestId;
        return view('user.provider_admin.request.show', $data);
    }

    public function showQuotationData($requestId, $serviceProviderId)
    {
        $data['requestsQuotation'] = RequestQuotation::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId])->first();
        if (empty($data['requestsQuotation'])) {
            return back()->with('error_msg', trans('lang.quotation_error'));
        }

        $data['requestId'] = $requestId;
        $data['serviceProviderId'] = $serviceProviderId;
        return view('user.quotation.show', $data);
    }

    public function addQuotation($requestId)
    {

        $serviceProviderId = ServiceProviderUser::where(['fk_i_user_id' => session('user_id'), 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id']);
        $requestQuotation = RequestQuotation::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id])->first();

        if (empty($serviceProviderId)) {
            return back()->with('error_msg', trans('lang.url_error'));
        }
        $data['requestId'] = $requestId;
        if (!empty($requestQuotation)) {
            $data['request'] = $requestQuotation;
        } else {
            $data['request'] = null;
        }
        return view('user.provider_admin.quotation.create', $data);
    }

    public function changeStatus(Request $request, $requestId, $serviceProviderId)
    {
        $method = $request->input('method');
        if ($method == 'accept') {
            RequestQuotation::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId])->update(['i_status' => 65, 'dt_modified_date' => Carbon::now()]);
            RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 57, 'dt_modified_date' => Carbon::now()]);
        } else if ($method == 'reject') {
            RequestQuotation::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId])->update(['i_status' => 66, 'dt_modified_date' => Carbon::now()]);

        } else if ($method == 'cancelRequest') {
            RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 60, 'dt_modified_date' => Carbon::now()]);

        }
        return response()->json(['status' => 1]);
    }

    public function storeQuotation(Request $request, $requestId)
    {

        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error_msg', trans('lang.error_msg'))
                ->withInput();
        }

        $serviceProviderId = ServiceProviderUser::where(['fk_i_user_id' => session('user_id'), 'fk_i_role_id' => 6])->first(['fk_i_service_provider_id']);
        $requestQuotation = RequestQuotation::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id])->first();


        if (empty($requestQuotation)) {
            $quotation = $this->createRequestQuotation($request, $requestId, $serviceProviderId);
            RequestProposedSP::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id])->update(['i_replied' => 1, 'dt_replied' => Carbon::now()]);
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images/quotation_attachment', $name);
                    $this->createQuotationAttachment($quotation, $name);


                }

                $toUserId = RequestClass::where('pk_i_id', $requestId)->first(['fk_i_user_id'])->fk_i_user_id;
                $byUserId = session('user_id');
                $title_ar = "هناك عروض في قائمة الانتظار";
                $title_en = "There are quotations in the queue";
                $i_action = 2;
                $s_ids = "$requestId" . "/" . "$serviceProviderId->fk_i_service_provider_id";
                $notification = $this->createNotification($byUserId, $title_en, $title_ar, $s_ids, $i_action);
                $this->createNotificationUser($notification, $toUserId);

                RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 56, 'dt_modified_date' => Carbon::now()]);

            }
        } else {
            $quotationId = $requestQuotation->pk_i_id;
            $this->updateRequestQuotation($request, $requestId, $serviceProviderId, $quotationId);
            $quotation = RequestQuotation::where(['pk_i_id' => $quotationId])->first();
            RequestProposedSP::where(['fk_i_request_id' => $requestId, 'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id])->update(['i_replied' => 1, 'dt_replied' => Carbon::now()]);
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images/quotation_attachment', $name);
                    $this->createQuotationAttachment($quotation, $name);
                }

                $toUserId = RequestClass::where('pk_i_id', $requestId)->first(['fk_i_user_id'])->fk_i_user_id;
                $byUserId = session('user_id');
                $title_ar = "هناك عروض في قائمة الانتظار";
                $title_en = "There are quotations in the queue";
                $i_action = 2;
                $s_ids = "$requestId" . "/" . "$serviceProviderId->fk_i_service_provider_id";
                $notification = $this->createNotification($byUserId, $title_en, $title_ar, $s_ids, $i_action);
                $this->createNotificationUser($notification, $toUserId);

                RequestClass::where('pk_i_id', $requestId)->update(['i_status' => 56, 'dt_modified_date' => Carbon::now()]);

            }
        }

        return redirect()->route('requests.show')->with(['msg' => trans('lang.quotation_added')]);
    }

    /**
     * @param $user_id
     * @param $service_id
     * @param $description
     * @param $quotation
     * @param $from
     * @param $to
     * @return static
     */
    protected function createRequest($user_id, $service_id, $description, $quotation, $from, $to)
    {
        $req = RequestClass::create([
            'fk_i_user_id' => $user_id,
            'fk_i_service_id' => $service_id,
            's_description' => isset($description) ? $description : null,
            'i_quotation_no' => isset($quotation) ? $quotation : 0,
            'dt_start_time' => (isset($from) && !empty($from)) ? $from : null,
            'dt_end_time' => (isset($to) && !empty($to)) ? $to : null,
            'i_status' => 54,
            'b_enabled' => 1,
            'dt_created_date' => Carbon::now(),
        ]);
        return $req;
    }

    /**
     * @param $req
     * @param $user_id
     */
    protected function createRequestHistory($req, $user_id)
    {
        RequestHistory::create([
            'fk_i_request_id' => $req->pk_i_id,
            'fk_i_user_id' => $user_id,
            'i_status' => 54,
            'dt_created_date' => Carbon::now(),
        ]);
    }

    /**
     * @param $req
     * @param $name
     */
    protected function createRequestAttachment($req, $name)
    {
        RequestAttachment::create([
            'fk_i_request_id' => $req->pk_i_id,
            's_url' => $name,
            's_description' => null,
            'b_enabled' => 1,
            'dt_created_date' => Carbon::now(),
        ]);
    }

    /**
     * @param Request $request
     * @param $req
     * @param $i
     */
    protected function createRequestQuestionAnswer(Request $request, $req, $i)
    {
        RequestQuestionAnswer::create([
            'fk_i_request_id' => $req->pk_i_id,
            'fk_i_question_id' => $request->input('question' . $i),
            'fk_i_service_question_option_id' => $request->input('option' . $i),
            'b_enabled' => 1,
            'dt_created_date' => Carbon::now(),

        ]);
    }


    /**
     * @param $user_id
     * @param $title_en
     * @param $title_ar
     * @param $s_ids
     * @param $i_action
     * @return static
     * @internal param Request $request
     */
    protected function createNotification($user_id, $title_en, $title_ar, $s_ids, $i_action)
    {
        $notification = Notification::firstOrCreate([
            'fk_i_actor_user_id' => $user_id,
            'i_target_users_type' => 2,
            'i_title_type' => 1,
            's_title_en' => $title_en,
            's_title_ar' => $title_ar,
            'fk_i_notification_template_id' => null,
            'i_action' => $i_action,
            's_ids' => $s_ids,
            'dt_created_date' => Carbon::now()
        ]);
        return $notification;
    }

    /**
     * @param $notification
     * @param $user
     */
    protected function createNotificationUser($notification, $user_id)
    {
        NotificationUser::firstOrCreate([
            'fk_i_notification_id' => $notification->pk_i_id,
            'fk_i_user_id' => $user_id,
            'dt_created_date' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param Request $request
     * @param $quotation
     */
    protected function createQuotationAttachment($quotation, $name)
    {
        RequestQuotationAttachment::create([
            'fk_i_request_quotation_id' => $quotation->pk_i_id,
            's_url' => $name,
            'b_enabled' => 1,
            'dt_created_date' => Carbon::now(),
        ]);
    }

    /**
     * @param Request $request
     * @param $requestId
     * @param $serviceProviderId
     * @return static
     */
    protected function createRequestQuotation(Request $request, $requestId, $serviceProviderId)
    {
        $quotation = RequestQuotation::firstOrCreate([
            'fk_i_request_id' => $requestId,
            'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id,
            's_description' => $request->input('description'),
            'd_price' => $request->input('price'),
            'i_status' => 64,
            'dt_created_date' => Carbon::now(),
        ]);
        return $quotation;
    }

    protected function updateRequestQuotation(Request $request, $requestId, $serviceProviderId, $quotationId)
    {
        $quotation = RequestQuotation::where(['pk_i_id' => $quotationId])->update([
            'fk_i_request_id' => $requestId,
            'fk_i_service_provider_id' => $serviceProviderId->fk_i_service_provider_id,
            's_description' => $request->input('description'),
            'd_price' => $request->input('price'),
            'dt_modified_date' => Carbon::now(),
        ]);
        return $quotation;
    }
}
