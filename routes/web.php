<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

Route::group(['middleware' => 'laralum.base'], function () {

	/*
	|--------------------------------------------------------------------------
	| Add your website routes here
	|--------------------------------------------------------------------------
	|
	| The laralum.base middleware will be applied
	|
	*/

	# Welcome route
	Route::get('/', function () {
	    return view('welcome');
	});
	
	
	
	Route::get('/', 'WelcomeController@index');
	Route::post('/smsreports', 'WelcomeController@getsmsreport');

	Route::get('/privacy', 'PrivacyController@index');
    Route::get('/about', 'AboutController@index');
	Route::get('/contacts', 'ContactController@index')->name('contact_us');
    Route::get('/terms', 'TermsController@index');
    Route::get('/industries', 'IndustriesController@index');
    Route::get('/resource', 'ResourceController@index');
	Route::get('/solutions', 'SolutionController@index');
	Route::get('/solutions/{id}/{name}', 'SolutionController@getSingle');
	Route::post('/calculatePrice', 'SolutionController@calculatePrice');
	Route::post('/sendContact', 'ContactController@sendEmail')->name('send_email');
	
	Route::get('/artisan/{cmd}', function($cmd) {
    $cmd = trim(str_replace("-",":", $cmd));
    $validCommands = ['cache:clear', 'optimize', 'route:cache', 'route:clear', 'view:clear', 'config:cache'];
    if (in_array($cmd, $validCommands)) {
        Artisan::call($cmd);
        return "<h1>Ran Artisan command: {$cmd}</h1>";
    } else {
        return "<h1>Not valid Artisan command</h1>";
    }
});
	
    # Auth Route
    Auth::routes();
});

Route::group(['middleware' => ['auth', 'laralum.base']], function () {

	/*
	|--------------------------------------------------------------------------
	| Add your website routes here (users are forced to login to access those)
	|--------------------------------------------------------------------------
	|
	| The laralum.base and auth middlewares will be applied
	|
	*/

	# Default home route
	Route::get('/home', 'HomeController@index');
	
});










Route::get('/payments/razorpaycallback', 'Crm\PaymentController@razorpayCallback')->name('razorpaycallback');
Route::get('/recurringJob', 'Crm\PaymentController@recurringJob')->name('recurringJob');


/*
+---------------------------------------------------------------------------+
| Laralum Routes															|
+---------------------------------------------------------------------------+
|  _                     _													|
| | |                   | |													|
| | |     __ _ _ __ __ _| |_   _ _ __ ___									|
| | |    / _` | '__/ _` | | | | | '_ ` _ \									|
| | |___| (_| | | | (_| | | |_| | | | | | |									|
| \_____/\__,_|_|  \__,_|_|\__,_|_| |_| |_| Administration Panel			|
|																			|
+---------------------------------------------------------------------------+
|																			|
| This route group applies the "web" middleware group to every route		|
| it contains. The "web" middleware group is defined in your HTTP			|
| kernel and includes session state, CSRF protection, and more.				|
| This routes are made to manage laralum administration panel, please		|
| don't change anything unless you know what you're doing.					|
|																			|
+---------------------------------------------------------------------------+
*/

Route::group(['middleware' => ['auth', 'laralum.base'], 'as' => 'Laralum::'], function () {

	Route::get('activate/{token?}', 'Auth\ActivationController@activate')->name('activate_account');
    Route::post('activate', 'Auth\ActivationController@activateWithForm')->name('activate_form');
    Route::get('/banned', function() {
        return view('auth/banned');
    })->name('banned');

});

Route::group(['middleware' => ['laralum.base'], 'namespace' => 'Laralum', 'as' => 'Laralum::'], function () {

	# Public document downloads
	Route::get('/document/{slug}', 'DownloadsController@downloader')->name('document_downloader');
	Route::post('/document/{slug}', 'DownloadsController@download');

	# Social auth
	Route::get('/social/{provider}', 'SocialController@redirectToProvider')->name('social');
	Route::get('/social/{provider}/callback', 'SocialController@handleProviderCallback')->name('social_callback');

	# Public language changer
	Route::get('/locale/{locale}', 'LocaleController@set')->name('locale');

});

Route::group(['middleware' => ['laralum.base'], 'prefix' => 'admin', 'namespace' => 'Laralum', 'as' => 'Laralum::'], function () {

	# Public document downloads
	Route::get('/install', 'InstallerController@locale')->name('install_locale');
	Route::get('/install/{locale}', 'InstallerController@show')->name('install');
	Route::post('/install/{locale}', 'InstallerController@installConfig');
	Route::get('/install/{locale}/confirm', 'InstallerController@install')->name('install_confirm');
	
	

});

Route::group(['middleware' => ['auth', 'laralum.base', 'laralum.auth'], 'prefix' => 'sms/admin', 'namespace' => 'Laralum', 'as' => 'Laralum::'], function () {
    
	# Home Controller
    Route::get('/', 'DashboardController@index')->name('dashboard');
	
    # Users Routes
    Route::get('/users', 'UsersController@index')->name('users');

    Route::get('/users/create', 'UsersController@create')->name('users_create');
    Route::post('/users/create', 'UsersController@store');

    Route::get('/users/settings', 'UsersController@editSettings')->name('users_settings');
    Route::post('/users/settings', 'UsersController@updateSettings');

    Route::get('/users/{id}', 'UsersController@show')->name('users_profile');

	Route::get('/users/{id}/edit', 'UsersController@edit')->name('users_edit');
    Route::post('/users/{id}/edit', 'UsersController@update');

    Route::get('/users/{id}/roles', 'UsersController@editRoles')->name('users_roles');
    Route::post('/users/{id}/roles', 'UsersController@setRoles');

    Route::get('/users/{id}/delete', 'SecurityController@confirm')->name('users_delete');
    Route::post('/users/{id}/delete', 'UsersController@destroy');


    # Roles Routes
    Route::get('/roles', 'RolesController@index')->name('roles');

    Route::get('/roles/create', 'RolesController@create')->name('roles_create');
    Route::post('/roles/create', 'RolesController@store');

    Route::get('/roles/{id}', 'RolesController@show')->name('roles_show');

    Route::get('/roles/{id}/edit', 'RolesController@edit')->name('roles_edit');
    Route::post('/roles/{id}/edit', 'RolesController@update');

    Route::get('/roles/{id}/permissions', 'RolesController@editPermissions')->name('roles_permissions');
    Route::post('/roles/{id}/permissions', 'RolesController@setPermissions');

    Route::get('/roles/{id}/delete', 'SecurityController@confirm')->name('roles_delete');
    Route::post('/roles/{id}/delete', 'RolesController@destroy');


    # Permissions Routes
    Route::get('/permissions', 'PermissionsController@index')->name('permissions');

    Route::get('/permissions/create', 'PermissionsController@create')->name('permissions_create');
    Route::post('/permissions/create', 'PermissionsController@store');

    Route::get('/permissions/{id}/edit', 'PermissionsController@edit')->name('permissions_edit');
    Route::post('/permissions/{id}/edit', 'PermissionsController@update');

    Route::get('/permissions/{id}/delete', 'SecurityController@confirm')->name('permissions_delete');
    Route::post('/permissions/{id}/delete', 'PermissionsController@destroy');

	# groups Routes
	Route::get('/groups', 'GroupsController@index')->name('groups');
	Route::post('/groups/groupStore', 'GroupsController@store');
	Route::post('/groups/groupUpdate', 'GroupsController@update');
	Route::get('/groups/{id}/delete', 'SecurityController@confirm')->name('groups_delete');
	Route::post('/groups/{id}/delete', 'GroupsController@destroy');
	# groups->contacts Routes
    Route::get('/groups/{id}/contacts', 'GroupsController@contactList')->name('contacts');
	Route::post('/groups/contacts/store_contact', 'GroupsController@storeContact');
	Route::post('/groups/contacts/update_contact', 'GroupsController@contactUpdate');
	Route::post('/groups/contacts/delete_contact', 'GroupsController@contactDestroy');
	Route::post('/groups/contacts/delete_all_contact', 'GroupsController@deleteAll')->name('delete_all_contacts');
	Route::get('/groups/{group_id}/contacts/contacts_export', 'GroupsController@ContactExport')->name('contacts_export');
	Route::post('/groups/contacts/contacts_import', 'GroupsController@ContactImport')->name('contacts_import');
	
	# senderID Routes
	 Route::get('/senderid', 'SenderController@index')->name('senderid');
	 Route::post('/senderid/create', 'SenderController@store');
	 Route::post('/senderid/update', 'SenderController@Update');	 
	 Route::post('/senderid/delete', 'SenderController@senderDelete');	 
    	 
	 # Bank Details Routes
	 Route::get('/bank-details', 'BanksController@index')->name('bank');
	 Route::get('/bank-details/create', 'BanksController@create')->name('bank_create');
	 Route::post('/bank-details/create', 'BanksController@store');	
	 Route::post('/bankDeleteAction', 'BanksController@destroy');
	
	
	
	#sendsms Routes
	Route::get('/sendsms', 'SendsmsController@index')->name('sendsms');
	Route::post('/sendsms', 'SendsmsController@sendSMS');
	Route::post('/getCsvFileCountAction', 'SendsmsController@csvCount');
	
	#Reports Routes
	Route::get('/reports', 'reportsController@index')->name('reports');
	Route::get('/getreports/{id}', 'reportsController@ReportsDetails')->name('details');	
    Route::post('/reportSearchAction', 'reportsController@reportSearch');
	Route::post('/reportChangeSearchAction', 'reportsController@reportChangeSearchAction');	
	Route::post('/detailsSearchAction', 'reportsController@Search');	
	Route::post('/schreportSearchAction', 'reportsController@schReportSearch');
	Route::post('/schreportChangeSearchAction', 'reportsController@schReportChangeSearchAction');	
	Route::get('/reports/{id}', 'reportsController@downloadExcelFile')->name('excel-reports');
	
	
	#other Routes
	Route::get('/reseller-setting', 'IvrController@rSetting')->name('reSetting');
	Route::get('/my-website', 'IvrController@myWebsite')->name('mywebsite');
	
	#transaction Routes
	Route::get('/transaction', 'transactionController@index')->name('transaction');
	Route::post('/transaction', 'transactionController@search');
	#switch user Routes
	Route::get('/switch_start/{id}', 'UsersController@user_switch_start')->name('switch_start');
	Route::get('/switch_stop', 'UsersController@user_switch_stop')->name('switch_stop');
	
	#user profile routes
	Route::get('/{id}/{name}', 'UsersController@viewDetails')->name('user_details');
	Route::post('/profileStatus', 'UsersController@profileStatus');
	
	Route::post('/CRDRbalence', 'UsersController@CRDRbalence');
	
	Route::post('/updateprofile', 'UsersController@updateProfile');
	Route::post('/openidAction', 'UsersController@openidAction');
	Route::post('/changeRole', 'UsersController@changeRole');
	
	# Posts Routes
	Route::get('/posts/{id}', 'PostsController@index')->name('posts');

	Route::get('/posts/create/{id}', 'PostsController@create')->name('posts_create');
	Route::post('/posts/create/{id}', 'PostsController@store');

	Route::get('/posts/{id}/edit', 'PostsController@edit')->name('posts_edit');
	Route::post('/posts/{id}/edit', 'PostsController@update');

	Route::get('/posts/{id}/graphics', 'PostsController@graphics')->name('posts_graphics');

	Route::get('/posts/{id}/delete', 'SecurityController@confirm')->name('posts_delete');
	Route::post('/posts/{id}/delete', 'PostsController@destroy');

	# Comments Routes
	Route::post('/comments/create/{id}', 'CommentsController@create')->name('comments_create');

	Route::get('/comments/{id}/edit', 'CommentsController@edit')->name('comments_edit');
	Route::post('/comments/{id}/edit', 'CommentsController@update');

	Route::get('/comments/{id}/delete', 'SecurityController@confirm')->name('comments_delete');
	Route::post('/comments/{id}/delete', 'CommentsController@destroy');


	# Database CRUD
	Route::get('/CRUD', 'CRUDController@index')->name('CRUD');

	Route::get('/CRUD/{table}', 'CRUDController@table')->name('CRUD_table');

	Route::get('/CRUD/{table}/create', 'CRUDController@create')->name('CRUD_create');
	Route::post('/CRUD/{table}/create', 'CRUDController@createRow');

	Route::get('/CRUD/{table}/{id}', 'CRUDController@row')->name('CRUD_edit');
	Route::post('/CRUD/{table}/{id}', 'CRUDController@saveRow');

	Route::get('/CRUD/{table}/{id}/delete', 'SecurityController@confirm')->name('CRUD_delete');
	Route::post('/CRUD/{table}/{id}/delete', 'CRUDController@deleteRow');

	# API
	Route::get('/API', 'APIController@index')->name('API');
    Route::post('/keyStatus', 'APIController@keyStatus');
	Route::post('/addKey', 'APIController@addKey');
	
	
    
	
	
	# File Manager
	Route::get('/files', 'FilesController@files')->name('files');

	Route::get('/files/upload', 'FilesController@showUpload')->name('files_upload');
	Route::post('/files/upload', 'FilesController@upload');

	Route::get('/documents/{file}/create', 'DocumentsController@showCreate')->name('documents_create');
	Route::post('/documents/{file}/create', 'DocumentsController@createDocument');

	Route::get('/documents/{slug}/edit', 'DocumentsController@edit')->name('documents_edit');
	Route::post('/documents/{slug}/edit', 'DocumentsController@update');

	Route::get('/documents/{slug}/delete', 'SecurityController@confirm')->name('documents_delete');
	Route::post('/documents/{slug}/delete', 'DocumentsController@delete');

	Route::get('/files/{file}/delete', 'SecurityController@confirm')->name('files_delete');
	Route::post('/files/{file}/delete', 'FilesController@delete');

	Route::get('/files/{file}/download', 'FilesController@fileDownload')->name('files_download');

	# Settings
	Route::get('/settings', 'SettingsController@edit')->name('settings');
	Route::post('/settings', 'SettingsController@update');

	# Profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::post('/generalData', 'ProfileController@generalData');
	Route::post('/billingData', 'ProfileController@billingData');
	Route::post('/accountData', 'ProfileController@accountData');
	Route::post('/changePassword', 'ProfileController@changePassword');

	# About
    Route::get('/about', 'AboutController@index')->name('about');
	
	#Buy credit
     Route::get('/buy', 'BuyCreditController@index')->name('buy');
	 Route::post('/buy', 'BuyCreditController@store');
	 # Receipt List
	 Route::get('/receipt', 'ReceiptController@index')->name('receipt');
	

});
# console pages route
Route::group(['middleware' => ['auth', 'laralum.base', 'laralum.auth'], 'prefix' => 'console', 'namespace' => 'Console', 'as' => 'console::'], function (){

    Route::get('/', 'ConsoleController@index')->name('console');

	
	# Manage Routes
	Route::get('/manage', 'ManageController@index')->name('manage_module');
	
	#Enquiry Routes
	Route::get('/manage/enquiry', 'EnquiryController@index')->name('enquiry');
	Route::get('/manage/enquiry/{id}', 'EnquiryController@show')->name('enquiry_details');
	
	# Testimonials Routes
    Route::get('/manage/testimonial', 'TestimonialsController@index')->name('testimonials');
    Route::get('/manage/testimonial/create', 'TestimonialsController@create')->name('testimonial_create');
    Route::post('/manage/testimonial/create', 'TestimonialsController@store')->name('testimonial_save');  
    Route::get('/manage/testimonial/{id}/edit', 'TestimonialsController@edit')->name('testimonial_edit');
    Route::post('/manage/testimonial/{id}/edit', 'TestimonialsController@update')->name('testimonial_update');
    Route::post('/delete_testimonial', 'TestimonialsController@destroy')->name('testimonial_delete');
	
	#Getways Routes
	Route::get('/manage/gateways', 'GetwayController@index')->name('getway');
	Route::get('/manage/gateways/create', 'GetwayController@create')->name('gateways_create');
	Route::post('/manage/gateways/create', 'GetwayController@store');	
	Route::get('/manage/gateways/{id}/edit', 'GetwayController@edit')->name('gateways_edit');
	Route::post('/manage/gateways/{id}/edit', 'GetwayController@update');	
	Route::post('/manage/getwayDeleteAction', 'GetwayController@destroy')->name('gateways_delete');	
	Route::get('/manage/gateways/{id}/{type}/setDefault', 'GetwayController@setDefault')->name('setDefault');
	
	
	#sender Routes
	Route::get('/manage/sender', 'SenderController@index')->name('sender');
	Route::post('/senderNameApproved', 'SenderController@Approve')->name('approve_sender');
	Route::post('/senderNameReject', 'SenderController@Reject')->name('reject_sender');
	
	
	# kyc Routes
    Route::get('/manage/kyc', 'KycController@index')->name('kyc'); 
    Route::get('/manage/kyc/{id}/edit', 'KycController@edit')->name('kyc_edit');
    Route::post('/manage/kyc/{id}/edit', 'KycController@update')->name('kyc_update');
	
	# Industries Routes
    Route::get('/manage/industries', 'IndustriesController@index')->name('industries');
    Route::get('/manage/industries/create', 'IndustriesController@create')->name('industries_create');
    Route::post('/manage/industries/create', 'IndustriesController@store')->name('industries_save');  
    Route::get('/manage/industries/{id}/edit', 'IndustriesController@edit')->name('industries_edit');
    Route::post('/manage/industries/{id}/edit', 'IndustriesController@update')->name('industries_update');
    Route::post('/delete_industries', 'IndustriesController@destroy')->name('industries_delete');
	
	#Pricing Routes
    Route::get('/manage/pricing', 'PricingController@index')->name('pricing');
    Route::get('/manage/pricing/create', 'PricingController@create')->name('pricing_create');
    Route::post('/manage/pricing/create', 'PricingController@store')->name('pricing_save');  
    Route::get('/manage/pricing/{id}/edit', 'PricingController@edit')->name('pricing_edit');
    Route::post('/manage/pricing/{id}/edit', 'PricingController@update')->name('pricing_update');
    Route::post('/delete_pricing', 'PricingController@destroy')->name('pricing_delete');
	
	# Banners Routes
    Route::get('/manage/banners', 'BannersController@index')->name('banners');
    Route::get('/manage/banner/create', 'BannersController@create')->name('banner_create');
    Route::post('/manage/banner/create', 'BannersController@store')->name('banner_save');  
    Route::get('/manage/banner/{id}/edit', 'BannersController@edit')->name('banner_edit');
    Route::post('/manage/banner/{id}/edit', 'BannersController@update')->name('banner_update');
    Route::post('/delete_banner', 'BannersController@destroy')->name('banner_delete');
	
	# Products Routes
    Route::get('/manage/products', 'ProductController@index')->name('products');
    Route::get('/manage/product/create', 'ProductController@create')->name('product_create');
    Route::post('/manage/product/create', 'ProductController@store')->name('product_save');  
    Route::get('/manage/product/{id}/edit', 'ProductController@edit')->name('product_edit');
    Route::post('/manage/product/{id}/edit', 'ProductController@update')->name('product_update');
    Route::post('/delete_product', 'ProductController@destroy')->name('product_delete');
	
	# Pages Routes
    Route::get('/manage/pages', 'PageController@index')->name('pages');
    Route::get('/manage/page/create', 'PageController@create')->name('page_create');
    Route::post('/manage/page/create', 'PageController@store')->name('page_save');  
    Route::get('/manage/page/{id}/edit', 'PageController@edit')->name('page_edit');
    Route::post('/manage/page/{id}/edit', 'PageController@update')->name('page_update');
	
	 # Roles Routes
    Route::get('/manage/roles', 'RolesController@index')->name('roles');
    Route::get('/manage/roles/create', 'RolesController@create')->name('roles_create');
    Route::post('/manage/roles/create', 'RolesController@store');
    Route::get('/manage/roles/{id}', 'RolesController@show')->name('roles_show');
    Route::get('/manage/roles/{id}/edit', 'RolesController@edit')->name('roles_edit');
    Route::post('/manage/roles/{id}/edit', 'RolesController@update');
    Route::get('/manage/roles/{id}/permissions', 'RolesController@editPermissions')->name('roles_permissions');
    Route::post('/manage/roles/{id}/permissions', 'RolesController@setPermissions');
    Route::get('/manage/roles/{id}/delete', 'SecurityController@confirm')->name('roles_delete');
    Route::post('/manage/roles/{id}/delete', 'RolesController@destroy');
	
	# Permissions Routes
    Route::get('/manage/permissions', 'PermissionsController@index')->name('permissions');
    Route::get('/manage/permissions/create', 'PermissionsController@create')->name('permissions_create');
    Route::post('/manage/permissions/create', 'PermissionsController@store');
    Route::get('/manage/permissions/{id}/edit', 'PermissionsController@edit')->name('permissions_edit');
    Route::post('/manage/permissions/{id}/edit', 'PermissionsController@update');
    Route::get('/manage/permissions/{id}/delete', 'SecurityController@confirm')->name('permissions_delete');
    Route::post('/manage/permissions/{id}/delete', 'PermissionsController@destroy');
	
	# Users Routes
    Route::get('/manage/users', 'UsersController@index')->name('users');
    Route::get('/manage/users/create', 'UsersController@create')->name('users_create');
    Route::post('/manage/users/create', 'UsersController@store');
    Route::get('/manage/users/settings', 'UsersController@editSettings')->name('users_settings');
    Route::post('/manage/users/settings', 'UsersController@updateSettings');
    Route::get('/manage/users/{id}', 'UsersController@show')->name('users_profile');
	Route::get('/manage/users/{id}/edit', 'UsersController@edit')->name('users_edit');
    Route::post('/manage/users/{id}/edit', 'UsersController@update');
    Route::get('/manage/users/{id}/roles', 'UsersController@editRoles')->name('users_roles');
    Route::post('/manage/users/{id}/roles', 'UsersController@setRoles');
    Route::get('/manage/users/{id}/delete', 'SecurityController@confirm')->name('users_delete');
    Route::post('/manage/users/{id}/delete', 'UsersController@destroy');
	
	#logged-in user Profile update
    Route::get('/manage/profile', 'ProfileController@index')->name('profile');
	Route::get('/manage/profiles/staff/{id}', 'ProfileController@showStaff')->name('staff_profile');
	Route::get('/manage/profiles/role_staff/{id}', 'ProfileController@showRoleUser')->name('role_staff');




	Route::post('/manage/generalData', 'ProfileController@generalData');
	Route::post('/manage/organizationData', 'ProfileController@orgData');
	Route::post('/manage/branchData', 'ProfileController@branchData');
	Route::post('/manage/memberData', 'ProfileController@memberData');
	Route::post('/manage/donationData', 'ProfileController@donationData');
	Route::post('/manage/updateMemberData', 'ProfileController@updateMemberData');
	Route::post('/manage/updateDonationData', 'ProfileController@updateDonationData');
	Route::post('/manage/updateBranchData', 'ProfileController@updateBranchData');
	Route::post('/manage/departmentData', 'ProfileController@departmentData');
	Route::post('/manage/requestData', 'ProfileController@requestData');
	Route::post('/manage/updateDepartmentData', 'ProfileController@updateDepartmentData');
	Route::post('/manage/insertDonationpurpose', 'ProfileController@insertDonationpurpose');
	Route::post('/manage/updateRequestData', 'ProfileController@updateRequestData');
	Route::post('/manage/callPurposeData', 'ProfileController@callPurposeData');

	Route::post('/manage/delDepartmentBranchData', 'ProfileController@delDepartmentBranchData');
	Route::post('/manage/bankDetailsData', 'ProfileController@bankDetailsData');
	Route::post('/manage/razorPayData', 'ProfileController@razorPayData');
	Route::post('/manage/createStaffData', 'ProfileController@createStaffData');
	Route::post('/manage/updateStaffData', 'ProfileController@updateStaffData');
	Route::post('/manage/callingAccess', 'ProfileController@callingAccess');
	Route::post('/manage/changePassword', 'ProfileController@changePassword');
	Route::post('/manage/timeSlotData', 'ProfileController@timeSlotData');
	Route::post('/manage/updateTimeSlotData', 'ProfileController@UpdateTimeSlotData');
	#staff data faruk
	Route::post('/manage/hireOfSource', 'ProfileController@hireOfSource');
	Route::post('/manage/workStatusAdd', 'ProfileController@workStatusAdd');
	Route::post('/manage/staffTypeAdd', 'ProfileController@staffTypeAdd');
	Route::post('/manage/designationAdd', 'ProfileController@designationAdd');
	Route::post('/manage/workLocationAdd', 'ProfileController@workLocationAdd');
	#switch user Routes
	Route::get('/switch_start/{id}', 'UsersController@user_switch_start')->name('switch_start');
	Route::get('/switch_stop', 'UsersController@user_switch_stop')->name('switch_stop');
	
	#user profile routes
	Route::get('/{id}/{name}', 'UsersController@viewDetails')->name('user_details');
	Route::post('/manage/profileStatus', 'UsersController@profileStatus');	
	Route::post('/manage/CRDRbalence', 'UsersController@CRDRbalence');	
	Route::post('/manage/updateprofile', 'UsersController@updateProfile');
	Route::post('/manage/openidAction', 'UsersController@openidAction');
	Route::post('/manage/switchGateway', 'UsersController@switchGateway');
	Route::post('/manage/changeRole', 'UsersController@changeRole');
	Route::post('/manage/update_sms_fields_data', 'ProfileController@updateSMSFieldData')->name('save_note');
	#vikash 03.04.2021

	Route::post('/manage/preferredLanguageData', 'ProfileController@preferredLanguageAdd');
	Route::post('/manage/leadResponseData', 'ProfileController@leadResponseAdd');
	Route::post('/manage/leadStatusData', 'ProfileController@leadStatusAdd');	 	    
});

# IVR pages route
Route::group(['middleware' => ['auth', 'laralum.base', 'laralum.auth'], 'prefix' => 'ivr/admin', 'namespace' => 'Ivr', 'as' => 'Ivr::'], function (){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/followup', 'FollowupController@index')->name('followup');
    Route::get('/logs', 'LogsController@index')->name('logs');
	Route::get('/call-flow', 'CallFlowController@index')->name('call-flow');
    Route::get('/call-flow/create', 'CallFlowController@CreateCallFlow')->name('create-call-flow');
    Route::get('/call-flow/preview', 'CallFlowController@PreviewCallFlow')->name('preview-call-flow');
    Route::get('/call-flow/audio-library', 'CallFlowController@AudioLibrary')->name('audio-library');
    Route::get('/reports', 'ReportsController@index')->name('reports');
    Route::get('/remarketing', 'RemarketingController@index')->name('remarketing');
    Route::get('/manage', 'ManageController@index')->name('manage');
    Route::get('/complete-setup', 'CompleteSetupController@index')->name('complete_setup');
	Route::post('/get-cities-by-state', 'CompleteSetupController@getCity')->name('get-cities-by-state');
    Route::post('/kyc_store', 'CompleteSetupController@kycStore')->name('kyc_store');
    Route::post('/agent_store', 'CompleteSetupController@agentStore')->name('agent_store');
	Route::post('/dept_store', 'CompleteSetupController@departmentStore')->name('dept_store');

	

});

# CRM pages route
Route::group(['middleware' => ['auth', 'laralum.base', 'laralum.auth'], 'prefix' => 'crm/admin', 'namespace' => 'Crm', 'as' => 'Crm::'], function (){

	//vikash 5.8.2021
	Route::get('/department', 'DepartmentsController@index')->name('department');
	Route::post('/department/datatable', 'DepartmentsController@get_department_data')->name('get.department.data');
	Route::get('/department/create', 'DepartmentsController@create')->name('department_create');
	Route::post('/department/create', 'DepartmentsController@store')->name('department_store');
	Route::get('/department/{id}/edit', 'DepartmentsController@edit')->name('department_edit');
	Route::post('/department/update', 'DepartmentsController@update')->name('department_update');
	Route::get('/delete_department', 'DepartmentsController@destroy')->name('delete_department');

	Route::get('/attendance', 'AttendanceController@index')->name('attendance');
	Route::get('/attendance/summary', 'AttendanceController@summary')->name('attendance.summary');
	Route::post('/attendance/summaryData', 'AttendanceController@summaryData')->name('attendance.summaryData');

	Route::post('/attendance/refresh-count/{startDate?}/{endDate?}/{userId?}', 'AttendanceController@refreshCount')->name('attendance.refreshCount');
	Route::post('/attendance/employeeData/{startDate?}/{endDate?}/{userId?}', 'AttendanceController@employeeData')->name('attendance.employeeData');


	Route::get('/attendance/{id}/delete', 'AttendanceController@destroy')->name('delete_attendance');
	Route::get('/attendance/info/{id}', 'AttendanceController@detail')->name('attendance.info');
	Route::get('/attendance/create', 'AttendanceController@create')->name('attendance.create');
	Route::get('/attendance/check-holiday', 'AttendanceController@checkHoliday')->name('attendance.check-holiday');
	Route::get('/attendance/data', 'AttendanceController@data')->name('attendance.data');
	Route::post('/attendance/store', 'AttendanceController@store')->name('attendance.store');
	Route::get('/attendance/detail', 'AttendanceController@attendanceDetail')->name('attendance.detail');
	Route::get('/attendance/mark/{id}/{day}/{month}/{year}', 'AttendanceController@mark')->name('attendance.mark');
	Route::post('/attendance/storeMark', 'AttendanceController@storeMark')->name('attendance.storeMark');
	Route::get('/attendance/{id}/edit', 'AttendanceController@edit')->name('attendance.edit');
	Route::put('/attendance/{id}/update', 'AttendanceController@update')->name('attendance.update');




	Route::get('/staff/attendance', 'AttendanceController@staff_attendace')->name('staff.attendance.index');
	Route::get('/staff/attendance/create', 'AttendanceController@staff_attendance_create')->name('staff.attendance.create');

	Route::get('/staff/attendance/summary', 'AttendanceController@staff_summary')->name('staff.attendance.summary');
	Route::post('/staff/attendance/refresh-count/{startDate?}/{endDate?}/{userId?}', 'AttendanceController@staff_refreshCount')->name('staff.attendance.refreshCount');
	Route::post('/staff/attendance/employeeData/{startDate?}/{endDate?}/{userId?}', 'AttendanceController@staff_employeeData')->name('staff.attendance.employeeData');
	Route::get('/staff/attendance/{id}/delete', 'AttendanceController@staff_destroy')->name('staff_delete_attendance');
	Route::get('/staff/attendance/info/{id}', 'AttendanceController@staff_detail')->name('staff.attendance.info');
	Route::post('/staff/attendance/store', 'AttendanceController@staff_store')->name('staff.attendance.store');
	Route::get('/staff/attendance/{id}/edit', 'AttendanceController@staff_edit')->name('staff.attendance.edit');
	Route::put('/staff/attendance/{id}/update', 'AttendanceController@staff_update')->name('staff.attendance.update');
	Route::post('/staff/attendance/{id}/updateDetails', 'AttendanceController@staff_updateDetails')->name('staff.attendance.updateDetails');
	Route::post('/staff/attendance/storeMark', 'AttendanceController@staff_storeMark')->name('staff.attendance.storeMark');
	Route::get('/staff/attendance/check-holiday', 'AttendanceController@staff_checkHoliday')->name('staff.attendance.check-holiday');
	Route::get('/staff/attendance/data', 'AttendanceController@staff_data')->name('staff.attendance.data');
	Route::post('/staff/attendance/storeAttendance', 'AttendanceController@staff_storeAttendance')->name('staff.attendance.storeAttendance');
	Route::get('/staff/attendance/detail', 'AttendanceController@staff_attendanceDetail')->name('staff.attendance.detail');
	Route::post('/staff/attendance/summaryData', 'AttendanceController@staff_summaryData')->name('staff.attendance.summaryData');
	Route::get('/staff/attendance/mark/{id}/{day}/{month}/{year}', 'AttendanceController@staff_mark')->name('staff.attendance.mark');

	Route::get('/staff/dashboard', 'StaffDashboardController@index')->name('staff.dashboard');
	Route::post('/staff/dashboard/widget/{dashboardType}', 'StaffDashboardController@widget')->name('staff.dashboard.widget');


	Route::get('/holidays', 'HolidaysController@index')->name('holidays');
	Route::get('/holidays/{id}/delete', 'HolidaysController@destroy')->name('holidays.destroy');
	Route::get('/holidays/create', 'HolidaysController@create')->name('holidays.create');
	Route::post('/holidays/store', 'HolidaysController@store')->name('holidays.store');

	Route::get('/holidays/calendar-month', 'HolidaysController@getCalendarMonth')->name('holidays.calendar-month');
    Route::get('/holidays/view-holiday/{year?}', 'HolidaysController@viewHoliday')->name('holidays.view-holiday');
    Route::get('/holidays/mark_sunday', 'HolidaysController@Sunday')->name('holidays.mark-sunday');
    Route::get('/holidays/calendar/{year?}', 'HolidaysController@holidayCalendar')->name('holidays.calendar');
    Route::get('/holidays/mark-holiday', 'HolidaysController@markHoliday')->name('holidays.mark-holiday');
    Route::post('/holidays/mark-holiday-store', 'HolidaysController@markDayHoliday')->name('holidays.mark-holiday-store');
    //Route::resource('holidays', 'HolidaysController');
    Route::get('/holidays/{id}/show', 'HolidaysController@show')->name('holidays.show');



    Route::get('/staff/holidays', 'HolidaysController@staff_holiday')->name('staff.holidays');
	Route::get('/staff/holidays/{id}/delete', 'HolidaysController@staff_destroy')->name('staff.holidays.destroy');
	Route::get('/staff/holidays/create', 'HolidaysController@staff_create')->name('staff.holidays.create');
	Route::post('/staff/holidays/store', 'HolidaysController@staff_store')->name('staff.holidays.store');
	Route::get('/staff/holidays/calendar-month', 'HolidaysController@staff_getCalendarMonth')->name('staff.holidays.calendar-month');
    Route::get('/staff/holidays/view-holiday/{year?}', 'HolidaysController@staff_viewHoliday')->name('staff.holidays.view-holiday');
    Route::get('/staff/holidays/mark_sunday', 'HolidaysController@staff_Sunday')->name('staff.holidays.mark-sunday');
    Route::get('/staff/holidays/calendar/{year?}', 'HolidaysController@staff_holidayCalendar')->name('staff.holidays.calendar');
    Route::get('/staff/holidays/mark-holiday', 'HolidaysController@staff_markHoliday')->name('staff.holidays.mark-holiday');
    Route::post('/staff/holidays/mark-holiday-store', 'HolidaysController@staff_markDayHoliday')->name('staff.holidays.mark-holiday-store');
    //Route::resource('holidays', 'HolidaysController');
    Route::get('/staff/holidays/{id}/show', 'HolidaysController@staff_show')->name('staff.holidays.show');

    Route::get('/leaves/pending', 'LeaveController@pendingLeaves')->name('leaves.pending');
    Route::get('/leaves/all-leaves', 'LeaveController@allLeaves')->name('leaves.all-leaves');
    Route::post('/leaves/data', 'LeaveController@data')->name('leaves.data');
    Route::get('/leaves/show-reject-modal', 'LeaveController@rejectModal')->name('leaves.show-reject-modal');
    Route::post('/leaves/leaveAction', 'LeaveController@leaveAction')->name('leaves.leaveAction');

    Route::get('/leaves', 'LeaveController@index')->name('leaves');
    Route::get('/leaves/create', 'LeaveController@create')->name('leaves.create');
    Route::post('/leaves/store', 'LeaveController@store')->name('leaves.store');
    Route::get('/leaves/{id}/edit', 'LeaveController@edit')->name('leaves.edit');
	Route::put('/leaves/{id}/update', 'LeaveController@update')->name('leaves.update');
	Route::get('/leaves/{id}/show', 'LeaveController@show')->name('leaves.show');
	Route::get('/leaves/{id}/delete', 'LeaveController@destroy')->name('leaves.destroy');

	Route::get('/leaveType', 'LeaveTypesConroller@index')->name('leaveType');
    Route::get('/leaveType/create', 'LeaveTypesConroller@create')->name('leaveType.create');
    Route::post('/leaveType/store', 'LeaveTypesConroller@store')->name('leaveType.store');
    Route::get('/leaveType/{id}/edit', 'LeaveTypesConroller@edit')->name('leaveType.edit');
	Route::put('/leaveType/{id}/update', 'LeaveTypesConroller@update')->name('leaveType.update');
	Route::get('/leaveType/{id}/show', 'LeaveTypesConroller@show')->name('leaveType.show');
	Route::get('/leaveType/{id}/delete', 'LeaveTypesConroller@destroy')->name('leaveType.destroy');


	Route::post('/staff/leaves/leaveAction', 'LeaveController@staff_leaveAction')->name('staff.leaves.leaveAction');
	Route::get('/staff/leaves/data', 'LeaveController@staff_data')->name('staff.leaves.data');

	Route::get('/staff/leaves', 'LeaveController@staff_leave')->name('staff.leaves');
    Route::get('/staff/leaves/create', 'LeaveController@staff_create')->name('staff.leaves.create');
    Route::post('/staff/leaves/store', 'LeaveController@staff_store')->name('staff.leaves.store');
    Route::get('/staff/leaves/{id}/edit', 'LeaveController@staff_edit')->name('staff.leaves.edit');
	Route::put('/staff/leaves/{id}/update', 'LeaveController@staff_update')->name('staff.leaves.update');
	Route::get('/staff/leaves/{id}/show', 'LeaveController@staff_show')->name('staff.leaves.show');
	Route::get('/staff/leaves/{id}/delete', 'LeaveController@staff_destroy')->name('staff.leaves.destroy');

	Route::post('/staff/leaves-dashboard/leaveAction', 'StaffDashboardController@staff_leaveAction')->name('staff.leaves-dashboard.leaveAction');

    Route::get('/staff/leaves-dashboard/create', 'StaffDashboardController@staff_leaveCreate')->name('staff.leaves-dashboard.create');
    Route::post('/staff/leaves-dashboard/store', 'StaffDashboardController@staff_leaveStore')->name('staff.leaves-dashboard.store');
    Route::get('/staff/leaves-dashboard/{id}/edit', 'StaffDashboardController@staff_leaveEdit')->name('staff.leaves-dashboard.edit');
	Route::put('/staff/leaves-dashboard/{id}/update', 'StaffDashboardController@staff_leaveUpdate')->name('staff.leaves-dashboard.update');
	Route::get('/staff/leaves-dashboard/{id}/show', 'StaffDashboardController@staff_leaveShow')->name('staff.leaves-dashboard.show');
	Route::get('/staff/leaves-dashboard/{id}/delete', 'StaffDashboardController@staff_leaveDestroy')->name('staff.leaves-dashboard.destroy');
	
	//Route::get('/hr-dashboard', 'AdminDashboardController@hrDashboard')->name('hrDashboard');



	

	Route::get('/designation', 'DesignationController@index')->name('designation');
	Route::post('/designation/datatable', 'DesignationController@get_designation_data')->name('get.designation.data');
	Route::get('/designation/create', 'DesignationController@create')->name('designation_create');
	Route::post('/designation/create', 'DesignationController@store')->name('designation_store');
	Route::get('/designation/{id}/edit', 'DesignationController@edit')->name('designation_edit');
	Route::post('/designation/update', 'DesignationController@update')->name('designation_update');
	Route::get('/delete_designation', 'DesignationController@destroy')->name('delete_designation');
	#members route
	//vikash 16.042021  department_delete
	Route::post('/sponsor_category_admin_data', 'DashboardController@sponsor_category_admin_data')->name('sponsor_category_admin_data');


	
	Route::get('/upcoming/occasion/{date?}', 'MembersController@upcomingOccasion')->name('upcoming_occasion');
	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/members', 'MembersController@index')->name('members');
	Route::get('/get_members_all', 'MembersController@getMembersDatatables')->name('get_members_all');
	Route::get('/dashboard/donation-graph', 'DashboardController@donationGraph')->name('dashboard_graph');
	#create by shayan 11.03.2021 
	Route::post('/totalAmount', 'LeadsController@totalAmount')->name('totalAmount');
	Route::post('/leads/callLog', 'LeadsController@callLog')->name('callLog');
	// Route::post('/getsetaccount_type', 'LeadController@getsetaccounttype')->name('getsetaccount_type');

	#create by vikash 13.03.2021
	Route::post('/get_all_lead_id', 'LeadsController@get_all_lead_id')->name('get_all_lead_id');
	Route::post('/get_agentids_by_agent_group', 'LeadsController@get_agentids_by_agent_group')->name('get_agentids_by_agent_group');
	
	Route::post('/get_account_type_data', 'LeadsController@get_account_type_data')->name('get_account_type_data');

	
	Route::get('/upcoming/occasion/{date?}', 'MembersController@upcomingOccasion')->name('upcoming_occasion');
	#staff route
	Route::get('/staff', 'StaffsController@index')->name('staff');
	Route::get('/staff/create', 'StaffsController@create')->name('staff_create');
	Route::post('/staff/create', 'StaffsController@store')->name('save_staff');
	Route::post('/update_provident_fund', 'StaffsController@update_provident_fund')->name('update_provident_fund');
	Route::post('/update_professional_tax', 'StaffsController@update_professional_tax')->name('update_professional_tax');
	Route::post('/update_portal_access', 'StaffsController@update_portal_access')->name('update_portal_access');
	Route::get('/staff/{id}/edit_basic_information', 'StaffsController@edit_basic_information')->name('edit_basic_information');
	Route::post('/Update_basic_information', 'StaffsController@Update_basic_information')->name('Update_basic_information');
	Route::get('/staff/{id}/edit-persional-information', 'StaffsController@edit_persional_information')->name('edit_persional_information');
	Route::post('/Update_persional_information', 'StaffsController@Update_persional_information')->name('Update_persional_information');
	Route::get('/staff/{id}/edit-payment-information', 'StaffsController@edit_payment_information')->name('edit_payment_information');
	Route::post('/Update_payment_information', 'StaffsController@Update_payment_information')->name('Update_payment_information');
	Route::get('/staff/{id}/salary_preview', 'StaffsController@salary_preview')->name('salary_preview');

	Route::get('/staff/{id}/edit_salary_information', 'StaffsController@edit_salary_information')->name('edit_salary_information');
	Route::post('/Update_salary_information', 'StaffsController@Update_salary_information')->name('Update_salary_information');
	Route::post('/generatePayslip', 'StaffsController@generatePayslip')->name('generatePayslip');
	Route::get('/staff/{id}/payslip_preview', 'StaffsController@payslip_preview')->name('payslip_preview');

	Route::post('/staff_change_password', 'StaffsController@staff_change_password')->name('staff_change_password');
	Route::get('/staff/payruns', 'StaffsController@payruns')->name('staff.payruns');
	Route::get('/staff/payruns/preview', 'StaffsController@payruns_preview')->name('staff.payrun.preview');
	Route::any('/delete-payroll', 'StaffsController@payrun_delete')->name('delete-payroll');

	Route::post('/get_tags_data', 'StaffsController@get_tags_data')->name('get_tags_data');	
	Route::get('/staff/{id}/details', 'StaffsController@show')->name('staff_details');
	Route::get('/staff/{id}/edit', 'StaffsController@edit')->name('staff_edit');
	Route::post('/staff/staff_update', 'StaffsController@update')->name('staff_update');
	Route::post('/get_staffs_data', 'StaffsController@get_staffs_data')->name('get_staffs_data');
	Route::get('/exportSelectedStaff', 'StaffsController@exportSelected')->name('exportSelectedStaff');
	//Route::get('/exportSelectedLeads', 'StaffsController@exportSelected')->name('exportSelectedLeads');
	//Route::get('/staff/{id}/delete', 'StaffsController@destroy')->name('staff_delete');
	Route::post('/staff/deleteSelected', 'StaffsController@deleteSelected')->name('staff_deleteSelected');
	Route::any('/delete-staff', 'StaffsController@destroy')->name('delete-staff');
	Route::post('/quickAdd', 'StaffsController@quickAdd')->name('quickAdd');
	Route::get('/staff/import', 'StaffsController@importShow')->name('staff_import');
	Route::post('/staff/import', 'StaffsController@import')->name('save_staff_import');

	Route::get('/campaign', 'CampaignController@index')->name('campaign');
	Route::post('/get-campaign', 'CampaignController@get_campaign_table')->name('get_campaign_table');
	Route::get('/campaign-page', 'CampaignController@getCampaign')->name('campaign-get');
	Route::get('/create-campaign', 'CampaignController@create')->name('create-campaign');
	Route::get('/view-campaign/{id}', 'CampaignController@view')->name('view-campaign');
	Route::get('/edit-campaign', 'CampaignController@edit')->name('edit-campaign');
	Route::get('/delete-campaign', 'CampaignController@delete')->name('delete-campaign');
	Route::any('/delete-campaign_lead', 'CampaignController@deleteLead')->name('delete-campaign-lead');
	Route::any('/add-campaign_lead', 'CampaignController@addLead')->name('add-campaign-lead');
	Route::post('/store-campaign', 'CampaignController@store')->name('store-campaign');
	Route::post('/update-campaign', 'CampaignController@update')->name('update-campaign');
	Route::get('/pull-lead', 'CampaignController@pullLead')->name('pull-campaign');

	Route::get('/campaignAssignedLeadDestroy', 'CampaignController@campaignAssignedLeadDestroy')->name('campaignAssignedLeadDestroy');
	Route::post('/campaign_leads_deleteSelected', 'CampaignController@deleteSelected')->name('campaign_leads_deleteSelected');
	Route::get('/exportSelectedCampaignLeads', 'CampaignController@exportSelected')->name('exportSelectedCampaignLeads');

	Route::get('/campaign/import/{id}', 'CampaignController@importShow')->name('get_campaign_import');
	Route::post('/campaign/campaign_lead_import', 'CampaignController@import')->name('campaign_lead_import');

	Route::post('/sendBulkSms', 'MembersController@sendBulkMessage')->name('sendBulkSms');
	Route::get('/deleteSelected', 'MembersController@deleteSelected')->name('deleteSelected');
	Route::get('/exportSelected', 'MembersController@exportSelected')->name('exportSelected');
	Route::get('/members/dashboard', 'MembersController@dashboard')->name('members_dashboard');
	Route::get('/members/create', 'MembersController@create')->name('members_create');
	Route::get('/members_export/{client_id}', 'MembersController@export')->name('members_export');
	Route::get('/donation_export/{member_id}', 'MembersController@donationExport')->name('donation_export');
	Route::post('/members/get/data', 'MembersController@get_members_data')->name('get_members_data');
	Route::get('/members/members_import', 'MembersController@importShow')->name('get_members_import');
	Route::post('/members/members_import', 'MembersController@import')->name('members_import');
    Route::post('/members/create', 'MembersController@store')->name('save_member');
    Route::post('/get_district', 'MembersController@getDistrict')->name('get_district');
	Route::get('/get_members', 'MembersController@getMembers')->name('get_members');
	Route::get('/get_member_prayer_request/{id}', 'MembersController@getIssuesDatatables')->name('get_member_prayer_request');
	Route::get('/member/{id}', 'MembersController@show')->name('member_details');
	Route::get('/checkdonationstatusbymember/{id}', 'MembersController@checkdonationstatus')->name('member_checkdonationstatus');

	#vikash member dashboard occasion datatable 12.03.2021
	Route::post('/get_memberOccation_data', 'MembersController@get_memberOccasion_data')->name('get_memberOccation_data');
	Route::post('/get_memberUpcomingOccation_data', 'MembersController@get_memberUpcomingOccation_data')->name('get_memberUpcomingOccation_data');

	Route::get('/member/{id}/edit', 'MembersController@edit')->name('member_edit');
	Route::post('/member/{id}/edit', 'MembersController@update')->name('member_update');
	Route::get('/member/{id}/delete', 'SecurityController@confirm')->name('member_delete');
    Route::post('/member/{id}/delete', 'MembersController@destroy');
	Route::post('/calling_access', 'MembersController@callingAccess')->name('calling_access');
	Route::post('/calling', 'MembersController@callingFunction')->name('calling');
	Route::post('/send_message', 'MembersController@sendMessage')->name('send_message');
	Route::post('/send_otp', 'MembersController@sendOtp')->name('send_otp');
	Route::post('/verify_otp', 'MembersController@verifyOtp')->name('verify_otp');
	Route::post('/inline_update', 'MembersController@inlineUpdate')->name('inline_update');
	Route::post('/switch_address', 'MembersController@switchAddress')->name('switch_address');
	Route::post('/delete_call_log', 'MembersController@deleteManualCallLog')->name('delete_call_log');
	Route::post('/members/save_note', 'MembersController@saveNote')->name('save_note');
	Route::post('/members/custom_request', 'MembersController@customRequest')->name('custom_request');
	Route::post('/members/update_note', 'MembersController@updateNote')->name('update_note');
	Route::post('/members/log_activity', 'MembersController@logActivity')->name('log_activity');
	Route::get('/members/dashboard_filter', 'MembersController@dashboardFilter')->name('dashboard_filter');
	Route::get('/members/getnote/{id}/{status}', 'MembersController@getNote')->name('getnote');
	Route::get('/members/import', 'MembersController@importShow')->name('get_members_import');
	Route::post('/members/deleteSelected', 'MembersController@deleteSelected')->name('member_deleteSelected');
	Route::get('/exportSelectedMembers', 'MembersController@exportSelected')->name('exportSelectedMembers');
	Route::post('/assign/memberCampaign', 'MembersController@assign_member_campaign')->name('assign.member.campaign');
    #Leads route
	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/leads', 'LeadsController@index')->name('leads');
	Route::get('/get_leads_all', 'LeadsController@getLeadsDatatables')->name('get_leads_all');
	Route::get('/staff', 'StaffsController@index')->name('staff');
	Route::post('/sendBulkSms', 'LeadsController@sendBulkMessage')->name('sendBulkSms');
	Route::post('/lead/deleteSelected', 'LeadsController@deleteSelected')->name('lead_deleteSelected');
	Route::get('/leads/import', 'LeadsController@importShow')->name('get_leads_import');
	Route::get('/lead/delete', 'LeadsController@lead_delete')->name('lead.delete');
	Route::get('/exportSelectedLeads', 'LeadsController@exportSelected')->name('exportSelectedLeads');
	Route::get('/leads/dashboard', 'LeadsController@dashboard')->name('leads_dashboard');
	Route::post('/assign/lead', 'LeadsController@assign_lead')->name('assign.lead');
	Route::post('/leads/get/data', 'LeadsController@get_leads_data')->name('get_leads_data');
	Route::post('/leads/get/data_lead_list', 'LeadsController@get_leads_data_lead_list')->name('get_leads_data_lead_list');
	Route::get('/call/status/update', 'LeadsController@manual_call_status')->name('manual_call_status');
	Route::post('/lead/callLog', 'LeadsController@leadCallLog')->name('get.lead.calllog');
	Route::post('/lead/dashboardcallLog', 'LeadsController@leadDashboardCallLog')->name('get.lead.dashboard.calllog');

	Route::get('/lead_status_update', 'LeadsController@lead_status_update')->name('lead_status_update');
	Route::get('/manual_call_status_outcome_update', 'LeadsController@manual_call_status_outcome_update')->name('manual_call_status_outcome_update');
	Route::post('/incoming_realstate_lead_create', 'LeadsController@incoming_realstate_lead_create')->name('incoming.realstate.lead.create');
	


	//Activity
	Route::get('/leads/call-log-reports', 'LeadsController@call_log_reports')->name('leads.call.log.reports');
	Route::post('/lead/get_call_log_report_data', 'LeadsController@get_call_log_report_data')->name('get.lead.calllog.report.data');
	Route::post('/lead/call_log_edit', 'LeadsController@call_log_edit')->name('call_log_edit');
	Route::post('/lead/callLogUpdate', 'LeadsController@callLogUpdateData')->name('callLogUpdate');
	Route::get('/exportSelectedCallLogReport', 'LeadsController@exportSelectedCallLogReport')->name('exportSelectedCallLogReport');
	Route::post('/lead/call_log_edit_radio', 'LeadsController@call_log_edit_radio')->name('call_log_edit_radio');

	Route::get('/recent_call_log', 'LeadsController@recent_call_log')->name('recent.call.log');
	Route::post('/incoming_realstate_call_log_update', 'LeadsController@incoming_realstate_call_log_update')->name('incoming.realstate.calllog.update');
	Route::post('/incoming_lead_create', 'LeadsController@incoming_lead_create')->name('incoming.lead.create');
	

	Route::get('/leads/load/call', 'LeadsController@load_call')->name('leads_load_call');
	Route::get('/leads/load/pause', 'LeadsController@load_pause')->name('leads_load_pause');
	Route::get('/leads/load/resume', 'LeadsController@load_resume')->name('leads_load_resume');
	Route::get('/leads/load/api', 'LeadsController@load_api')->name('leads_load_api');
	Route::get('/calling/lead/details', 'LeadsController@callingLeadDetails')->name('calling_lead_details');

	Route::get('/campaign/leads/number', 'LeadsController@campaignLeadsNumber')->name('campaign_leads_number');
	Route::get('/stop/auto/dial', 'LeadsController@stopAutoDial')->name('stop_auto_dial');
	Route::get('/fetch/leads', 'LeadsController@fetchLeads')->name('fetch-leads');
	Route::get('/SARV/Mobile/getMobile', 'LeadsController@newApiCall');
	Route::get('/staff' , 'StaffsController@index')->name('staff');
	Route::get('/leads/create', 'LeadsController@create')->name('leads_create');
	Route::get('/leads_export/{client_id}', 'LeadsController@export')->name('leads_export');
	Route::post('/prayer-request', 'LeadsController@prayer_request')->name('prayer.request');
	Route::post('/lead/addCallLog', 'LeadsController@addCallLog')->name('add.callLog'); 
	Route::post('/leads/leads_import', 'LeadsController@import')->name('leads_import');
    Route::post('/leads/create', 'LeadsController@store')->name('save_lead');
    Route::post('/get_district', 'LeadsController@getDistrict')->name('get_district');
	Route::get('/get_leads', 'LeadsController@getLeads')->name('get_leads');
	Route::get('/get_lead_prayer_request/{id}', 'LeadsController@getIssuesDatatables')->name('get_lead_prayer_request');
	Route::get('/get_member_donation/{id}', 'LeadsController@getDonationDatatables')->name('get_member_donation');
	Route::get('/lead/{id}', 'LeadsController@show')->name('lead_details');
	Route::post('/lead/prayer/request', 'LeadsController@leadPrayerRequest')->name('get.lead.prayer.request');
	Route::post('/lead/donation', 'LeadsController@leadDonation')->name('get.lead.donation');
	Route::get('/checkdonationstatusbylead/{id}', 'LeadsController@checkdonationstatus')->name('lead_checkdonationstatus');
	#vikash 7/04/21 
	Route::post('/incoming-prayer-request', 'LeadsController@incoming_prayer_request')->name('incoming.prayer.request');


	Route::post('/assign/donationLeadCampaign', 'DonationController@assign_donation_lead_campaign')->name('assign.donation.lead.campaign');
	Route::post('/assign/leadCampaign', 'LeadsController@assign_lead_campaign')->name('assign.lead.campaign');
	#prayer request by vikash prayer_requestStatusUpdate1
	Route::post('/prayer_requestStatusUpdate1', 'LeadsController@prayer_requestStatusUpdate1')->name('prayer_requestStatusUpdate1');
	Route::post('/prayer_requestStatusUpdate2', 'LeadsController@prayer_requestStatusUpdate2')->name('prayer_requestStatusUpdate2');
	Route::post('/prayerRequestEdit', 'LeadsController@prayerRequestEdit')->name('prayerRequestEdit');
	Route::post('/prayerRequestUpdate', 'LeadsController@prayerRequestUpdate')->name('prayerRequestUpdate');
	Route::get('/destroyPrayerRequest', 'LeadsController@destroyPrayerRequest')->name('destroyPrayerRequest');
	#leads donations by vikash 5/3/21 
	Route::post('/donationDatatable', 'LeadsController@adminDonation')->name('get.admin.donation');

	#leads by vikash  uploadFile 8-3-21
	Route::post('/leadConvertedStatusUpdate', 'LeadsController@leadConvertedStatusUpdate')->name('leadConvertedStatusUpdate');
	Route::post('/leads_detail_uploadFile', 'LeadsController@leadDetail_uploadFile')->name('leads_detail_uploadFile');
	#leads by vikash  uploadFile 9-3-21
	Route::get('/dashbordCountData', 'LeadsController@dashbordCountData')->name('dashbordCountData');
	Route::post('/campaignSelectedAdd', 'LeadsController@campaignSelectedAdd')->name('add.campaign.selected');
	Route::post('/leads_deleteSourcefile', 'LeadsController@deleteSourcefile')->name('leads_deleteSourcefile');
	Route::get('/lead/{id}/edit', 'LeadsController@edit')->name('lead_edit');
	Route::post('/lead_update', 'LeadsController@update')->name('lead_update');


	Route::post('/leads_uploadFile', 'LeadsController@uploadFile')->name('leads_uploadFile');
	Route::post('/leads_deleteSourcefile', 'LeadsController@deleteSourcefile')->name('leads_deleteSourcefile');
	
	Route::get('/lead/{id}/delete', 'SecurityController@confirm')->name('lead_delete');
    Route::post('/lead/{id}/delete', 'LeadsController@destroy');
	Route::post('/calling_access', 'LeadsController@callingAccess')->name('calling_access');
	Route::post('/calling', 'LeadsController@callingFunction')->name('calling');
	Route::post('/send_message', 'LeadsController@sendMessage')->name('send_message');
	Route::post('/send_otp', 'LeadsController@sendOtp')->name('send_otp');
	Route::post('/verify_otp', 'LeadsController@verifyOtp')->name('verify_otp');
	Route::post('/inline_update', 'LeadsController@inlineUpdate')->name('inline_update');
	Route::post('/switch_address', 'LeadsController@switchAddress')->name('switch_address');
	Route::post('/delete_message', 'LeadsController@deleteMessage')->name('delete_message');
	Route::post('/leads/save_note', 'LeadsController@saveNote')->name('save_note');
	Route::post('/leads/update_note', 'LeadsController@updateNote')->name('update_note');
	Route::get('/leads/dashboard_filter', 'LeadsController@dashboardFilter')->name('dashboard_filter');
	Route::get('/leads/getnote/{id}/{status}', 'LeadsController@getNote')->name('getnote');
	
	#Appointments route
	Route::get('/appointments', 'AppointmentController@index')->name('appointments');
	Route::get('/appointments/dashboard', 'AppointmentController@dashboard')->name('appointments_dashboard');
	Route::get('/appointments/create', 'AppointmentController@create')->name('appointments_create');
    Route::post('/appointments/create', 'AppointmentController@store')->name('save_appointments');
	Route::get('/appointments_export/{client_id}', 'AppointmentController@export')->name('appointments_export');
	Route::post('/appointments/appointments_import', 'AppointmentController@import')->name('appointments_import');
    Route::post('/appointments/aptUpdate', 'AppointmentController@update')->name('update_appointments');
	Route::post('/search_member', 'AppointmentController@searchMember')->name('search_member');
	Route::post('/appointments/change_status', 'AppointmentController@changeStatus')->name('change_status');
	Route::get('/appointments/{id}', 'AppointmentController@show')->name('appointment_details');
	Route::get('/appointments/{id}/delete', 'SecurityController@confirm')->name('appointment_delete');
    Route::post('/appointments/{id}/delete', 'AppointmentController@destroy');
	Route::post('/appointments/get_time_slots', 'AppointmentController@getTimeSlots');
	Route::post('/appointments/apt_dashboard_filter', 'AppointmentController@aptDashboardFilter')->name('apt_dashboard_filter');
	
	
	#Donations route vikash
	Route::get('/donations_report','DonationController@donation_report')->name('donations_report');
	Route::post('/donations/get_admin_donation_reports', 'DonationController@getAdminDonationReports')->name('get_admin_donation_reports');
	#new route created by vikash for donation detail datatable
	Route::post('/donationDetailDatatable', 'LeadsController@leadDonationDetail')->name('get.lead.donation.detail');
	Route::post('/donations/deleteSelected', 'DonationController@deleteSelected')->name('donations_deleteSelected');
	Route::get('/exportSelectedDonations', 'DonationController@exportSelected')->name('exportSelectedDonations');

	Route::get('/donations/comparison', 'DashboardController@donationsComparison')->name('donations-comparison');
	Route::get('/custom_date_validation', 'DashboardController@custom_date_validation')->name('custom_date_validation');


	Route::post('/leads/get_userSession_data', 'LeadsController@get_userSession_data')->name('get_userSession_data');
	Route::get('/active_inctive_session_count', 'LeadsController@activeInactiveSessionCount')->name('active_inctive_session_count');
	
	
	Route::get('/donations', 'DonationController@index')->name('donations');
	Route::get('/donations/dashboard', 'DonationController@dashboard')->name('donations_dashboard');
	Route::get('/donations/create', 'DonationController@create')->name('donation_create');
    Route::post('/donations/create', 'DonationController@store')->name('donation_store');
	Route::get('/donations_export/{client_id}', 'DonationController@export')->name('donations_export');
	Route::post('/donations/donations_import', 'DonationController@import')->name('donations_import');
	Route::get('/donations/{id}/edit', 'DonationController@edit')->name('donation_edit');
	Route::get('/donations/{id}/payment_detail', 'DonationController@paymentDetail')->name('payment_detail');
	Route::post('/updatePaymentDetail', 'DonationController@updatePaymentDetail')->name('updatePaymentDetail');
	Route::post('/updateDonationPaymentDetail', 'DonationController@updateDonationPaymentDetail')->name('updateDonationPaymentDetail');
	
	Route::get('/donations/{id}', 'DonationController@show')->name('donation_details');
	Route::get('/donations/{id}/print', 'DonationController@printEmi')->name('payment_details_print');

	Route::post('/donations/donatonUpdate', 'DonationController@updateDonation')->name('donation_update');
	Route::get('/donations/{id}/delete', 'SecurityController@confirm')->name('donation_delete');
    Route::post('/donations/{id}/delete', 'DonationController@destroy')->name('donation_delete');
	Route::post('/donations/donations_dashboard_filter', 'DonationController@donationsDashboardFilter')->name('donations_dashboard_filter');
	
	
	//vk
	Route::get('/donation_import', 'DonationController@importShow')->name('donation_import_show');
	Route::get('/donation_delete', 'DonationController@donation_delete')->name('donation_delete_post');

	Route::post('/totalAmountAdminDonations', 'DonationController@totalAmountAdminDonations')->name('totalAmountAdminDonations');

	Route::get('/incoming_donation_form', 'DonationController@incoming_donation_form')->name('incoming_donation_form');
	Route::get('/incoming_prayer_form', 'DonationController@incoming_prayer_form')->name('incoming_prayer_form');
	Route::post('/incoming_call_donation_store', 'DonationController@incoming_call_donation_store')->name('incoming_call_donation_store');


	#Vehicles route
	Route::get('/vehicles', 'VehiclesController@index')->name('vehicles');
	Route::get('/vehicles/dashboard', 'VehiclesController@dashboard')->name('vehicles_dashboard');
	Route::get('/vehicles/create', 'VehiclesController@create')->name('vehicle_create');
    Route::post('/vehicles/create', 'VehiclesController@store')->name('vehicle_store');
	Route::post('/vehicles/vehicles_import', 'VehiclesController@import')->name('vehicles_import');
	Route::get('/vehicles_export/{client_id}', 'VehiclesController@export')->name('vehicles_export');
	Route::get('/vehicles/{id}/edit', 'VehiclesController@edit')->name('vehicle_edit');
	Route::get('/vehicles/{id}', 'VehiclesController@show')->name('vehicle_details');
	Route::post('/vehicles/vehicleUpdate', 'VehiclesController@updateVehicle')->name('vehicle_update');
	Route::get('/vehicles/{id}/delete', 'SecurityController@confirm')->name('vehicle_delete');
    Route::post('/vehicles/{id}/delete', 'VehiclesController@destroy');
	Route::post('/vehicles/vehicles_dashboard_filter', 'VehiclesController@vehiclesDashboardFilter')->name('vehicles_dashboard_filter');
	

	#Payments route
	Route::get('/payments', 'PaymentController@index')->name('payments');
	Route::get('/payments/dashboard', 'PaymentController@dashboard')->name('payments_dashboard');
	Route::get('/payments/create', 'PaymentController@create')->name('payment_create');
	Route::post('/payments/create', 'PaymentController@store')->name('payment_store');
	Route::post('/payments/callback', 'PaymentController@paymentCallback')->name('callback');
	
	Route::get('/payments/thanku', 'PaymentController@razorpayCallback')->name('razorpaycallback');
	Route::post('/send_payment_link_sms', 'PaymentController@sendPaymentLinkSMS')->name('send_payment_link_sms');
	Route::post('/send_emi_payment_link_sms', 'PaymentController@sendEMIPaymentLinkSMS')->name('send_emi_payment_link_sms');
	
	
	Route::get('/payments_export/{client_id}', 'PaymentController@export')->name('payments_export');
	Route::post('/payments/payments_import', 'PaymentController@import')->name('payments_import');
	Route::get('/payments/{id}/edit', 'PaymentController@edit')->name('payment_edit');
	//Route::get('/payments/{id}', 'PaymentController@show')->name('payment_details');
	Route::post('/payments/donatonUpdate', 'PaymentController@updatePayment')->name('payment_update');
	Route::get('/payments/{id}/delete', 'PaymentController@confirm')->name('payment_delete');
    Route::post('/payments/{id}/delete', 'PaymentController@destroy');
	Route::post('/payments/payments_dashboard_filter', 'PaymentController@paymentsDashboardFilter')->name('payments_dashboard_filter');
	Route::get('/payments/razorpaycreate', 'PaymentController@razorpaycreate');
	Route::post('/payments/razorpaycreate', 'PaymentController@razorpaystore')->name('razorpay_store');
	Route::get('/payments/razorpaycreateplan', 'PaymentController@createplan')->name('create_plan');
	Route::post('/payments/razorpaycreateplan', 'PaymentController@makeplan')->name('make_plan');
	Route::get('/payments/razorpaysubscriptionspayment/{id}', 'PaymentController@subscriptionspayment')->name('subscriptions_payment');
});

#incoming calls api
Route::get('/incoming/call', 'Crm\LeadsController@incomingCallRegister');
Route::get('/incoming/call/{lead_number}', 'Crm\LeadsController@searchLead');
Route::get('/start/incoming/call', 'Crm\LeadsController@startIncommingCall');

#incoming calls check
Route::get('/incoming/call/check', 'Crm\LeadsController@incoming_call_check')->name('incoming.call.check');
Route::get('/incoming/call/log', 'Crm\LeadsController@incoming_call_log')->name('incoming.call.log');
Route::get('/incoming/call/new', 'Crm\LeadsController@incoming_call_new')->name('incoming.call.new');

#auto dial call check
Route::get('/autodial/call/check', 'Crm\LeadsController@autodialCallCheck')->name('auto.dial.call.check');
Route::get('/user/break/check', 'Crm\LeadsController@userBreakCheck')->name('user.break.check');

# static pages route
Route::group(['middleware' => ['auth', 'laralum.base', 'laralum.auth'], 'prefix' => 'api', 'namespace' => 'Api', 'as' => 'api::'], function () {
	
#text-sms routes
Route::get('/text-sms/send-sms', 'StaticController@textsms')->name('text-sms');
Route::get('/text-sms/xml-send-sms', 'StaticController@xmlsendsms')->name('xml-send-sms');
Route::get('/text-sms/error-code', 'StaticController@errorcode')->name('error-code');
Route::get('/text-sms/delivery-report', 'StaticController@deliveryreport')->name('delivery-report');

#sample code routes
Route::get('/sample-code/php', 'StaticController@php')->name('php');
Route::get('/sample-code/python', 'StaticController@python')->name('python');
Route::get('/sample-code/java', 'StaticController@java')->name('java');
Route::get('/sample-code/java-xml', 'StaticController@javaxml')->name('javaxml');
Route::get('/sample-code/c-sharp', 'StaticController@usingC')->name('c-sharp');
Route::get('/sample-code/google-appscript', 'StaticController@appscript')->name('appscript');
Route::get('/sample-code/windows8-c', 'StaticController@window8c')->name('windows8-c');
Route::get('/sample-code/android', 'StaticController@android')->name('android');
Route::get('/sample-code/ios', 'StaticController@ios')->name('ios');
Route::get('/sample-code/vb6', 'StaticController@vb6')->name('vb6');
Route::get('/sample-code/oracle', 'StaticController@oracle')->name('oracle');
Route::get('/sample-code/go-language', 'StaticController@goLang')->name('go-language');

#Error code route
Route::get('/error-code/errorcode', 'StaticController@mainerrorcode')->name('mainerrorcode');

#Basic Routes route
Route::get('/basic/route-balance', 'StaticController@route')->name('route-Balance');
Route::get('/basic/change-password', 'StaticController@changepassword')->name('change-password');
Route::get('/basic/validation', 'StaticController@validation')->name('validation');
Route::get('/basic/opt-out', 'StaticController@optout')->name('opt-out');
Route::get('/basic/error-code', 'StaticController@errorcodebasic')->name('error-code-basic');

});
