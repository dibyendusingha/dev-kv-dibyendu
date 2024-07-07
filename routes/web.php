<?php

use App\Http\Controllers\AdminEnd;
use App\Http\Controllers\API\MahindraCompany;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\Subscription\SubcriptionController;
use App\Http\Controllers\BandProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CropCalenderController;
use App\Http\Controllers\Crop\CropController;
use App\Http\Controllers\FrontEnd;
use App\Http\Controllers\iffco;
use App\Http\Controllers\OfflineLeadController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\SBI\SbiController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WebFilterController;
use App\Http\Controllers\WEB\AdsBannerCotroller;
use App\Http\Controllers\WEB\BoostController;
use App\Http\Controllers\WEB\SubscriptionController;

use App\Http\Controllers\WEB\SellerLeadController;

# Crop
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('clear-data', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    return "Cache, View, Config, Route & Optimize is cleared";
});

# Mahindra
Route::get('mahindra-dasboard', [MahindraCompany::class, 'index_page_show']);
Route::get('mahindra-all-lead', [MahindraCompany::class, 'all_lead_page_show']);
Route::get('mahindra-new-lead', [MahindraCompany::class, 'new_lead_page_show']);
Route::get('mahindra-hot-lead', [MahindraCompany::class, 'hot_lead_page_show']);
Route::get('mahindra-warm-lead', [MahindraCompany::class, 'warm_lead_page_show']);
Route::get('mahindra-cold-lead', [MahindraCompany::class, 'cold_lead_page_show']);
Route::get('mahindra-logout', [MahindraCompany::class, 'mahindra_logout']);
Route::get('mahindra-login', [MahindraCompany::class, 'login_page_show']);
Route::post('mahindra-login', [MahindraCompany::class, 'mahindra_login']);

#SBI
Route::get('sbi-dasboard', [SbiController::class, 'dashboard_page']);
Route::get('sbi-all-lead', [SbiController::class, 'all_lead_page']);

Route::match(['get', 'post'], 'mahindra-all-lead-filter', [MahindraCompany::class, 'filter_all_leads']);
Route::match(['get', 'post'], 'mahindra-new-lead-filter', [MahindraCompany::class, 'filter_new_leads']);
Route::match(['get', 'post'], 'mahindra-hot-filter', [MahindraCompany::class, 'filter_hot_leads']);
Route::match(['get', 'post'], 'mahindra-warm-filter', [MahindraCompany::class, 'filter_warm_leads']);
Route::match(['get', 'post'], 'mahindra-cold-filter', [MahindraCompany::class, 'filter_cold_leads']);

Route::get('invoice/boost/{product_id}', [BoostController::class, 'boostInvoice']);

Route::get('test-get-location', [FrontEnd::class, 'test_get_location']);
Route::get('/invoice/{type}/{subscribedId}', [SubcriptionController::class, 'invoice_page']);
Route::get('/boots/{type}/{subscribedId}', [SubcriptionController::class, 'boots_page']);

Route::get('user-send-notification/{area}', [NotificationController::class, 'user_send_notification']);
Route::get('banner_id_user-send-notification', [NotificationController::class, 'banner_id_wish_user_send_notification']);
Route::get('user-wish-category-count', [NotificationController::class, 'action_user_wish_category_count']);

Route::get('/runCmd', function () {
    $exitcode = Artisan::call('storage:link');
    //php artisan storage:link
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/migrate-class', function () {
    $exitCode = Artisan::call('migrate:refresh --path=/database/migrations/2023_12_28_171427_sponser.php');
    return '<h1>Migration Class Added Successfully</h1>';
});

Route::get('/seed-class', function () {
    $exitCode = Artisan::call('php artisan db:seed sponser');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/command', function () {
    $exitcode = Artisan::call('make:command englishCommand');
    //php artisan make:controller
});

Route::get('/crontest', function () {
    $exitcode = Artisan::call('test:cron');
    //php artisan make:controller
});

Route::get('/englishcorn', function () {
    $exitcode = Artisan::call('english:cron');
    //php artisan make:controller
});

Route::get('/bengalicorn', function () {
    $exitcode = Artisan::call('benagali:cron');
    //php artisan make:controller
});

Route::get('/hindicorn', function () {
    $exitcode = Artisan::call('hindi:cron');
    //php artisan make:controller
});

Route::get('/makeController', function () {
    $exitcode = Artisan::call('make:controller BandProductController');
    //php artisan make:controller
});
Route::get('/makeMiddleware', function () {
    $exitcode = Artisan::call('make:middleware ipAuthenticate');
    //php artisan make:controller
});
Route::get('/runmodel', function () {
    $exitcode = Artisan::call('make:model fertilizers');
    //php artisan storage:link
});
Route::get('/runmailCmd', function () {
    $exitcode = Artisan::call('make:mail LaraEmail');
});
Route::get('/runnotification', function () {
    $exitcode = Artisan::call('make:controller notification');
});
Route::get('/bootstrap', function () {
    $exitcode = Artisan::call('ui bootstrap --auth');
});

Route::get('storage-link', function () {
    $exitcode = Artisan::call('storage:link');
});

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

// Restart server
Route::get('/restart-server', function () {
    exec('pkill -f "php artisan serve"');
    $exitCode = Artisan::call('serve');
    return '<h1>Server restarted</h1>';
});

// Config clear
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Config cleared</h1>';
});

// Optimize clear
Route::get('/optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return '<h1>Optimize cleared</h1>';
});

Route::get('reset', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});

Route::get('route-list', function () {
    Artisan::call('route:list');
});

Route::get('/composer-update', function () {
    $exitCode = Artisan::call('composer update');
    return '<h1>Composer Update </h1>';
});

Route::get('admin', function () {
    return view('admin.brand');
});

Route::get('iffco-product', [FrontEnd::class, 'iffcoProductPage']);
Route::get('date', [SubcriptionController::class, 'date']);

Route::middleware(['auth.adminlogin'])->group(function () {

    /* tractor route */
    Route::get('krishi-tractor-brand', [AdminEnd::class, 'brand']);
    Route::post('krishi-tractor-brand-submit', [AdminEnd::class, 'brand_submit']);
    Route::get('krishi-tractor-brand-edit/{id}', [AdminEnd::class, 'brand_edit']);
    Route::post('krishi-tractor-brand-update', [AdminEnd::class, 'brand_update']);
    Route::get('krishi-tractor-brand-delete/{id}', [AdminEnd::class, 'tractor_brand_delete']);
    Route::get('krishi-tractor-model', [AdminEnd::class, 'krishi_tractor_model']);
    Route::post('krishi-tractor-model-submit', [AdminEnd::class, 'tractor_model_submit']);
    Route::get('krishi-tractor-model-edit/{id}', [AdminEnd::class, 'tractor_model_edit']);
    Route::post('krishi-tractor-model-update', [AdminEnd::class, 'tractor_model_update']);
    Route::get('krishi-tractor-model-delete/{id}', [AdminEnd::class, 'tractor_model_delete']);
    Route::get('krishi-tractor-specification', [AdminEnd::class, 'tractor_specification']);
    Route::post('krishi-tractor-specification-submit', [AdminEnd::class, 'tractor_specification_submit']);
    Route::get('krishi-tractor-specification-edit/{id}', [AdminEnd::class, 'tractor_specification_edit']);
    ROute::post('krishi-tractor-specification-update', [AdminEnd::class, 'tractor_specification_update']);
    Route::get('krishi-tractor-specification-delete/{id}', [AdminEnd::class, 'tractor_specification_delete']);
    Route::get('krishi-tractor-post-list', [AdminEnd::class, 'krishi_tractor_post_list']);
    Route::get('krishi-tractor-post-view/{id}', [AdminEnd::class, 'krishi_tractor_post_view']);
    Route::post('krishi-tractor-status-change', [AdminEnd::class, 'tractor_status_change']);
    Route::get('krishi-tractor-post-delete/{id}', [AdminEnd::class, 'tractor_post_delete']);
    Route::post('tractor-filter-data', [AdminEnd::class, 'tractor_filter_data']);

    Route::get('krishi-boost-payment/{category_name}/{product_id}', [BoostController::class, 'boostPaymentForm']);

    /* goods vahicle route */
    Route::get('krishi-gv-brand', [AdminEnd::class, 'gv_brand']);
    Route::post('krishi-gv-brand-submit', [AdminEnd::class, 'gv_brand_submit']);
    Route::get('krishi-gv-brand-edit/{id}', [AdminEnd::class, 'gv_brand_edit']);
    Route::post('krishi-gv-brand-update', [AdminEnd::class, 'gv_brand_update']);
    Route::get('krishi-gv-brand-delete/{id}', [AdminEnd::class, 'gv_brand_delete']);
    Route::get('krishi-gv-model', [AdminEnd::class, 'gv_model']);
    Route::post('krishi-gv-model-submit', [AdminEnd::class, 'gv_model_submit']);
    Route::get('krishi-gv-model-edit/{id}', [AdminEnd::class, 'gv_model_edit']);
    Route::post('krishi-gv-model-update', [AdminEnd::class, 'gv_model_update']);
    Route::get('krishi-gv-model-delete/{id}', [AdminEnd::class, 'gv_model_delete']);
    Route::get('krishi-gv-specification', [AdminEnd::class, 'gv_specification']);
    Route::post('krishi-gv-specification-submit', [AdminEnd::class, 'gv_specification_submit']);
    Route::get('krishi-gv-specification-edit/{id}', [AdminEnd::class, 'gv_specification_edit']);
    Route::post('krishi-gv-specification-update', [AdminEnd::class, 'gv_specification_update']);
    Route::get('krishi-gv-specification-delete/{id}', [AdminEnd::class, 'gv_specification_delete']);
    Route::get('krishi-gv-post-list', [AdminEnd::class, 'gv_post_list']);
    Route::get('krishi-gv-post-view/{id}', [AdminEnd::class, 'gv_post_view']);
    Route::post('krishi-gv-status-change', [AdminEnd::class, 'gv_status_change']);
    Route::get('krishi-gv-post-delete/{id}', [AdminEnd::class, 'gv_post_delete']);
    Route::post('gv-filter-data', [AdminEnd::class, 'gv_filter_data']);

    /* harvester route */
    Route::get('krishi-harvester-brand', [AdminEnd::class, 'harvester_brand']);
    Route::post('krishi-harvester-brand-submit', [AdminEnd::class, 'harvester_brand_submit']);
    Route::get('krishi-harvester-brand-edit/{id}', [AdminEnd::class, 'harvester_brand_edit']);
    Route::post('krishi-harvester-brand-update', [AdminEnd::class, 'harvester_brand_update']);
    Route::get('krishi-harvester-brand-delete/{id}', [AdminEnd::class, 'harvester_brand_delete']);
    Route::get('krishi-harvester-model', [AdminEnd::class, 'harvester_model']);
    Route::post('krishi-harvester-model-submit', [AdminEnd::class, 'harvester_model_submit']);
    Route::get('krishi-harvester-model-edit/{id}', [AdminEnd::class, 'harvester_model_edit']);
    Route::post('krishi-harvester-model-update', [AdminEnd::class, 'harvester_model_update']);
    Route::get('krishi-harvester-model-delete/{id}', [AdminEnd::class, 'harvester_model_delete']);
    Route::get('krishi-harvester-specification', [AdminEnd::class, 'harvester_specification']);
    Route::post('krishi-harvester-specification-submit', [AdminEnd::class, 'harvester_specification_submit']);
    Route::get('krishi-harvester-specification-edit/{id}', [AdminEnd::class, 'harvester_specification_edit']);
    ROute::post('krishi-harvester-specification-update', [AdminEnd::class, 'harvester_specification_update']);
    Route::get('krishi-harvester-specification-delete/{id}', [AdminEnd::class, 'harvester_specification_delete']);
    Route::get('krishi-harvester-post-list', [AdminEnd::class, 'harvester_post_list']);
    Route::get('krishi-harvester-post-view/{id}', [AdminEnd::class, 'harvester_post_view']);
    Route::post('krishi-harvester-status-change', [AdminEnd::class, 'harvester_status_change']);
    Route::get('krishi-harvester-post-delete/{id}', [AdminEnd::class, 'harvester_post_delete']);
    Route::post('harvester-filter-data', [AdminEnd::class, 'harvester_filter_data']);

    /* implements */
    Route::get('krishi-implements-brand', [AdminEnd::class, 'implements_brand']);
    Route::post('krishi-implements-brand-submit', [AdminEnd::class, 'implements_brand_submit']);
    Route::get('krishi-implements-brand-edit/{id}', [AdminEnd::class, 'implements_brand_edit']);
    Route::post('krishi-implements-brand-update', [AdminEnd::class, 'implements_brand_update']);
    Route::get('krishi-implements-brand-delete/{id}', [AdminEnd::class, 'implements_brand_delete']);
    Route::get('krishi-implements-model', [AdminEnd::class, 'implements_model']);
    Route::post('krishi-implements-model-submit', [AdminEnd::class, 'implements_model_submit']);
    Route::get('krishi-implements-model-edit/{id}', [AdminEnd::class, 'implements_model_edit']);
    Route::post('krishi-implements-model-update', [AdminEnd::class, 'implements_model_update']);
    Route::get('krishi-implements-model-delete/{id}', [AdminEnd::class, 'implements_model_delete']);
    Route::get('krishi-implements-specification', [AdminEnd::class, 'implements_specification']);
    Route::post('krishi-implements-specification-submit', [AdminEnd::class, 'implements_specification_submit']);
    Route::get('krishi-implements-specification-edit/{id}', [AdminEnd::class, 'implements_specification_edit']);
    ROute::post('krishi-implements-specification-update', [AdminEnd::class, 'implements_specification_update']);
    Route::get('krishi-implements-specification-delete/{id}', [AdminEnd::class, 'implements_specification_delete']);
    Route::get('krishi-implements-post-list', [AdminEnd::class, 'implements_post_list']);
    Route::get('krishi-implements-post-view/{id}', [AdminEnd::class, 'implements_post_view']);
    Route::post('krishi-implements-status-change', [AdminEnd::class, 'implements_status_change']);
    Route::get('krishi-implements-post-delete/{id}', [AdminEnd::class, 'implements_post_delete']);
    Route::post('implements-filter-data', [AdminEnd::class, 'implements_filter_data']);

    /*seeds*/
    Route::get('krishi-seeds-post-list', [AdminEnd::class, 'seeds_post_list']);
    Route::get('krishi-seeds-post-view/{id}', [AdminEnd::class, 'seeds_post_view']);
    Route::post('krishi-seeds-status-change', [AdminEnd::class, 'seeds_status_change']);
    Route::get('krishi-seeds-post-delete/{id}', [AdminEnd::class, 'seeds_post_delete']);
    Route::post('seed-filter-data', [AdminEnd::class, 'seed_filter_data']);

    /*pesticides*/
    Route::get('krishi-pesticides-post-list', [AdminEnd::class, 'pesticides_post_list']);
    Route::get('krishi-pesticides-post-view/{id}', [AdminEnd::class, 'pesticides_post_view']);
    Route::post('krishi-pesticides-status-change', [AdminEnd::class, 'pesticides_status_change']);
    Route::get('krishi-pesticides-post-delete/{id}', [AdminEnd::class, 'pesticides_post_delete']);
    Route::post('pesticides-filter-data', [AdminEnd::class, 'pesticides_filter_data']);

    /*fertilizers*/
    Route::get('krishi-fertilizers-post-list', [AdminEnd::class, 'fertilizers_post_list']);
    Route::get('krishi-fertilizers-post-view/{id}', [AdminEnd::class, 'fertilizers_post_view']);
    Route::post('krishi-fertilizers-status-change', [AdminEnd::class, 'fertilizers_status_change']);
    Route::get('krishi-fertilizers-post-delete/{id}', [AdminEnd::class, 'fertilizers_post_delete']);
    Route::post('fertilizer-filter-data', [AdminEnd::class, 'fertilizer_filter_data']);

    /* tyre */
    Route::get('krishi-tyre-brand', [AdminEnd::class, 'tyre_brand']);
    Route::post('krishi-tyre-brand-submit', [AdminEnd::class, 'tyre_brand_submit']);
    Route::get('krishi-tyre-brand-edit/{id}', [AdminEnd::class, 'tyre_brand_edit']);
    Route::post('krishi-tyre-brand-update', [AdminEnd::class, 'tyre_brand_update']);
    Route::get('krishi-tyre-brand-delete/{id}', [AdminEnd::class, 'tyre_brand_delete']);
    Route::get('krishi-tyre-model', [AdminEnd::class, 'tyre_model']);
    Route::post('krishi-tyre-model-submit', [AdminEnd::class, 'tyre_model_submit']);
    Route::get('krishi-tyre-model-edit/{id}', [AdminEnd::class, 'tyre_model_edit']);
    Route::post('krishi-tyre-model-update', [AdminEnd::class, 'tyre_model_update']);
    Route::get('krishi-tyre-model-delete/{id}', [AdminEnd::class, 'tyre_model_delete']);
    Route::get('krishi-tyre-specification', [AdminEnd::class, 'tyre_specification']);
    Route::post('krishi-tyre-specification-submit', [AdminEnd::class, 'tyre_specification_submit']);
    Route::get('krishi-tyre-specification-edit/{id}', [AdminEnd::class, 'tyre_specification_edit']);
    Route::post('krishi-tyre-specification-update', [AdminEnd::class, 'tyre_specification_update']);
    Route::get('krishi-tyre-specification-delete/{id}', [AdminEnd::class, 'tyre_specification_delete']);
    Route::get('krishi-tyre-post-list', [AdminEnd::class, 'tyre_post_list']);
    Route::get('krishi-tyre-post-view/{id}', [AdminEnd::class, 'tyre_post_view']);
    Route::post('krishi-tyre-status-change', [AdminEnd::class, 'tyre_status_change']);
    Route::get('krishi-tyre-post-delete/{id}', [AdminEnd::class, 'tyre_post_delete']);
    Route::post('tyre-filter-data', [AdminEnd::class, 'tyre_filter_data']);
    Route::post('brand-to-model', [AdminEnd::class, 'brand_to_model']);

    Route::get('krishi-seller-list', [AdminEnd::class, 'get_seller_details']);
    Route::post('krishi-seller-list', [AdminEnd::class, 'searchSeller']);
    Route::get('krishi-referral-code-list', [AdminEnd::class, 'referral_code_list']);
    Route::get('krishi-referral-code-user', [AdminEnd::class, 'krishi_referral_code_user']);
    Route::get('krishi-seller-details/{id}', [AdminEnd::class, 'seller_details']);
    Route::get('krishi-profile', [AdminEnd::class, 'profile']);
    Route::get('krishi-setting', [AdminEnd::class, 'setting']);
    Route::get('krishi-dashboard', [AdminEnd::class, 'dashboard']);
    Route::post('krishi-profile-submit', [AdminEnd::class, 'profile_submit']);
    Route::post('dashboard-data', [AdminEnd::class, 'dashboard_data']);

    Route::post('tractor-update', [AdminEnd::class, 'tractor_update'])->name('tractor.update');
    Route::post('gv-update', [AdminEnd::class, 'gv_update'])->name('gv.update');
    Route::post('harvester-update', [AdminEnd::class, 'harvester_update'])->name('harvester.update');
    Route::post('implements-update', [AdminEnd::class, 'implements_update'])->name('implements.update');
    Route::post('seeds-update', [AdminEnd::class, 'seeds_update'])->name('seeds.update');
    Route::post('pesticides-update', [AdminEnd::class, 'pesticides_update'])->name('pesticides.update');
    Route::post('fertilizer-update', [AdminEnd::class, 'fertilizer_update'])->name('fertilizer.update');
    Route::post('tyre-update', [AdminEnd::class, 'tyre_update'])->name('tyre.update');

    Route::get('push-notification', [AdminEnd::class, 'push_notification']);
    Route::post('notification-schedule', [AdminEnd::class, 'notification_schedule']);
    Route::get('notification-schedule-list', [AdminEnd::class, 'notification_schedule_list']);
    Route::get('push-notification-deactive/{id}', [AdminEnd::class, 'push_notification_deactive']);
    Route::get('push-notification-update/{id}', [AdminEnd::class, 'push_notification_update']);
    Route::post('notification-schedule-update', [AdminEnd::class, 'notification_schedule_update']);

    Route::post('krishi-transfer-to', [AdminEnd::class, 'transfer_to']);
    Route::get('push-notification-send', [AdminEnd::class, 'push_notification_send']);

    /* only Season and Crop Show */
    Route::get('krishi-season-list', [CropCalenderController::class, 'season_page_show']);
    Route::get('krishi-season-edit', [CropCalenderController::class, 'season_edit_page_show']);
    Route::get('krishi-season-crop-calender-list', [CropCalenderController::class, 'season_crop_page_show']);
    Route::get('krishi-season-crop-edit-calender-list', [CropCalenderController::class, 'season_crop_edit_page_show']);

    /** Season Add Data */
    Route::post('krishi-add-seasons', [CropCalenderController::class, 'addSeasons']);
    Route::get('krishi-season-list', [CropCalenderController::class, 'readSeason']);
    Route::get('krishi-delete-seasons/{seasonId}', [CropCalenderController::class, 'seasonDelete']);
    Route::get('krishi-season-edit/{seasonId}', [CropCalenderController::class, 'seasonEdit']);
    Route::post('krishi-update-seasons/{seasonId}', [CropCalenderController::class, 'seasonUpdate']);

    /** Season Crop Add Data */
    Route::post('krishi-add-seasons-crop', [CropCalenderController::class, 'addSeasonCrop']);
    Route::get('krishi-season-crop-calender-list', [CropCalenderController::class, 'getSeasonCropData']);
    Route::get('krishi-delete-seasons-crop/{seasonId}', [CropCalenderController::class, 'seasonCropDelete']);
    Route::get('krishi-edit-seasons-crop/{seasonId}', [CropCalenderController::class, 'seasonCropEdit']);
    Route::post('krishi-update-seasons-crop/{seasonId}', [CropCalenderController::class, 'seasonCropUpdate']);

    /** Company Dealer */
    Route::get('krishi-dealer-company-list', [CropCalenderController::class, 'dealer_company_page_show']);
    Route::get('krishi-dealer-product-list', [CropCalenderController::class, 'dealer_product_page_show']);

    /** Company Page Show  */
    Route::get('krishi-add-company', [CompanyController::class, 'company_page_show']);
    Route::get('krishi-edit-company', [CompanyController::class, 'company_edit_page_show']);

    /** Company Add Data */
    Route::post('krishi-add-company-data', [CompanyController::class, 'addCompany']);
    Route::get('krishi-add-company', [CompanyController::class, 'getAllCompany']);
    Route::get('krishi-delete-company/{companyId}', [CompanyController::class, 'companyDelete']);
    Route::get('krishi-edit-company/{companyId}', [CompanyController::class, 'companyEdit']);
    Route::post('krishi-update-company-data/{companyId}', [CompanyController::class, 'companyUpdate']);

    Route::get('krishi-dealer-company-list/{companyId}', [CompanyController::class, 'getAllDealersData']);
    Route::get('krishi-dealer-product-list/{companyId}', [CompanyController::class, 'getProductData']);

    Route::post('get-district-name', [PincodeController::class, 'getDistrictName'])->name('district.to.district'); //state-to-district
    Route::post('get-city-name', [PincodeController::class, 'getCityName'])->name('district.to.city'); //state-to-district

    /** User List */
    Route::get('/user-list', [SubscriptionController::class, 'user_list']);
    Route::get('/user-details/{user_id}', [SubscriptionController::class, 'user_details']);
    Route::post('/user-update/{user_id}', [SubscriptionController::class, 'user_details_update']);

    Route::post('/add-boost-payment/{category_name}/{product_id}', [BoostController::class, 'boostPayment'])->name('boost-form');
    Route::get('/boost-otp-sent/{category}/{product_id}', [BoostController::class, 'otp_sent']);
});

Route::get('campaign', [AdminEnd::class, 'campaign_page']);
Route::post('campaign', [AdminEnd::class, 'campaign_submit']);
Route::get('krishi-login', [AdminEnd::class, 'login']);
Route::post('krishi-login', [AdminEnd::class, 'login_submit']);
Route::get('krishi-logout', [AdminEnd::class, 'logout']);
Route::get('push-notification-test', [AdminEnd::class, 'test1']);

/**************** Website *************/

Route::middleware(['ipauth'])->group(function () {
    Route::get('/', [FrontEnd::class, 'index_test']);

    Route::get('/ifco-dealer-page', [iffco::class, 'iffco_dealer_page_show']);
    Route::get('/iffco-product-page', [iffco::class, 'iffco_product_page_show']);
    Route::get('iffco-dealer-page/{companyName}/{productId}', [iffco::class, 'iffco_counter1']);
    Route::post('ifco-dealer-tracking/{call}/{dealerId}', [iffco::class, 'iffco_dealer_tracking']);

    #language
    Route::get('en', [FrontEnd::class, 'en_lang']);
    Route::get('hn', [FrontEnd::class, 'hn_lang']);
    Route::get('bn', [FrontEnd::class, 'bn_lang']);

    Route::get('contact', [FrontEnd::class, 'contact']);
    Route::get('privacypolicy', [FrontEnd::class, 'privacy_policy'])->name('privacypolicy');
    Route::get('privacy-policy', [FrontEnd::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('terms-condition', [FrontEnd::class, 'terms_condition'])->name('terms-condition');
    Route::get('about-us', [FrontEnd::class, 'about_us'])->name('about-us');
    Route::get('data-privacy', [FrontEnd::class, 'data_privacy'])->name('data-privacy');

    Route::get('index', [FrontEnd::class, 'index_test']);
    Route::get('get-location', [FrontEnd::class, 'get_location']);
    Route::post('get-location', [FrontEnd::class, 'get_location']);
    Route::get('index-test', [FrontEnd::class, 'index_test']);
    Route::post('valid-pincode', [FrontEnd::class, 'valid_pincode'])->name('valid.pincode');
    Route::post('pincode-put', [FrontEnd::class, 'pincode_put'])->name('pincode.put');
    Route::post('login-user', [FrontEnd::class, 'login_user'])->name('login');
    Route::post('otp-check', [FrontEnd::class, 'otp_check'])->name('otp.check');
    Route::get('logout', [FrontEnd::class, 'logout'])->name('logout');
    Route::post('pincode-state-city-district', [FrontEnd::class, 'pincode_state_city_district'])->name('pincode.state.city.district');
    Route::post('register-sendotp', [FrontEnd::class, 'register_sendotp'])->name('register.sendotp');
    Route::post('register-user', [FrontEnd::class, 'register_user'])->name('register');

    Route::get('profile', [FrontEnd::class, 'profile'])->name('profile');
    Route::post('profile-update', [FrontEnd::class, 'profile_update'])->name('profile.update');
    Route::post('profileSettings-update', [FrontEnd::class, 'profileSettings_update'])->name('profileSettings.update');
    Route::post('image_update', [FrontEnd::class, 'image_update'])->name('imageUpdate');

    Route::get('my-tractor', [FrontEnd::class, 'my_tractor'])->name('my.tractor');
    Route::get('my-goods_vehicle', [FrontEnd::class, 'my_goods_vehicle'])->name('my.goods_vehicle');
    Route::get('my-harvester', [FrontEnd::class, 'my_harvester'])->name('my.harvester');
    Route::get('my-implements', [FrontEnd::class, 'my_implements'])->name('my.implements');
    Route::get('my-tyres', [FrontEnd::class, 'my_tyres'])->name('my.tyres');
    Route::get('my-seeds', [FrontEnd::class, 'my_seeds'])->name('my.seeds');
    Route::get('my-pesticides', [FrontEnd::class, 'my_pesticides'])->name('my.pesticides');
    Route::get('my-fertilizers', [FrontEnd::class, 'my_fertilizers'])->name('my.fertilizers');

    Route::get('wishlist', [FrontEnd::class, 'wishlist'])->name('wishlist');
    Route::post('wishlist', [FrontEnd::class, 'item_wishlist'])->name('item.wishlist');

    Route::post('brand-to-model', [FrontEnd::class, 'brand_to_model'])->name('brand.to.model');
    Route::post('state-to-district', [FrontEnd::class, 'state_to_district'])->name('state.to.district');

    Route::get('tractor-post', [FrontEnd::class, 'tractor_post'])->name('tractor.post');
    Route::post('tractor-posting', [FrontEnd::class, 'tractor_posting']);
    Route::get('tractor/{id}', [FrontEnd::class, 'tractor_product']);
    Route::get('tractor-list/{type}', [FrontEnd::class, 'tractor_list']);
    Route::post('tractor-filter/{type}', [FrontEnd::class, 'tractor_filter'])->name('tractor.filter');
    Route::get('tractor-filter', [FrontEnd::class, 'tractor_filter']);
    Route::get('tractor-filter/{type}/{sort}', [FrontEnd::class, 'tractorFilterData']);

    Route::get('good-vahicle/{id}', [FrontEnd::class, 'gv_product']);
    Route::get('good-vahicle-post', [FrontEnd::class, 'good_vahicle_post'])->name('gv.post');
    Route::post('good-vahicle-posting', [FrontEnd::class, 'good_vahicle_posting']);
    Route::get('good-vehicle-list/{type}', [FrontEnd::class, 'good_vehicle_list']);
    Route::get('good-vehicle-filter', [FrontEnd::class, 'good_vehicle_filter']);
    Route::get('good-vehicle-filter/{type}/{sort}', [FrontEnd::class, 'good_vehicle_filter_data']);
    Route::post('good-vehicle-filter/{type}', [FrontEnd::class, 'good_vehicle_filter'])->name('gv.filter');

    Route::get('harvester-post', [FrontEnd::class, 'harvester_post'])->name('harvester.post');
    Route::post('harvester-posting', [FrontEnd::class, 'harvester_posting']);
    Route::get('harvester/{id}', [FrontEnd::class, 'harvester_product']);
    Route::get('harvester-list/{type}', [FrontEnd::class, 'harvester_list']);
    Route::post('harvester-filter', [FrontEnd::class, 'harvester_filter'])->name('harvester.filter');
    Route::get('harvester-filter', [FrontEnd::class, 'harvester_filter']);
    Route::get('harvester-filter/{sort}/{type}', [FrontEnd::class, 'harvesterFilterData']);

    Route::get('implement-post', [FrontEnd::class, 'implements_post'])->name('implement.post');
    Route::post('implement-posting', [FrontEnd::class, 'implements_posting']);
    Route::get('implements/{id}', [FrontEnd::class, 'implements_product']);
    Route::get('implements-list/{type}', [FrontEnd::class, 'implements_list']);
    Route::post('implemets-filter', [FrontEnd::class, 'implemets_filter'])->name('implemets.filter');
    Route::get('implemets-filter', [FrontEnd::class, 'implemets_filter']);
    Route::get('implemets-filter/{sort}/{type}', [FrontEnd::class, 'implementsFilterData']);

    Route::get('seeds-post', [FrontEnd::class, 'seeds_post'])->name('seeds.post');
    Route::post('seeds-posting', [FrontEnd::class, 'seeds_posting']);
    Route::get('seed/{id}', [FrontEnd::class, 'seed_product']);
    Route::get('seed-list', [FrontEnd::class, 'seeds_list']);
    Route::post('seed-filter', [FrontEnd::class, 'seed_filter'])->name('seed.filter');
    Route::get('seed-filter', [FrontEnd::class, 'seed_filter']);
    Route::get('seed-filter/{sort}', [FrontEnd::class, 'seedsFilterData']);

    Route::get('pesticide-post', [FrontEnd::class, 'pesticide_post'])->name('pesticide.post');
    Route::post('pesticide-posting', [FrontEnd::class, 'pesticide_posting']);
    Route::get('pesticides/{id}', [FrontEnd::class, 'pesticides_product']);
    Route::get('pesticides-list', [FrontEnd::class, 'pesticides_list']);
    Route::post('pesticides-filter', [FrontEnd::class, 'pesticides_filter'])->name('pesticides.filter');
    Route::get('pesticides-filter', [FrontEnd::class, 'pesticides_filter']);
    Route::get('pesticides-filter/{sort}', [FrontEnd::class, 'pesticidesFilterData']);

    Route::get('fertilizer-post', [FrontEnd::class, 'fertilizer_post'])->name('fertilizer.post');
    Route::post('fertilizer-posting', [FrontEnd::class, 'fertilizer_posting']);
    Route::get('fertilizers/{id}', [FrontEnd::class, 'fertilizers_product']);
    Route::get('fertilizer-list', [FrontEnd::class, 'fertilizer_list']);
    Route::post('fertilizer-filter', [FrontEnd::class, 'fertilizer_filter'])->name('fertilizer.filter');
    Route::get('fertilizer-filter', [FrontEnd::class, 'fertilizer_filter']);
    Route::get('fertilizer-filter/{sort}', [FrontEnd::class, 'fertilizerFilterData']);

    Route::get('tyre-post', [FrontEnd::class, 'tyre_post'])->name('tyre.post');
    Route::post('tyre-posting', [FrontEnd::class, 'tyre_posting']);
    Route::get('tyre/{id}', [FrontEnd::class, 'tyre_product']);
    Route::get('tyre-list/{type}', [FrontEnd::class, 'tyre_list']);
    Route::post('tyre-filter', [FrontEnd::class, 'tyre_filter'])->name('tyre.filter');
    Route::get('tyre-filter', [FrontEnd::class, 'tyre_filter']);
    Route::get('tyre-filter/{sort}/{type}', [FrontEnd::class, 'tyreFilterData']);

    Route::get('iffco-product', [FrontEnd::class, 'iffco_product']);
    Route::get('iffco-dealer', [FrontEnd::class, 'iffco_dealer']);

    Route::get('sitemap.xml', function () {
        return response()->view('sitemap')->header('Content-Type', 'xml');
    });

    Route::get('/crop-calendar', [ContentController::class, 'showCategorySelection']);
    Route::get('/crop-content/{category}/{subcategory}', [ContentController::class, 'showContent']);

    Route::get('contact', [FrontEnd::class, 'contact']);

    // Route::get('weather-report' , [WeatherController::class,'weatherReportDays']);

});

Route::get('/brand-product/{category}/{type}/{brandId}', [BandProductController::class, 'brandNameCategoryWish']);
Route::post('/filter-brand/{category}/{type}/{brandId}', [BandProductController::class, 'filterDataBrandName']);

Route::get('/company-product/{category}/{type}/{companyId}', [BandProductController::class, 'getCompanyProduct']);
Route::get('/dealer-company-page/{companyId}', [BandProductController::class, 'dealerPageCompany']);
Route::post('/search-company-product/{category}/{companyId}', [BandProductController::class, 'searchCompanyProduct']);

/** Add Pincode In Pincode Page */
Route::get('krishi-add-pincode', [TestController::class, 'adminPincodePage']);
Route::get('krishi-add-pincode', [TestController::class, 'getStateName']);
Route::get('krishi-edit-pincode/{cityId}', [PincodeController::class, 'editPinCodePage']);
Route::post('add-pin-code', [PincodeController::class, 'addPinCode']);
Route::post('update-pincode/{cityId}', [PincodeController::class, 'updatePinCode']);
Route::get('delete-pincode/{cityId}', [PincodeController::class, 'deletePincode']);

/** Web Filter */
Route::post('brand-to-model-data', [WebFilterController::class, 'getBrandModelData'])->name('brand.to.model.data');

/** Dibyendu Create  Page in Admin */
Route::get('ads-banner-list', [AdsBannerCotroller::class, 'get_all_ads_banner']);
Route::post('update-banner-status/{lead_id}', [AdsBannerCotroller::class, 'updateBannerStatus']);
Route::get('ad-banner-details/{banner_id}', [AdsBannerCotroller::class, 'get_banner_details_page']);

Route::post('update-banner-status/{lead_id}', [AdsBannerCotroller::class, 'updateBannerStatus']);

Route::match(['get', 'post'], '/update-ads-banner-status/{type}/{banner_id}', [AdsBannerCotroller::class, 'update_ads_banner_status']);

Route::get('subscription-boots-list', [SubscriptionController::class, 'subscribe_boots']);
Route::get('subscription-boots-details/{subscribe_boots_id}', [SubscriptionController::class, 'subscribe_boost_details_page']);
Route::post('update-product-boost-status/{user_id}', [SubscriptionController::class, 'updateProductBoostStatus']);
Route::get('subscription-plan', [SubscriptionController::class, 'get_subscription_details']);
Route::get('subscription-feature/{subscription_id}', [SubscriptionController::class, 'get_subscription_feature_details']);
Route::get('subscribed-user', [SubscriptionController::class, 'get_subscribed_list']);
Route::get('subscribed-user-details/{subscribed_id}', [SubscriptionController::class, 'getSubscribedUserDetails']);

Route::get('subscribed-user-details/{subscribed_id}', [SubscriptionController::class, 'getSubscribedUserDetails']);

Route::get('/manage-ads', function () {
    return view('admin.ads_manager.manage_ads');
});

Route::get('/ads-list', function () {
    return view('admin.ads_manager.ads_list');
});

// weather path
Route::get('/kv-weather-forecast', function () {
    return view('front.development.weather');
});

Route::get('/mahindra-all-product', function () {
    return view('front.development.mahindra-product');
});

Route::get('/subscription', function () {
    return view('front.development.subscription');
});

Route::get('/myposts', function () {
    return view('front.development.mypost');
});

Route::get('/myboosts', function () {
    return view('front.development.myboost');
});

Route::get('/mybanners', function () {
    return view('front.development.mybanners');
});

Route::get('/banner-subscription', function () {
    return view('admin.banner_subscription.banner_pricing_details');
});

Route::get('/new-promotion', function () {
    return view('admin.promotions.new_promotions');
});

Route::get('/edit-promotion', function () {
    return view('admin.promotions.edit_promotion');
});

// Route::get('/seller_lead_by_category', function() {
//     return view('admin.seller_lead.seller_lead_by_category');
// });

// Route::get('/seller_post_list', function() {
//     return view('admin.seller_lead.seller_post_list');
// });

// Route::get('/seller_lead_list_details', function() {
//     return view('admin.seller_lead.seller_lead_list_details');
// });




//Route::post('search-mobile'                        , [AdminEnd::class,'searchUserMobile']);
Route::post('new-promotion'                        , [AdminEnd::class,'searchUserMobile']);
Route::post('add-promotion-coupon'                 , [AdminEnd::class,'addPromotionCoupon']);
Route::any('invoice-promotion/{promotionId}'       , [AdminEnd::class,'promotionInvoice']);
Route::get('/promotion-list'                       , [AdminEnd::class,'get_promotion_list']);
Route::get('/single-promotion/{id}'                , [AdminEnd::class,'single_promotion_details']);
Route::post('update-due-amount/{promotion_id}'     , [AdminEnd::class,'updateDueAmount']);

Route::post('/get-package-price', [AdminEnd::class, 'getPackagePrice'])->name('get.package.price');
Route::get('/edit-promotion/{promotionId}', [AdminEnd::class, 'editPromotion']);
Route::post('/update-promotion/{promotionId}', [AdminEnd::class, 'updatePromotion']);

Route::get('invoice-data/{invoice_type}/{id}', [AdminEnd::class, 'getInvoiceData']);
Route::get('product-boosts-invoice-data/{id}', [AdminEnd::class, 'getProductBoostsInvoiceData']);
Route::get('invoice-offline-boost/{product_id}', [BoostController::class, 'boostInvoice']);
Route::post('/add-offline-lead/{category_id}/{post_id}/{user_id}', [OfflineLeadController::class, 'addOfflineLead']);
Route::post('/promotion-total-amount', [AdminEnd::class, 'promotionTotalAmount'])->name('promotion.total.amount');

# CROPS
Route::get('add-krishi-crops-post'                                   , [CropController::class,'addCropPage']);
Route::get('krishi-crops-banner-post/{crops_subscribed_id}'          , [CropController::class,'addCropBannerPage']);
Route::get('add-krishi-subscribed-crops-post/{crops_subscribed_id}'  , [CropController::class,'addSubscribedCropPage']);

Route::get('edit-krishi-crops-post'                           , [CropController::class,'editCropPage']);
Route::get('crops-post-list'                                  , [CropController::class,'cropListPage']);
Route::get('crops-post-details/{crops_id}'                    , [CropController::class,'cropPostDetailsPage']);
Route::get('crops-otp-page'                                   , [CropController::class,'cropOtpPage']);
Route::get('crops-invoice/{crops_subscribed_id}'              , [CropController::class,'cropInvoicesPage']);
Route::get('crops-boost/{crops_subscribed_id}/{crop_id}'      , [CropController::class,'cropsBoostPage']);
Route::get('crops-banner/{crops_subscribed_id}'               , [CropController::class,'cropsBannerPage']);
Route::get('crops-category-list'                              , [CropController::class,'cropsCategoryListPage']);
Route::get('crops-category-wish-product/{crops_category_id}'  , [CropController::class,'cropsCategoryWishProductPage']);
Route::get('crops-banner-list'                                , [CropController::class,'cropsBannerListPage']);
Route::get('crops-banner-details/{crops_banner_id}'           , [CropController::class,'cropsBannerDetailsPage']);
Route::get('crops-boost-list'                                 , [CropController::class,'cropsBoostListPage']);
Route::get('krishi-subscribed-crops-post-list'                , [CropController::class,'cropsPostList']);
Route::get('crops-banner-list-wish-subscribed/{subscribedId}' , [CropController::class,'cropsBannerListWishSubscribedId']);
Route::get('crops-post-list-wish-subscribed/{subscribedId}'   , [CropController::class,'cropsPostListWishSubscribedId']);
Route::post('search-crop-user'                                      , [CropController::class,'searchCropUserMobile']);
Route::post('verify-crops-data'                                     , [CropController::class,'verifyCropsData']);
Route::post('add-crop-boost/{crops_subscribed_id}'                  , [CropController::class,'addCropBoost']);
Route::post('add-crop-banner/{crops_subscribed_id}'                 , [CropController::class,'addCropBanner']);
Route::post('crop-banner-lead-update/{crops_banner_id}'             , [CropController::class,'update_crops_banner_lead']);
Route::post('verify-subscribed-crops-data/{crops_subscribed_id}'     , [CropController::class,'verifySubscribedCropsData']);

Route::get('seller-category-list'                       , [SellerLeadController::class,'allCategoryList']);
Route::get('category-wish-product-list/{categoryId}'    , [SellerLeadController::class,'categoryWishProductList']);
Route::get('seller-lead-list/{seller_id}'               , [SellerLeadController::class,'allSellerList']);
