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

Route::get('/admin/createUserAccount','AdminController@createAccount')->name('admin.create.account');
Route::post('/admin/storeUserAccount','AdminController@storeAccount')->name('admin.store.account');
Route::post('/admin/storeCompanyAccount','AdminController@storeCompanyAccount')->name('admin.store.storeCompanyAccount');

Route::patch('/admin/{itemID}/updateItemInformation', 'AdminController@updateItemInformation');
Route::post('/admin/newItem','AdminController@addNewItem')->name('admin.createNewItem');
Route::get('/admin/checkUniqueItem','AdminController@checkUniqueItem');
Route::get('/admin/checkBarcodeItem','AdminController@checkBarcodeItem');

Route::get('/admin/tenderReport','AdminController@tenderReport');
Route::get('/admin/supplierReport','AdminController@supplierReport');
Route::get('/admin/offerReport','AdminController@offerReport');
Route::get('/admin/winnerReport','AdminController@winnerReport');

Route::get('/admin/tryReport','AdminController@tryReport');
Route::get('/admin/tryPusher','AdminController@tryPusher');

Route::get('/admin/exportTenderReport/pdf/{tenderID}','AdminController@exportTenderReportPDF');
Route::get('/admin/exportSupplierReport/pdf/{supplierID}','AdminController@exportSupplierReportPDF');
Route::get('/admin/exportOfferReport/pdf/{OfferID}','AdminController@exportOfferReportPDF');
Route::get('/admin/exportWinnerReport/pdf/{fromDate}/{toDate}','AdminController@exportWinnerReportPDF');

Route::get('/admin/exportTenderReport/excel/{tenderID}','AdminController@exportTenderReportExcel');
Route::get('/admin/exportSupplierReport/excel/{supplierID}','AdminController@exportSupplierReportExcel');
Route::get('/admin/exportOfferReport/excel/{OfferID}','AdminController@exportOfferReportExcel');
Route::get('/admin/exportWinnerReport/excel/{fromDate}/{toDate}','AdminController@exportWinnerReportExcel');

Route::get('/admin/showItems', 'AdminController@showItems');

Route::get('/admin/offerStatus/{offerID}', 'AdminController@getOfferStatus');

Route::get('/serviceProvider/offerDetails/{offerID}', 'ServiceProviderController@getOfferDetails');

Route::get('/serviceProvider/offer/{operation}/{offerID}', 'ServiceProviderController@removeOrRetrieveOffer');

Route::get('/admin/{tenderProposalID}/reviewedTenderProposalPO', 'AdminController@reviewedTenderProposalPO');

Route::get('/admin/{offerID}/reviewedOfferPO', 'AdminController@reviewedOfferPO');

Route::get('/admin/{tenderID}/tenderReport', 'AdminController@getTenderReport');

Route::get('/admin/{categoryID}/supplierReport', 'AdminController@getSupplierReport');

Route::get('/admin/{offerID}/offerReport', 'AdminController@getOfferReport');

Route::get('/admin/supplier/winnerReport', 'AdminController@getWinnerReport');

Route::get('/admin/{categoryID}/getItems', 'AdminController@getItemsUnderCategory');

Route::get('/serviceProvider/{categoryID}/getItems', 'ServiceProviderController@getItemsUnderCategory');

Route::get('/ServiceProvider/auctionDetails/{auctionID}', 'ServiceProviderController@auctionDetails');

Route::get('/admin/{tenderProposal}/adoptionTenderProposal', 'AdminController@adoptionTenderProposal');

Route::get('/admin/{reverseAuctionProposal}/adoptionReverseAuctionProposal', 'AdminController@adoptionReverseAuctionProposal');

Route::get('/admin/{offerID}/adoptionOffer', 'AdminController@adoptionOffer');

Route::get('/admin/newReverseAuction', 'AdminController@newReverseAuction');

Route::get('/admin/removeItem', 'AdminController@removeItem');

Route::post('/ServiceProvider/pushAuctionPrice', 'ServiceProviderController@pushAuctionPrice');

Route::get('/admin/categoryIDSSeries/{categoryID}', 'AdminController@getCategoryIDSSeries');

Route::get('/admin/offerDetails/{offerID}', 'AdminController@getOfferDetails');

Route::get('/admin/constantManagement', 'AdminController@constantManagement');
Route::get('/admin/constantManagement/unitsItems', 'AdminController@unitsItemsManagement');
Route::get('/admin/constantManagement/itemsType', 'AdminController@itemsTypeManagement');
Route::get('/admin/constantManagement/currencies', 'AdminController@currenciesManagement');

// Admin Operation goes here
Route::get('/admin/systemSettings', 'AdminController@systemSettings');
Route::get('/admin/company/add', 'AdminController@addNewCompany');
Route::post('/admin/storeSystemSettings', 'AdminController@storeSystemSettings');
Route::get('/admin/notifications/sendNotifications','AdminController@sendNotifications')->name('admin.notifications.send');
Route::post('/admin/notifications/storeNotifications','AdminController@storeNotifications');
Route::post('/admin/notifications/updateNotifications','AdminController@updateNotifications');
Route::post('/admin/getNotifications','AdminController@getAllNotifications')->name('notification.get');// set
Route::get('/admin/quotations/{quotation}/view', 'AdminController@viewQuotations');
Route::get('/admin/statistics/{user}/show', 'AdminController@showStatistics');

Route::post('/admin/addNewTender','AdminController@addNewTender');

Route::post('/admin/newReverseAuction','AdminController@addNewReverseAuction');

Route::post('/admin/{reverseAuctionID}/editReverseAuction','AdminController@setEditReverseAuction');

Route::get('/admin/newTender','AdminController@newTender');

Route::get('/admin/constant', 'AdminController@showConstant');
Route::get('/admin/categories', 'AdminController@showCategories');
Route::get('/admin/newItem', 'AdminController@newItem');

Route::get('/admin/itemDetails', 'AdminController@getItemDetails');

Route::get('/admin/reverseAuctions', 'AdminController@reverseAuctions')->name('allAuctions');

Route::get('/ServiceProvider/reverseAuctions', 'ServiceProviderController@spReverseAuctions');
Route::get('/ServiceProvider/getReverseAuctions', 'ServiceProviderController@getSPReverseAuctions')->name('auctions.sp');

Route::get('/admin/getReverseAuctions', 'AdminController@getReverseAuctions');

Route::get('/admin/{reverseAuctionID}/reverseAuctionDetails', 'AdminController@getReverseAuctionDetails');

//Route::get('/dashboard','AdminController@getDashboard');

Route::get('/admin/{itemID}/item', 'AdminController@getItem');
Route::get('/admin/getItems', 'AdminController@getItems')->name('items.get');
Route::get('/admin/{table}/getCategories', 'AdminController@getCategories')->name('category.get');
Route::get('/admin/{providerID}/getBankAccounts', 'AdminController@getBankAccounts')->name('bankAccounts.get');

Route::get('/admin/{table}/getConstant', 'AdminController@getConstant')->name('getConstant');
Route::patch('/admin/editConstant', 'AdminController@editConstant')->name('editConstant');
Route::post('/admin/newConstant', 'AdminController@newConstant')->name('newConstant');

Route::post('/ServiceProvider/SPBidding', 'ServiceProviderController@setSPBidding');
Route::post('/ServiceProvider/{tenderProposalID}/editSPBidding', 'ServiceProviderController@editSPBidding');

Route::get('/ServiceProvider/offer/{offerID}','ServiceProviderController@getOffer')->name('offer.get');

Route::get('/ServiceProvider/tenders','ServiceProviderController@getTenders')->name('SPTenders');
Route::get('/ServiceProvider/SPTenders','ServiceProviderController@getServiceProviderTenders')->name('SPTenders.get');

Route::get('/ServiceProvider/{tenderID}/bidding','ServiceProviderController@bidding')->name('bidding');
Route::get('/ServiceProvider/{tenderID}/editBidding','ServiceProviderController@editBidding')->name('editBidding');

Route::get('/ServiceProvider/{tenderProposalID}/tenderProposalWithdrawal','ServiceProviderController@tenderProposalWithdrawal');

Route::get('/admin/{itemID}/getAllItems', 'AdminController@getAllItems');

Route::get('/admin/getAllTenders', 'AdminController@getAllTenders');
Route::get('/admin/allTenders', 'AdminController@allTenders')->name('allTenders');

Route::get('/admin/{tenderID}/tender', 'AdminController@getEditTender');
Route::post('/admin/{tenderID}/editTender', 'AdminController@setEditTender');

Route::get('/admin/allOffers', 'AdminController@getAllOffers');
Route::get('/admin/showOffers', 'AdminController@showOffers')->name('allOffers');

Route::get('/admin/tenderProposal/{tenderProposalID}', 'AdminController@getTenderProposal');

Route::get('/ServiceProvider/newOffer', 'ServiceProviderController@newOffer');
Route::get('/ServiceProvider/allOffers', 'ServiceProviderController@getAllOffers')->name('allOffers.sp');

Route::get('/ServiceProvider/offers', 'ServiceProviderController@getCompanyOffers')->name('companyOffers.get');

Route::post('/serviceProvider/newOffer', 'ServiceProviderController@addNewOffer');

Route::get('/ServiceProvider/showTenderProposalOffer/{tenderProposalID}', 'ServiceProviderController@showTenderProposalOffer');


Route::get('/admin/tenderProposals/{tenderID}/pricesOffers', 'AdminController@allTenderProposalsPricesOffers')->name('reviewedPricesOffer');

Route::get('/admin/reverseAuction/{auctionID}/pricesOffers', 'AdminController@allReverseAuctionProposalsPricesOffers');

Route::get('/admin/showPricesOffer/{tenderID}', 'AdminController@getPricesOfferDetails');

//Route::get('/admin/checkAttachment', 'AdminController@checkAttachment');

Route::get('/admin/{tenderID}/pricesOffers', 'AdminController@getPricesOffers');

Route::get('/admin/{categoryID}/getAllCategories', 'AdminController@getAllCategories');
Route::get('/{subcategoryid}/removeCompanySubCategories','ServiceProviderController@removeCompanySubCategories');
Route::get('/{tenderProposalID}/removeTenderProposalFile','ServiceProviderController@removeTenderProposalFile');

Route::post('ServiceProvider/editOffer/{offerID}','ServiceProviderController@editOffer');

Route::get('/{subcategoryid}/insertCompanySubCategories','ServiceProviderController@insertCompanySubCategories');
Route::get('/{categoryid}/getSubCategories','ServiceProviderController@getSubCategories');
Route::get('/admin/{categoryid}/getSubCategories','AdminController@getSubCategories');
Route::post('/serviceProvider/storeNewBankAccount', 'ServiceProviderController@storeNewBankAccount');
Route::get('/admin/{categoryID}/subCategory', 'AdminController@showSubCategories');

Route::post('/admin/storeConstant', 'AdminController@storeConstant');
Route::patch('/admin/updateConstant', 'AdminController@updateConstant');
Route::get('/admin/{table}/{key}/getTableData', 'AdminController@getTableData')->name('constant.get');
Route::get('/admin/{table}/{key}/getConstantData', 'AdminController@getConstantData')->name('constantData.get');
Route::get('/admin/{country}/city', 'AdminController@showCity');
Route::get('/admin/{city}/district', 'AdminController@showDistrict');
Route::get('/admin/subscriptions/subscribePlan', 'AdminController@subscribePlan');
Route::get('/admin/subscriptions/{package}/getSubscribePlan', 'AdminController@getSubscribePlan')->name('admin.subscribe.plan.get');
Route::patch('/admin/subscriptions/updateSubscribePlan', 'AdminController@updateSubscribePlan');
Route::get('/admin/subscriptions/createSubscribePlan', 'AdminController@createSubscribePlan');
Route::post('/admin/subscriptions/storeSubscribePlan', 'AdminController@storeSubscribePlan');
Route::get('/admin/company/show', 'AdminController@Company');
Route::get('/admin/{serviceProvider}/users', 'AdminController@showUsers');
Route::get('/admin/users/show', 'AdminController@showAllUsers');
Route::get('/admin/providers/show','AdminController@showAllProviders');
Route::get('/admin/quotations/{provider}/show', 'AdminController@showQuotations');
Route::get('/admin/serviceProvider/{serviceProvider}/getProfile', 'AdminController@companyProfile');
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
Route::get('/admin/company/update', ['as' => 'admin.company', 'uses' => 'admin\CompanyController@index']);
Route::get('/admin/company/{provider}/update', ['as' => 'admin.company.update', 'uses' => 'admin\CompanyController@getCompanyData']);
Route::get('/admin/{service}/addQuestion', ['as' => 'admin.add.question', 'uses' => 'admin\QuestionController@index']);

//chnage comapny status..
/////////////////
Route::post('/provider/changeBankAccountStatus', 'ServiceProviderController@changeBankAccountStatus');
Route::post('/admin/{user}/changeCompanyStatus', 'AdminController@changeCompanyStatus');
Route::get('/approvedAccount/{companyID}','ServiceProviderController@setApprovedAccount');
/////////////

Route::get('/getCountries','MainController@getCountries');
Route::get('/{countryID}/getCities','MainController@getCities');
Route::get('/{categoryID}/getCategories','MainController@getCategories');
// MainController
//Route::get('/main', 'MainController@index')->name('user.main');
Route::get('/main', 'MainController@getNotifications')->name('user.main');
Route::get('/admin/getNotifications', 'MainController@getNotifications')->name('notifications.get');
Route::get('/admin/{table}/getTableData', 'MainController@getTableData')->name('table.get');
Route::get('/rating/{request}/show' , 'MainController@showRating')->name('rating.show');
Route::post('/rating/{request}/store' , 'MainController@storeRating')->name('rating.store');
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
Route::get('/serviceProvider/profile', 'ServiceProviderController@serviceProviderProfile')->name('provider.profile.show');
Route::patch('/serviceProvider/{provider}/updateSPInformation', 'ServiceProviderController@updateSPInformation');
Route::patch('/serviceProvider/{provider}/updateSPBankAccountInfo', 'ServiceProviderController@updateSPBankAccountInfo');
Route::post('/serviceProvider/{provider}/insertOrUpdateCategory', 'ServiceProviderController@insertOrUpdateCategory');
Route::patch('/serviceProvider/{provider}/updateSPInformation', 'ServiceProviderController@updateSPInformation');
Route::patch('/serviceProvider/{provider}/updateSPLocation', 'ServiceProviderController@updateSPLocation');
Route::post('/serviceProvider/{provider}/storeTimeOfWork', 'ServiceProviderController@storeTimeOfWork');
Route::patch('/serviceProvider/{provider}/updateSPAdditionalInfo', 'ServiceProviderController@updateSPAdditionalInfo');
Route::get('/serviceProvider/services/show', 'ServiceProviderController@showServices');
Route::post('/serviceProvider/services/add', 'ServiceProviderController@addServices');
Route::get('/serviceProvider/users/show', 'ServiceProviderController@showAllUsers');
Route::get('/serviceProvider/requests/show', 'ServiceProviderController@showRequests')->name('requests.show');
Route::get('/user/quotations/show', 'ServiceProviderController@showQuotations')->name('quotations.show');
Route::get('/user/quotations/{request}/show', 'ServiceProviderController@showAllQuotations')->name('quotations.show.all');
Route::get('/user/quotations/{quotation}/modal/show', 'ServiceProviderController@showModalQuotations')->name('user.quotation.show');

Route::patch('/bankAccounts/updateBankAccount', 'ServiceProviderController@updateBankAccount');


Route::patch('/categories/updateCategory', 'AdminController@updateCategory');
Route::patch('/categories/updateSubCategory', 'AdminController@updateSubCategory');

Route::post('/categories/insertCategory', 'AdminController@insertCategory');
Route::post('/categories/insertSubCategory', 'AdminController@insertSubCategory');

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
 //Provider
Route::get('/provider/accountSetting/{provider}/getProvider', 'ProfileController@getProvider');
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
