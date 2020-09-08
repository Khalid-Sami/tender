<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\CategoryOfService;
use App\CategoryView;
use App\Service;
use App\ServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

class CategoryController extends Controller
{

    public $ILLEGAL_ACCESS = "Illegal Access";
    public $DONE = "Done!";
    public $DONE_JSON_MESSAGE = ['status' => 200, 'message' => 'Done'];

    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);

    }
    public function index()
    {
        return view('Category.index');
    }

    public function store(Request $request)
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


        return response()->json(['data' => $this->convertFromObjectToArray(CategoryView::where('dt_deleted_date', null)->get())]);
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
}
