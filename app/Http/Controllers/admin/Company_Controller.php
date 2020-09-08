<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Service;
use App\ServiceCategory;
use App\CategoryView;
use App\ServiceView;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\FatalErrorException;

class Company_Controller extends Controller
{

    public $IMAGE_DIRECTORY = './images/services_images';
    public $SERVICE = 'service';


    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);

    }

    public function index(Request $request)
    {
        $categoryId = $request->input('id');
        $data['categoryId'] = $categoryId;
    //    $data['category'] = CategoryView::where('pk_i_id',$categoryId)->first(['s_category'])->s_category;
        return view('Service.service',$data);
    }

    public function getServices(Request $request)
    {

//        if (!$request->ajax())
//            return 'illegal access';


        $id = intval($request['id']);
        if ($request['id'] == null || Category::find($id) == null) {
            $temp = array();
            $temp['id'] = '';
            $temp['service_name_en'] = '';
            $temp['service_name_ar'] = '';
            $temp['is_instant'] = '';
            $temp['enabled'] = '';
            $temp['buttons'] = '';
            return json_encode([]);
        }

        $service = ['data' => $this->convertFromObjectToArray(Category::find($id)->service()->where('t_service_category.dt_deleted_date', null)->get())];
        return $service;

        //  dd(Category::find($id)->service()->where('t_service.dt_deleted_date', null)->get());


    }

    private function convertFromObjectToArray($arrayOfObjects)
    {
        if ($arrayOfObjects == null)
            return [];
        $result = Array();
        foreach ($arrayOfObjects as $object) {
            $temp = array();
            $temp['id'] = $object->pk_i_id;
            $temp['service_name_en'] = $object->s_service_name_en;
            $temp['service_name_ar'] = $object->s_service_name_ar;
            $temp['is_instant'] = $object->b_is_instant;
            $temp['enabled'] = $object->b_enabled;
            $temp['buttons'] = '';
            array_push($result, $temp);
        }
        return $result;

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getRoles());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->saveInstance($request);
        return view('Service.index');


    }

    private function getRoles()
    {
        return [
            'serviceName_ar' => 'required',
            'serviceName_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'categories' => 'required',
            'emergency' => 'required|in:نعم,لا',
            'status' => 'required|in:نعم,لا',

        ];
    }

    public function showAddServicePage($id)
    {
        return view('Service.AddService');
    }

    private function saveInstance($request)
    {

        $service['s_service_name_en'] = $request->input('serviceName_en');
        $service['s_service_name_ar'] = $request->input('serviceName_ar');
        $service['s_description_en'] = $request->input('description_en');
        $service['s_description_ar'] = $request->input('description_ar');
        $service['b_is_instant'] = strcmp($request->input('emergency'), 'yes') == 0 ? 1 : 0;
        $service['b_enabled'] = strcmp($request->input('status'), 'yes') == 0 ? 1 : 0;
        $service['dt_created_date'] = Carbon::now();
        $service['dt_modified_date'] = Carbon::now();
        $serviceId = Service::create($service);
        $this->storeServiceCategory($serviceId['id'], $request->input('categories'), $serviceId['b_enabled']);

    }

    private function storeServiceCategory($serviceId, $categories, $enabled)
    {
        foreach ($categories as $key => $value) {
            echo $value;
            $categoryId = Category::where('s_category_name_ar', $value)->first(['pk_i_id']);
            $categoryOfService = new ServiceCategory();
            $categoryOfService->fk_i_category_id = $categoryId->pk_i_id;
            $categoryOfService->fk_i_service_id = $serviceId;
            $categoryOfService->b_enabled = $enabled;
            $categoryOfService->dt_created_date = Carbon::now();
            $categoryOfService->dt_modified_date = Carbon::now();
            $categoryOfService->save();
        }

    }

    public function storeAjax(Request $request)
    {

        $data = json_decode($request['body'])[0];
//        dd($data);
        $service_name_en = $data->serviceName_en;
        $service_name_ar = $data->serviceName_ar;
        $description_en = $data->description_en;
        $description_ar = $data->description_ar;
        $is_instant = $data->emergency;
        $enabled = $data->status;
        $categories = $data->categories;
        $serviceIcon = $data->serviceIcon;
        $service['s_service_name_en'] = $service_name_en;
        $service['s_service_name_ar'] = $service_name_ar;
        $service['s_description_en'] = $description_en;
        $service['s_description_ar'] = $description_ar;
        $service['b_is_instant'] = $is_instant;
        $service['b_enabled'] = $enabled;
        $service['s_icon'] = $serviceIcon;
        $service['dt_created_date'] = Carbon::now();
        $service['dt_modified_date'] = Carbon::now();
        $service['s_pic'] = $this->saveServiceImage($data->serviceImage);
//        dd($service);
        $serviceId = Service::create($service);
        $this->storeServiceCategory($serviceId['pk_i_id'], $categories, $serviceId['b_enabled']);


    }


    public function getSingleService(Request $request)
    {
        if (!$request->ajax())
            return 'illegal access';
        //  var_dump(Service::find(intval($request['body']))->categories()->where('t_service_category.dt_deleted_date', null)->get());
        return response()->json(['status' => 200,
            'service' => Service::find(intval($request['body'])),
            'serviceCategories' => Service::find(intval($request['body']))->categories()->where('t_service_category.dt_deleted_date', null)->get()]);
    }

    public function getCategoryOfService(Request $request)
    {
        return Service::find(intval($request['id']))->category;
    }

    public function update(Request $request)
    {

        $newServiceInfo = json_decode($request['body']);
        $service = Service::find(intval($newServiceInfo[0]->id));
        $service->s_service_name_en = $newServiceInfo[0]->serviceName_en;
        $service->s_service_name_ar = $newServiceInfo[0]->serviceName_ar;
        $service->s_description_en = $newServiceInfo[0]->description_en;
        $service->s_description_ar = $newServiceInfo[0]->description_ar;
        $service->b_is_instant = $newServiceInfo[0]->emergency;
        $service->b_enabled = $newServiceInfo[0]->status;
        $service->s_icon = $newServiceInfo[0]->serviceIcon;
        if ($newServiceInfo[0]->serviceImage != 'null') {
            $service->s_pic = $this->saveServiceImage($newServiceInfo[0]->serviceImage);
        }
        $service->dt_modified_date = Carbon::now();
        $service->save();


        $this->attachServiceToNewCategory($newServiceInfo[0]->categories, intval($newServiceInfo[0]->id), $newServiceInfo[0]->status);
        return response()->json(['status' => 200]);
    }

    private function attachServiceToNewCategory($categories, $id, $enabled)
    {
        $this->DetachAllConnectedCategories($id);
        $result = null;
        foreach ($categories as $category) {
            $result = ServiceCategory::firstOrCreate([
                'fk_i_category_id' => Category::where('s_category_name_ar', $category)->first(['pk_i_id'])->pk_i_id,
                'fk_i_service_id' => $id,
                'b_enabled' => $enabled]);
            $result->dt_created_date = Carbon::now();
            $result->dt_modified_date = Carbon::now();
            $result->dt_deleted_date = null;
            $result->update();

        }
        $this->addDateToRelation(Service::find($id)->categories);
    }

    public function delete(Request $request)
    {
        $id = intval($request['body']);
        $service = Service::find($id);
        $service->dt_deleted_date = Carbon::now();
        $service->update();
        $this->DetachAllConnectedCategories($id);


    }

    private function DetachAllConnectedCategories($id)
    {
        $categoriesOfService = Service::find($id)->categories;

        foreach ($categoriesOfService as $relation) {
            $categoryOfService = ServiceCategory::where(['fk_i_category_id' => $relation->pk_i_id, 'fk_i_service_id' => $id])->first();
            $categoryOfService->dt_deleted_date = Carbon::now();
            $categoryOfService->update();
        }
    }

    private function addDateToRelation($categories)
    {
        foreach ($categories as $category) {
            $category->dt_created_date = Carbon::now();
            $category->dt_modified_date = Carbon::now();
            // $category->deleted_date = null;
            $category->update();
        }
    }

    public function showServiceInfoPage(Request $request)
    {
        $id = intval($request['id']);

        $cId = $request->input('cId');
        $data['cId'] = $cId;

        $data['serviceName'] = ServiceView::find($id)->s_service;
        $data['categoryName'] = CategoryView::where('pk_i_id',$cId)->first(['s_category'])->s_category;

        $serviceInfo = [
            'service' => ServiceView::find($id),
            'servicePic' => $this->readServiceImage(ServiceView::find($id)->pic),
            'serviceCategory' => ServiceView::find($id)->categories()->where('t_service_category.dt_deleted_date', null)->get(),
            'serviceQuestion' => ServiceView::find($id)->questions()->where('dt_deleted_date', null)->get()
        ];
        return view('Service.serviceInfo',$data)->with('serviceInfo', $serviceInfo);
    }

    // image is a string with 64 based encoding
    private function saveServiceImage($image)
    {
        list($type, $image) = explode(';', $image);
        $extension = explode('/', $type)[1];
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $imageName = $this->SERVICE . "&" . Carbon::now()->secondsUntilEndOfDay() . '.' . $extension;
        file_put_contents($this->IMAGE_DIRECTORY . $imageName, $image);
        return $this->IMAGE_DIRECTORY . $imageName;
    }

    private function readServiceImage($imageName)
    {
        return $this->IMAGE_DIRECTORY . '' . $imageName;

    }
}
