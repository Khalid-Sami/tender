<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\ConstantView;
use App\Service;
use App\ServiceProvider;
use App\ServiceView;
use App\SPServices;
use App\SubscriptionPackageView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceProviderController extends Controller
{

    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $method = $request->input('method');
            $serviceId = $request->input('serviceId');
            $serviceProviderId = $request->input('serviceProviderId');
            if($method == 'approve'){
                SPServices::where(['fk_i_service_provider_id'=>$serviceProviderId,'fk_i_service_id'=>$serviceId])->update(['b_approved'=>1,'dt_modified_date' => Carbon::now()]);
            }
            if($method == 'reject'){
                SPServices::where(['fk_i_service_provider_id'=>$serviceProviderId,'fk_i_service_id'=>$serviceId])->update(['b_approved'=>2,'dt_modified_date' => Carbon::now()]);
            }
            return response()->json();
        }
        return view('admin.service_provider.update');
    }

    public function getServiceData(Request $request, $id)
    {
    
        $services = SPServices::where('fk_i_service_provider_id', $id)->get();
        return view('partial.iframe', compact('services'))->render();
    }


}
