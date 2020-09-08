<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\DB;
use App\ServiceProviderView;
use App\Setting;
use App\SPServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

//php artisan krlove:generate:model Constant --table-name=t_constant
// OAuth Routes 
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.login');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

//End OAuth Routes


Route::get('/language/change/{language}', function ($language) {
    session(['lang' => $language]);
    \App\User::where(['pk_i_id' => session('user_id')])->update(['s_default_language' => $language]);
    return back();
})->name('language.change');


// Admin Operation goes here
Route::get('/admin/systemSettings', 'AdminController@systemSettings');
Route::post('/admin/storeSystemSettings', 'AdminController@storeSystemSettings');
Route::get('/admin/notifications/sendNotifications','AdminController@sendNotifications')->name('admin.notifications.send');
Route::post('/admin/notifications/storeNotifications','AdminController@storeNotifications');
Route::post('/admin/notifications/updateNotifications','AdminController@updateNotifications');
Route::post('/admin/getNotifications','AdminController@getAllNotifications')->name('notification.get');// set

Route::get('/admin/constant', 'AdminController@showConstant');
Route::post('/admin/storeConstant', 'AdminController@storeConstant');
Route::patch('/admin/updateConstant', 'AdminController@updateConstant');
Route::get('/admin/{table}/{key}/getTableData', 'AdminController@getTableData')->name('constant.get');
Route::get('/admin/{country}/city', 'AdminController@showCity');
Route::get('/admin/{city}/district', 'AdminController@showDistrict');
Route::get('/admin/subscriptions/subscribePlan', 'AdminController@subscribePlan');
Route::get('/admin/subscriptions/{package}/getSubscribePlan', 'AdminController@getSubscribePlan')->name('admin.subscribe.plan.get');
Route::patch('/admin/subscriptions/updateSubscribePlan', 'AdminController@updateSubscribePlan');
Route::get('/admin/subscriptions/createSubscribePlan', 'AdminController@createSubscribePlan');
Route::post('/admin/subscriptions/storeSubscribePlan', 'AdminController@storeSubscribePlan');
Route::get('/admin/serviceProvider/show', 'AdminController@serviceProvider');
Route::get('/admin/{serviceProvider}/users', 'AdminController@showUsers');
Route::get('/admin/users/show', 'AdminController@showAllUsers');
Route::get('/admin/serviceProvider/{serviceProvider}/getProfile', 'AdminController@serviceProviderProfile');
Route::post('/admin/subscription/changeSubscriptionPackage', 'AdminController@changeSubscriptionPackage');
Route::post('/admin/{user}/changeStatus', 'AdminController@changeStatus');
Route::get('/addCategory', 'admin\CategoryController@index');
Route::post('/saveCategory', ['as' => 'saveCategory', 'uses' => 'admin\CategoryController@storeCategory']);
Route::get('/category', ['as' => 'showCategories', 'uses' => 'admin\CategoryController@index']);
Route::get('/ajax/getCategory/', ['as' => 'ajaxCategory', 'uses' => 'admin\CategoryController@getCategory']);
Route::get('/ajax/getCategoryInfo', ['as' => 'ajax/getCategoryInfo', 'uses' => 'admin\CategoryController@getCategoryInfo']);
Route::post('/ajax/removeCategory', ['as' => 'ajax/removeCategory', 'uses' => 'admin\CategoryController@removeCategory']);
Route::post('/ajax/addCategory', ['as' => 'ajax/addCategory', 'uses' => 'admin\CategoryController@addCategoryAjax']);
Route::post('/ajax/getSingleCategory', ['as' => 'ajax/getSingleCategory', 'uses' => 'admin\CategoryController@getSingleCategory']);
Route::post('/ajax/editCategory', ['as' => 'ajax/editCategory', 'uses' => 'admin\CategoryController@editCategory']);
Route::get('/addService', ['as' => 'addService', 'uses' => 'admin\ServiceController@showAddServicePage']);
Route::post('/saveService', ['as' => 'saveService', 'uses' => 'admin\ServiceController@store']);
Route::post('/ajax/saveService', ['as' => 'ajax/saveService', 'uses' => 'admin\ServiceController@storeAjax']);
Route::get('/services', ['as' => 'services', 'uses' => 'admin\ServiceController@index']);
Route::get('/ajax/getCategoryService', ['as' => 'ajax/getCategoryService', 'uses' => 'admin\ServiceController@getServices']);
Route::get('/ajax/getSingleService', ['as' => 'ajax/getSingleService', 'uses' => 'admin\ServiceController@getSingleService']);
Route::get('/ajax/getCategoryOfService', ['as' => 'ajax/getCategoryOfService', 'uses' => 'admin\ServiceController@getCategoryOfService']);
Route::post('/ajax/updateService', ['as' => 'ajax/updateService', 'uses' => 'admin\ServiceController@update']);
Route::get('/ajax/deleteService', ['as' => 'ajax/deleteService', 'uses' => 'admin\ServiceController@delete']);
Route::post('/ajax/saveQuestion', ['as' => 'ajax/saveQuestion', 'uses' => 'admin\QuestionController@store']);
Route::get('/questions', ['as' => 'questions', 'uses' => 'admin\QuestionController@showQuestionPage']);
Route::get('/ajax/fillQuestions', ['as' => 'ajax/fillQuestions', 'uses' => 'admin\QuestionController@fillDataTable']);
Route::post('/ajax/deleteQuestion', ['as' => 'ajax/deleteQuestion', 'uses' => 'admin\QuestionController@delete']);
Route::post('/ajax/getQuestion', ['as' => 'ajax/getQuestion', 'uses' => 'admin\QuestionController@getQuestion']);
Route::post('/ajax/updateQuestion', ['as' => 'ajax/updateQuestion', 'uses' => 'admin\QuestionController@update']);
Route::post('/ajax/addOption', ['as' => 'ajax/addOption', 'uses' => 'admin\OptionController@store']);
Route::get('/serviceInfo', ['as' => 'serviceInfo', 'uses' => 'admin\ServiceController@showServiceInfoPage']);
Route::post('/ajax/getOptions', ['as' => 'ajax/getOptions', 'uses' => 'admin\OptionController@getOption']);
Route::get('/admin/service/update', ['as' => 'admin.service', 'uses' => 'admin\ServiceProviderController@index']);
Route::get('/admin/service/{provider}/update', ['as' => 'admin.service.update', 'uses' => 'admin\ServiceProviderController@getServiceData']);
Route::get('/admin/{service}/addQuestion', ['as' => 'admin.add.question', 'uses' => 'admin\QuestionController@index']);


// MainController
Route::get('/main', 'MainController@index')->name('user.main');
Route::get('/clinic/getNotifications', 'MainController@getNotifications')->name('notifications.get');
Route::get('/admin/{table}/getTableData', 'MainController@getTableData')->name('table.get');
//END MainController

Route::get('/', ['as' => 'main', function () {
    return view('login');
}]);


//LoginController
Route::get('/login', 'LoginController@login');
Route::get('/login/check', 'LoginController@check');
Route::get('/restore', 'LoginController@restore');
Route::get('/participation', 'LoginController@participation');
Route::get('/participation/create', 'RegisterController@createServiceProvider');
Route::post('/participation/store', 'RegisterController@storeServiceProvider');
Route::get('/register', 'LoginController@register');
Route::get('/participation', 'LoginController@participation');
Route::get('/login/create', 'LoginController@create')->name('login.create');
Route::post('/login/check', 'LoginController@check');
Route::get('/logout', 'LoginController@logout')->name('logout');
//End LoginController


//RegisterController
Route::post('/register/store', 'RegisterController@store');
//End RegisterController

//ServiceProviderController
Route::get('/serviceProvider/profile', 'ServiceProviderController@serviceProviderProfile');
Route::patch('/serviceProvider/{provider}/updateSPInformation', 'ServiceProviderController@updateSPInformation');
Route::patch('/serviceProvider/{provider}/updateSPCities', 'ServiceProviderController@updateSPCities');
Route::patch('/serviceProvider/{provider}/updateSPLocation', 'ServiceProviderController@updateSPLocation');
Route::post('/serviceProvider/{provider}/storeTimeOfWork', 'ServiceProviderController@storeTimeOfWork');
Route::patch('/serviceProvider/{provider}/updateSPAdditionalInfo', 'ServiceProviderController@updateSPAdditionalInfo');
Route::get('/serviceProvider/services/show', 'ServiceProviderController@showServices');
Route::post('/serviceProvider/services/add', 'ServiceProviderController@addServices');
Route::get('/serviceProvider/requests/show', 'ServiceProviderController@showRequests')->name('requests.show');
Route::get('/user/quotations/show', 'ServiceProviderController@showQuotations')->name('quotations.show');
Route::get('/user/quotations/{request}/show', 'ServiceProviderController@showAllQuotations')->name('quotations.show.all');
Route::get('/user/quotations/{quotation}/modal/show', 'ServiceProviderController@showModalQuotations')->name('user.quotation.show');



Route::get('/user/conversation', "ServiceProviderController@messageIndex");
Route::get('/user/{provider}/conversation', "ServiceProviderController@messageIndex1")->name('message.show');
Route::post('/sendMessage', "ServiceProviderController@sendMessage");
Route::post('/checkCountM', "ServiceProviderController@checkCountM");
Route::post('/getPreviousMessages', "ServiceProviderController@getPreviousMessages");
Route::post('/getPreviousMessagesFromSelect', "ServiceProviderController@getPreviousMessagesFromSelect");
Route::get('/search', "ServiceProviderController@search");
Route::post('/getConversations', "ServiceProviderController@getConversations");

//End ServiceProviderController

//ProfileController
Route::get('/user/accountSettings', 'ProfileController@index');
Route::patch('/user/accountSetting/{user}/change', 'ProfileController@changePicture');
Route::patch('/user/accountSetting/{user}/changePassword', 'ProfileController@changePassword');
Route::post('/user/accountSetting/{user}/addUserLocation', 'ProfileController@addUserLocation');
Route::get('/user/accountSetting/{user}/getUser', 'ProfileController@getUser')->name('user.get');
Route::patch('/user/accountSetting/{user}/updatePersonalInfo', 'ProfileController@updatePersonalInfo');
Route::patch('/user/accountSetting/{user}/change', 'ProfileController@changePicture');
Route::patch('/user/accountSetting/{user}/changePassword', 'ProfileController@changePassword');
Route::post('/user/accountSetting/{user}/addUserLocation', 'ProfileController@addUserLocation');
Route::get('/user/accountSetting/{user}/getUser', 'ProfileController@getUser');

//End ProfileController


// LandingPageController

Route::get('/home1', 'Main\LandingPageController@index')->name('home');
Route::get('/user/booking/{request}/request/show', 'Main\LandingPageController@getRequestData')->name('booking.get.data');
Route::get('/user/booking/{request}/quotation/{provider}/show', 'Main\LandingPageController@showQuotationData')->name('booking.show.data');
Route::match(['get', 'post'], '/request/{service}/getBookingData', ['as' => 'request.getBookingData', 'uses' => 'Main\LandingPageController@getBookingData']);
Route::get('/user/{request}/quotation/add', 'Main\LandingPageController@addQuotation')->name('quotation.add');
Route::post('/user/{request}/quotation/store', 'Main\LandingPageController@storeQuotation')->name('quotation.store');
Route::post('/ajax/{request}/quotation/{provider}/change', 'Main\LandingPageController@changeStatus')->name('booking.status.change');


// END LandingPageController

Route::get('ajax/getQuestionOptions' , ['as' => 'ajax/QuestionOptions','uses' =>'admin\OptionController@getQuestionOptions' ]);
Route::get('ajax/getServices' , ['as' => 'ajax/getServices','uses' =>'Main\LandingPageController@getServices' ]);
Route::get('ajax/main/category' , ['as' => 'ajax/main/category','uses' =>'Main\LandingPageController@getTheCategoryOfServiceProvider' ]);




Route::get('/test', function () {

    return session()->getToken();
//    return   $data = SPServices::where('b_approved',0)->get()->map(function ($item {
//        return $item->serviceProvider->where('i_status',18)->get();
//    });

//    $h = str_contains("1/2",['/']);
//    return $h ;
//    $c = explode('/',$h);
//    return $c[0];

});


Route::post('/client/timezone', function (Request $request) {
    session(['timezone' => $request->input('timezone')]);
//   session(['timezone' => 	'Asia/Kuala_Lumpur']);
    $date = date('Y-m-d h:i:s');
//    return response()->json([
//        'date' => $date,
//        'dateT' => Carbon::parse($date)->timezone('America/Anchorage')->toDateTimeString(),
//        'dateT1' => Carbon::parse($date)->timezone('America/Vancouver')->toDateTimeString(),
//    ]);
});
