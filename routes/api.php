<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginAPI;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api2;

use App\Http\Controllers\API\Leadapi;

use App\Http\Controllers\Chat;
use App\Http\Controllers\iffco;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\BandProductController;

use App\Http\Controllers\FilterController;
use App\Http\Controllers\API\FilterBKController;

use App\Http\Controllers\TestController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\API\LocationControllerApi as LCA;

use App\Http\Controllers\API\Category\TractorController as TC;
use App\Http\Controllers\API\Category\GVController as GC;
use App\Http\Controllers\API\Category\HarvesterController as HC;
use App\Http\Controllers\API\Category\ImplementsController as IC;
use App\Http\Controllers\API\Category\SeedController as SC;
use App\Http\Controllers\API\Category\PesticidesController as PC;
use App\Http\Controllers\API\Category\FertilizerController as FC;
use App\Http\Controllers\API\Category\TyreController as TyC;
use App\Http\Controllers\API\Subscription\SubcriptionController;
use App\Http\Controllers\API\Subscription\Ads_banner;
use App\Http\Controllers\API\Subscription\Boost;
use App\Http\Controllers\API\Notification\NotificationController as NC;
use App\Http\Controllers\API\MahindraCompany;
use App\Http\Controllers\API\Category\CropController;

# Crops controller
use App\Http\Controllers\Crop\CropController as Crop;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
    Route::get('/', function () {
    // echo 1;
        return view('welcome');
    });

    Route::post('test-report'             , [NC::class,'user_send_email']);

    /** State Name Add Pincode  */
    Route::post('get-district-name'            , [TestController::class ,'getDistrictName']);
    Route::get('weather-report'                , [WeatherController::class,'getWeather']);
    Route::get('mahindra-all-product'          , [MahindraCompany::class,'mahindra_all_product_show']);
    Route::get('all-product-list-mahindra'     , [MahindraCompany::class,'all_product_list_mahindra']);
    // Route::post('test-category'            , [TestController::class   ,'category_test']);

    Route::post('generate-order-id'       , [SubcriptionController::class,'generate_order_id']);

    Route::get('maintenance'              , [Api2::class,'maintenance']);
    Route::post('language-save'           , [Api2::class,'language_save']);
    Route::post('push-notification-list'  , [API::class,'push_notification_list']);

    Route::post('login-check'             , [API::class, 'login_check']);
    Route::get('watermark'                , [Api2::class, 'watermark']);
    Route::post('pincode-check'           , [Api2::class, 'pincode_check']);
    // Route::post('pincode_track'           , [Api2::class,'pincode_track']);
    Route::post('pincode-multiplecity'    , [Api2::class, 'pincode_multiplecity']);
    Route::post('get-lat-long'            , [Api2::class, 'get_lat_long']);


    Route::controller(LoginAPI::class)->group(function () {
        Route::post('login-check', 'login_check');
        Route::post('otp', 'otp');
        Route::post('login','login');
        Route::post('login-test','login_test');
        Route::post('regdata','regdata');
        Route::post('user-disabled','user_disabled');
        Route::post('user-enable','user_enable');
    });


    Route::middleware('auth:sanctum')->group(function () 
    {
        Route::prefix('crops')->group(function () {
            Route::controller(CropController::class)->group(function(){
                Route::post('crops-category','getCropsCategory');
                Route::post('crops-sub-category','getCropsSubCategory');
                Route::post('crops-packages','getCropPackages');
                Route::post('add-crops','postCrops');
                Route::post('update-crops','updateCrops');
                Route::post('subscription','getSubscription');
                Route::post('crops-subscription-payment','cropSubscriptionPayment');
                Route::post('crops-invoice','getCropInvoiceDetails');
                Route::post('my-crops','getMyCrops');
                Route::post('my-crops-details','getMyCropDetails');
                Route::post('crops-list','getAllCrops');
                Route::post('crops-data','cropsDistance');
                Route::post('crops-by-id','cropsById');
                Route::post('my-crops-subscription','myCropsSubscription');
                Route::post('crops-boost','cropsBoosts');
                Route::post('crops-boost-list','cropsBoostsList');
                Route::post('add-crops-banner','addCropsBanner');
                Route::post('crops-banner-list','cropsBannerList');
                
                # DIBYENDU CHANGE
                Route::post('total-crop-product-lead','total_crops_product_leads');
                Route::post('total-crop-banner-lead','total_crops_banner_leads');
                Route::post('crop-banner-id-by-lead','crops_banner_id_by_lead');
                Route::post('crop-banner-delete','crops_banner_delete');
                Route::post('crop-banner-update','crop_banner_update');
            });
        });


        Route::post('my-product-leads-user-list'   , [SubcriptionController::class ,'my_product_lead_user_list']);
        Route::post('my-banner-leads-user-list'    , [SubcriptionController::class ,'my_banner_lead_user_list']);
        Route::post('my-enquiry'                   , [SubcriptionController::class ,'my_enquiry']);
        Route::post('post-category-wish-details'   , [TestController::class ,'user_post_details']);

        # Dibyendu 
        Route::post('category-wish-banner-boost-product'   , [TestController::class ,'category_wish_Banner_boost_product']);

        Route::post('update-lat-long'             , [LoginAPI::class ,'update_lat_log_login']);
        Route::post('user_token_update'           , [Api2::class,'user_token_update']);
       
        Route::get('state'                        , [LCA::class, 'state']);
        Route::post('district'                    , [LCA::class, 'district']);
        Route::post('city'                        , [LCA::class, 'city']);
        Route::post('state-counter'               , [LCA::class, 'state_counter']);
        Route::post('state-district'              , [LCA::class, 'state_district']);
        Route::post('pincode-track'               , [LCA::class, 'pincode_wish_data_show']);
        Route::post('pincode-add'                 , [LCA::class, 'add_pincode_with_login']);

        Route::get('category'                     , [API::class, 'category']);
        Route::post('price-counter'               , [API::class, 'price_counter']);
        Route::post('state-counter'               , [API::class, 'state_counter']);
        Route::post('state-district'              , [API::class, 'state_district']);
        Route::get('state'                        , [API::class, 'state']);
        Route::post('district'                    , [API::class, 'district']);
        Route::post('price-counter'               , [API::class, 'price_counter']);
        Route::post('city'                        , [API::class, 'city']);
        Route::post('brand'                       , [API::class, 'brand']);
        Route::post('model'                       , [API::class, 'model']);
        Route::post('master-brand'                , [API::class, 'master_brand']);
        Route::post('master-brand-view-all'       , [API::class, 'master_brand_view_all']);
        Route::post('master-brand-data'           , [API::class, 'master_brand_data']);

        # Tractor
        Route::post('tractor'                     , [TC::class, 'tractor']);
        Route::post('tractor-add'                 , [TC::class, 'tractor_add']);
        Route::post('tractor-by-id'               , [TC::class, 'tractor_by_id']);
        Route::post('tractor-other-district'      , [TC::class, 'tractor_other_district']);
        Route::post('tractor-data'                , [TC::class ,'tractorDistance']);
        Route::post('tractor-update'              , [TC::class,'tractor_update']);

        # Good Vehicle
        Route::post('gv-add'                      , [GC::class, 'gv_add']);
        Route::post('gv'                          , [GC::class, 'gv']);
        Route::post('gv-other-district'           , [GC::class, 'gv_other_district']);
        Route::post('gv-by-id'                    , [GC::class, 'gv_by_id']);
        Route::post('gv-data'                     , [GC::class, 'goodVehicleDistance']);
        Route::post('gv-update'                   , [GC::class, 'gv_update']);

        # Harvester
        Route::post('harvester'                   , [HC::class, 'harvester']);
        Route::post('harvester-other-district'    , [HC::class, 'harvester_other_district']);
        Route::post('harvester-by-id'             , [HC::class, 'harvester_by_id']);
        Route::post('harvester-add'               , [HC::class, 'harvester_add']);
        Route::post('harvester-data'              , [HC::class, 'harvesterDistance']);
        Route::post('harvester-update'            , [HC::class, 'harvester_update']);

        # Implements
        Route::post('implements'                  , [IC::class, 'implements']);
        Route::post('implements-other-district'   , [IC::class, 'implements_other_district']);
        Route::post('implements-by-id'            , [IC::class, 'implements_by_id']);
        Route::post('implements-add'              , [IC::class, 'implements_add']);
        Route::post('implements-data'             , [IC::class ,'implementDistance']);
        Route::post('implements-update'           , [IC::class,'implements_update']);

        # Seeds
        Route::post('seeds'                       , [SC::class, 'seeds']);
        Route::post('seeds-other-district'        , [SC::class, 'seeds_other_district']);
        Route::post('seeds-by-id'                 , [SC::class, 'seeds_by_id']);
        Route::post('seeds-add'                   , [SC::class, 'seeds_add']);
        Route::post('seed-data'                   , [SC::class ,'seedDistance']);
        Route::post('seed-update'                 , [SC::class,'seed_update']);

        # Pesticides
        Route::post('pesticides'                  , [PC::class, 'pesticides']);
        Route::post('pesticides-other-district'   , [PC::class, 'pesticides_other_district']);
        Route::post('pesticides-by-id'            , [PC::class, 'pesticides_by_id']);
        Route::post('pesticides-add'              , [PC::class, 'pesticides_add']);
        Route::post('pesticides-data'             , [PC::class, 'pesticidesDistance']);
        Route::post('pesticides-update'           , [PC::class, 'pesticides_update']);

        # Fertilizer
        Route::post('fertilizer'                  , [FC::class, 'fertilizer']);
        Route::post('fertilizer-other-district'   , [FC::class, 'fertilizer_other_district']);
        Route::post('fertilizer-by-id'            , [FC::class, 'fertilizer_by_id']);
        Route::post('fertilizer-add'              , [FC::class, 'fertilizer_add']);
        Route::post('fertilizer-data'             , [FC::class ,'fertilizersDistance']);
        Route::post('fertilizer-update'           , [FC::class,'fertilizer_update']);

        # Tyres
        Route::post('tyre'                        , [TyC::class, 'tyre']);
        Route::post('tyre-other-district'         , [TyC::class, 'tyre_other_district']);
        Route::post('tyre-by-id'                  , [TyC::class, 'tyre_by_id']);
        Route::post('tyre-add'                    , [TyC::class, 'tyre_add']);
        Route::post('tyre-data'                   , [TyC::class, 'tyreDistance']);
        Route::post('tyre-update'                 , [TyC::class, 'tyre_update']);

        Route::post('profile'                     , [API::class, 'profile']);
        Route::post('profile2'                    , [API2::class, 'profile']);
        Route::post('update-promotional-status'   , [API2::class, 'updatePromotionalStatus']);
        Route::post('check-coupon'                , [API2::class, 'checkCoupon']);
        Route::post('boosts-coupon-product'       , [API2::class, 'boostsCouponProduct']);


        Route::post('sponserer-profile'           , [API2::class, 'sponserer_profile']);
        Route::post('user-posts'                  , [API2::class, 'user_posts']);
        Route::post('new-boosts'                  , [API2::class, 'getNewBoosts']);
        
        Route::post('wishlist-add'                , [API::class, 'wishlist_add']);
        Route::post('wishlist'                    , [API::class, 'wishlist']);
        Route::post('delete-wishlist'             , [API::class, 'delete_wishlist']);

        Route::post('mark-as-sold'                , [API::class,'mark_as_sold']);
        Route::post('post-disabled'               , [API::class,'post_disabled']);

        Route::post('banner'                      , [Api2::class,'banner']);
        Route::get('settings'                     , [Api2::class, 'settings']);
        Route::post('settings-promotion'          , [Api2::class, 'settings_promotion']);
        Route::post('product-sharing'             , [Api2::class, 'product_sharing']);

        Route::post('search'                      , [API::class, 'search']);
        Route::post('search-result'               , [API::class, 'search_result']);
        Route::post('search-store'                , [API::class, 'search_store']);
        Route::post('search-history'              , [API::class, 'search_history']);

        /*===================================================================================*/

        //******** prefix routing **********/
        Route::prefix('admin')->group(function () {
            Route::get('/users', function () {
                echo '1';
            });
        });

        /********* same controller routing *****/
        Route::prefix('lead')->group(function () {
            Route::controller(LEADAPI::class)->group(function () {
                Route::post('lead-view-all', 'lead_view_all');
                Route::post('lead-view'    , 'lead_view');
                Route::post('lead-generate', 'lead_generate');
            });
        });

        Route::prefix('account')->group(function () {
            Route::controller(LEADAPI::class)->group(function () {
                //Route::post('app-open', 'app_open');
                Route::post('page-time-spend'     , 'page_time_spend');
                Route::post('active-user'         , 'active_user');
                Route::post('account-counter'     , 'account_counter');
                Route::post('my-post'             , 'my_post');
                Route::post('my-lead'             , 'my_lead');
                Route::post('my-enquery'          , 'my_enquery');
                Route::post('notification'        , 'notification');
                Route::post('banner-click-lead'   , 'banner_click_lead');
                Route::post('ad-leads'            , 'ad_leads');
                Route::post('my-seller-lead-view' , 'my_product_lead_view');
            });

            Route::controller(FilterBKController::class)->group(function(){
                Route::post('tractor-filter'     , 'tractor_filter');
                Route::post('rent-tractor-filter', 'rent_tractor_filter');
                Route::post('gd-filter'          , 'goods_vehicle_filter');
                Route::post('harvester-filter'   , 'harvester_filter');
                Route::post('implement-filter'   , 'implements_filter');
                Route::post('tyre-filter'        , 'tyre_filter');
                Route::post('seed-filter'        , 'seed_filter');
                Route::post('pesticides-filter'  , 'pesticides_filter');
                Route::post('fertilizers-filter' , 'fertilizers_filter');
            });
        });

        Route::post('category-filter' , [API::class,'filterByCategory']);

        Route::prefix('chat')->group(function () {
            Route::post('chat-send'    , [Chat::class, 'chat_send']);
            Route::post('chat-details' , [Chat::class, 'chat_details']);
            Route::post('chat-list'    , [Chat::class, 'chat_list']);
        });


        /********** iffco ***********/
        Route::prefix('iffco')->group(function () {
            Route::get('app-status-check' , [iffco::class, 'app_status_check']);
            Route::post('iffco-product'   , [iffco::class, 'iffco_product']);
            Route::post('iffco-couter'    , [iffco::class, 'iffco_counter']);
            Route::post('iffco-tracking'  , [iffco::class, 'iffco_tracking']);
        });

        /********** crop calender *********/
        Route::prefix('crop-calender')->group(function(){
            Route::post('season'       , [Api::class,'season']);
            Route::post('season-crop'  , [Api::class,'season_crop']);
        });

        /********** company *********/
        Route::prefix('company')->group(function(){
            Route::post('company'              , [Api::class, 'company']);
            Route::post('products'             , [Api::class, 'company_products']);
            Route::post('company-tracking'     , [Api::class, 'company_tracking']);
            Route::post('products-category-id' , [Api::class, 'products_category_id']);
            Route::post('dealer'               , [Api::class, 'company_dealer']);
        });

        /******** Filter In App *********/
        Route::post('brand-data-show'               , [FilterController::class ,'getBrandModelData']);
        Route::post('state-wish-district-show'      , [FilterController::class ,'stateWishDistrictName']);
        Route::post('year-of-purchase-data'         , [FilterController::class ,'getYear']);
        Route::post('price-max-min-data'            , [FilterController::class ,'getMaxMinPrice']);
        Route::post('tractor-filter'                , [FilterController::class ,'tractorFilter']);
        Route::post('gv-filter'                     , [FilterController::class ,'goodVehicleFilter']);
        Route::post('harvester-filter'              , [FilterController::class ,'harvesterFilter']);
        Route::post('implement-filter'              , [FilterController::class ,'implementFilter']);
        Route::post('tyre-filter'                   , [FilterController::class ,'tyreFilter']);
        Route::post('seed-filter'                   , [FilterController::class ,'seedFilter']);
        Route::post('pesticides-filter'             , [FilterController::class ,'pesticidesFilter']);
        Route::post('fertilizer-filter'             , [FilterController::class ,'fertilizerFilter']);

        #  My Product Post List
        Route::post('my-post-list'                  , [TestController::class,'my_post']);

        Route::post('notification-counter'          , [Api::class,'notification_counter']);
        Route::post('notification-open-count'       , [Api::class,'notification_open_count']);
        Route::post('chose-user-type'               , [Api::class,'choose_user_type']);
        Route::post('user1'                         , [Api::class,'user1']);

        # Subscription List
        Route::controller(SubcriptionController::class)->group(function(){ 
            Route::post('subscription-interest-record','subscription_interest_record');
            Route::get('subscription' , 'subscriptionDetails');
            Route::post('coupon' , 'coupon');
            Route::post('subscription-payment' , 'payment_subscription');
            Route::post('my-subscriptions','my_subscriptions');
            Route::post('invoice','invoice');
            Route::post('subscription-renewal','subscription_renew');
            Route::post('subscription-upgrade','subscription_upgrade');
        });

        # Banner Controller
        Route::controller(Ads_banner::class)->group(function(){ 
            Route::post('ads-banner-counter','ads_banner_counter');
            Route::post('ads_banner' , 'index');
            Route::post('banner-update' , 'banner_update');
            Route::post('banner-delete','banner_delete');
            Route::post('banner-list' , 'get_banner_list');
            Route::get('state-list' , 'state_name_get');
            Route::post('banner-position' , 'bannerPosition');
            Route::post('my-banner','my_banner');
            Route::post('pop-checker','pop_checker');

            Route::post('banner-lead','banner_lead');
            Route::post('total-banner-lead','total_banner_lead');
            Route::post('total-user-lead','total_user_lead');

            /** Dibyendu Add Post Details  */
            Route::post('post-details','lead_user_all_product_post_details');

        });

        # Product Boots
        Route::controller(Boost::class)->group(function(){ 
           // Route::post('user-posts','user_posts');
            Route::post('boost','boostDetails');
            Route::post('boost-payment','boost_payment');
            Route::post('boost-invoice','boost_invoice');
            Route::post('boost-all-product','boost_all_product');
        });

        # Notification Controller
        Route::controller(NC::class)->group(function(){
            Route::post('notification','notification');
            Route::post('n_banner_todays_login','n_banner_todays_login');
            Route::post('n_banner_state_user','n_banner_state_user');
            Route::post('n_banner_nearest_user','n_banner_nearest_user');
            Route::post('n_direct_lead','n_direct_lead');
        }); 

        # Mahindra Controller
        Route::prefix('mahindra')->group(function () {
            Route::controller(MahindraCompany::class)->group(function(){
                Route::post('all-product','all_product');
                Route::post('lead','add_lead');
                Route::post('user_feedback_save','user_feedback_save');
            }); 
        });
    });
});


//PREVIOUS VERSION API'S

Route::get('/', function () {
    // echo 1;
    return view('welcome');
});

Route::post('test-report'             , [NC::class,'user_send_email']);

/** State Name Add Pincode  */
Route::post('get-district-name'       , [TestController::class ,'getDistrictName']);
Route::get('weather-report'           , [WeatherController::class,'getWeather']);

Route::post('generate-order-id'       , [SubcriptionController::class,'generate_order_id']);

Route::get('maintenance'              , [Api2::class,'maintenance']);
Route::post('language-save'           , [Api2::class,'language_save']);
Route::post('push-notification-list'  , [API::class,'push_notification_list']);

Route::post('login-check'             , [API::class, 'login_check']);
Route::get('watermark'                , [Api2::class, 'watermark']);
Route::post('pincode-check'           , [Api2::class, 'pincode_check']);
// Route::post('pincode_track'           , [Api2::class,'pincode_track']);
Route::post('pincode-multiplecity'    , [Api2::class, 'pincode_multiplecity']);
Route::post('get-lat-long'            , [Api2::class, 'get_lat_long']);

// Route::get('subscription'            , [SubcriptionController::class, 'subscriptionDetails']);


Route::controller(LoginAPI::class)->group(function () {
    Route::post('login-check', 'login_check');
    Route::post('otp', 'otp');
    Route::post('login','login');
    Route::post('login-test','login_test');
    Route::post('regdata','regdata');
    Route::post('user-disabled','user_disabled');
    Route::post('user-enable','user_enable');
});


    # Dibyendu Create Date 07.02.2024
    Route::post('my-product-leads-user-list'   , [SubcriptionController::class ,'my_product_lead_user_list']);
    Route::post('my-banner-leads-user-list'    , [SubcriptionController::class ,'my_banner_lead_user_list']);
    Route::post('my-enquiry'                   , [SubcriptionController::class ,'my_enquiry']);

    //Route::post('post-category-wish-details'   , [TestController::class ,'user_post_details']);


    /** Dibyendu Add Lat & Log API */
    Route::post('update-lat-long' , [LoginAPI::class ,'update_lat_log_login']);

    Route::post('user_token_update'           , [Api2::class,'user_token_update']);
    Route::get('category'                     , [API::class, 'category']);
    
    Route::get('state'                        , [LCA::class, 'state']);
    Route::post('district'                    , [LCA::class, 'district']);
    Route::post('city'                        , [LCA::class, 'city']);
    Route::post('state-counter'               , [LCA::class, 'state_counter']);
    Route::post('state-district'              , [LCA::class, 'state_district']);
    Route::post('pincode-track'               , [LCA::class, 'pincode_wish_data_show']);
    Route::post('pincode-add'                 , [LCA::class, 'add_pincode_with_login']);

    Route::post('price-counter'               , [API::class, 'price_counter']);

    Route::post('state-counter'               , [API::class, 'state_counter']);
    Route::post('state-district'              , [API::class, 'state_district']);
    Route::get('state'                        , [API::class, 'state']);
    Route::post('district'                    , [API::class, 'district']);
    Route::post('price-counter'               , [API::class, 'price_counter']);
    Route::post('city'                        , [API::class, 'city']);

    Route::post('brand'                       , [API::class, 'brand']);
    Route::post('model'                       , [API::class, 'model']);
    Route::post('master-brand'                , [API::class, 'master_brand']);
    Route::post('master-brand-view-all'       , [API::class, 'master_brand_view_all']);
    Route::post('master-brand-data'           , [API::class, 'master_brand_data']);

    # Tractor
    Route::post('tractor'                     , [TC::class, 'tractor']);
    Route::post('tractor-add'                 , [TC::class, 'tractor_add']);
    Route::post('tractor-by-id'               , [TC::class, 'tractor_by_id']);
    Route::post('tractor-other-district'      , [TC::class, 'tractor_other_district']);
    Route::post('tractor-data'                , [TC::class ,'tractorDistance']);
    Route::post('tractor-update'              , [TC::class,'tractor_update']);

    # Rent Tractor ( Not Required)
    Route::post('rent-tractor-add'            , [API::class, 'rent_tractor_add']);
    Route::post('rent-tractor'                , [API::class, 'rent_tractor']);
    Route::post('rent-tractor-nearest'        , [API::class, 'rent_tractor_nearest']);
    Route::post('rent-tractor-other-district' , [API::class, 'rent_tractor_other_district']);
    Route::post('rent-tractor-by-id'          , [API::class, 'rent_tractor_by_id']);
   // Route::post('category-page'               , [API::class, 'category_page']);

    # Good Vehicle
    Route::post('gv-add'                      , [GC::class, 'gv_add']);
    Route::post('gv'                          , [GC::class, 'gv']);
    Route::post('gv-other-district'           , [GC::class, 'gv_other_district']);
    Route::post('gv-by-id'                    , [GC::class, 'gv_by_id']);
    Route::post('gv-data'                     , [GC::class, 'goodVehicleDistance']);
    Route::post('gv-update'                   , [GC::class, 'gv_update']);

    # Harvester
    Route::post('harvester'                   , [HC::class, 'harvester']);
    Route::post('harvester-other-district'    , [HC::class, 'harvester_other_district']);
    Route::post('harvester-by-id'             , [HC::class, 'harvester_by_id']);
    Route::post('harvester-add'               , [HC::class, 'harvester_add']);
    Route::post('harvester-data'              , [HC::class, 'harvesterDistance']);
    Route::post('harvester-update'            , [HC::class, 'harvester_update']);

    # Implements
    Route::post('implements'                  , [IC::class, 'implements']);
    Route::post('implements-other-district'   , [IC::class, 'implements_other_district']);
    Route::post('implements-by-id'            , [IC::class, 'implements_by_id']);
    Route::post('implements-add'              , [IC::class, 'implements_add']);
    Route::post('implements-data'             , [IC::class ,'implementDistance']);
    Route::post('implements-update'           , [IC::class,'implements_update']);

    # Seeds
    Route::post('seeds'                       , [SC::class, 'seeds']);
    Route::post('seeds-other-district'        , [SC::class, 'seeds_other_district']);
    Route::post('seeds-by-id'                 , [SC::class, 'seeds_by_id']);
    Route::post('seeds-add'                   , [SC::class, 'seeds_add']);
    Route::post('seed-data'                   , [SC::class ,'seedDistance']);
    Route::post('seed-update'                 , [SC::class,'seed_update']);

    # Pesticides
    Route::post('pesticides'                  , [PC::class, 'pesticides']);
    Route::post('pesticides-other-district'   , [PC::class, 'pesticides_other_district']);
    Route::post('pesticides-by-id'            , [PC::class, 'pesticides_by_id']);
    Route::post('pesticides-add'              , [PC::class, 'pesticides_add']);
    Route::post('pesticides-data'             , [PC::class, 'pesticidesDistance']);
    Route::post('pesticides-update'           , [PC::class, 'pesticides_update']);

    # Fertilizer
    Route::post('fertilizer'                  , [FC::class, 'fertilizer']);
    Route::post('fertilizer-other-district'   , [FC::class, 'fertilizer_other_district']);
    Route::post('fertilizer-by-id'            , [FC::class, 'fertilizer_by_id']);
    Route::post('fertilizer-add'              , [FC::class, 'fertilizer_add']);
    Route::post('fertilizer-data'             , [FC::class ,'fertilizersDistance']);
    Route::post('fertilizer-update'           , [FC::class,'fertilizer_update']);

    # Tyres
    Route::post('tyre'                        , [TyC::class, 'tyre']);
    Route::post('tyre-other-district'         , [TyC::class, 'tyre_other_district']);
    Route::post('tyre-by-id'                  , [TyC::class, 'tyre_by_id']);
    Route::post('tyre-add'                    , [TyC::class, 'tyre_add']);
    Route::post('tyre-data'                   , [TyC::class, 'tyreDistance']);
    Route::post('tyre-update'                 , [TyC::class, 'tyre_update']);

    Route::post('profile'                     , [API::class, 'profile']);
    Route::post('profile2'                    , [API2::class, 'profile']);
    Route::post('sponserer-profile'           , [API2::class, 'sponserer_profile']);
   // Route::post('user-posts'                  , [API2::class, 'user_posts']);

   // Route::post('new-boosts'                  , [API2::class, 'getNewBoosts']);
    

    Route::post('wishlist-add'                , [API::class, 'wishlist_add']);
    Route::post('wishlist'                    , [API::class, 'wishlist']);
    Route::post('delete-wishlist'             , [API::class, 'delete_wishlist']);

    Route::post('mark-as-sold'                , [API::class,'mark_as_sold']);
    Route::post('post-disabled'               , [API::class,'post_disabled']);

    Route::post('banner'                      , [Api2::class,'banner']);
    Route::get('settings'                     , [Api2::class, 'settings']);
    Route::post('settings-promotion'          , [Api2::class, 'settings_promotion']);
    Route::post('product-sharing'             , [Api2::class, 'product_sharing']);

    Route::post('search'                      , [API::class, 'search']);
    Route::post('search-result'               , [API::class, 'search_result']);
    Route::post('search-store'                , [API::class, 'search_store']);
    Route::post('search-history'              , [API::class, 'search_history']);

/*===================================================================================*/

    //******** prefix routing **********/
    Route::prefix('admin')->group(function () {
        Route::get('/users', function () {
            echo '1';
        });
    });

    /********* same controller routing *****/
    Route::prefix('lead')->group(function () {
        Route::controller(LEADAPI::class)->group(function () {
            Route::post('lead-view-all', 'lead_view_all');
            Route::post('lead-view'    , 'lead_view');
            Route::post('lead-generate', 'lead_generate');
        });
    });

    Route::prefix('account')->group(function () {

        Route::controller(LEADAPI::class)->group(function () {
            //Route::post('app-open', 'app_open');
            Route::post('page-time-spend', 'page_time_spend');
            Route::post('active-user', 'active_user');

            Route::post('account-counter', 'account_counter');
            Route::post('my-post'        , 'my_post');
            Route::post('my-lead'        , 'my_lead');
            Route::post('my-enquery'     , 'my_enquery');
            Route::post('notification'   , 'notification');

            Route::post('banner-click-lead','banner_click_lead');
            Route::post('ad-leads','ad_leads');

            /** Dibyendu Add My Product Lead View API */
            Route::post('my-seller-lead-view','my_product_lead_view');
        });

        Route::controller(FilterBKController::class)->group(function(){
            Route::post('tractor-filter'     , 'tractor_filter');
            Route::post('rent-tractor-filter', 'rent_tractor_filter');
            Route::post('gd-filter'          , 'goods_vehicle_filter');
            Route::post('harvester-filter'   , 'harvester_filter');
            Route::post('implement-filter'   , 'implements_filter');
            Route::post('tyre-filter'        , 'tyre_filter');
            Route::post('seed-filter'        , 'seed_filter');
            Route::post('pesticides-filter'  , 'pesticides_filter');
            Route::post('fertilizers-filter' , 'fertilizers_filter');
        });

    });


    Route::post('category-filter', [API::class,'filterByCategory']);

    Route::prefix('chat')->group(function () {
        Route::post('chat-send'    , [Chat::class, 'chat_send']);
        Route::post('chat-details' , [Chat::class, 'chat_details']);
        Route::post('chat-list'    , [Chat::class, 'chat_list']);
    });


    /********** iffco ***********/
    Route::prefix('iffco')->group(function () {
        Route::get('app-status-check' , [iffco::class, 'app_status_check']);
        Route::post('iffco-product'   , [iffco::class, 'iffco_product']);
        Route::post('iffco-couter'    , [iffco::class, 'iffco_counter']);
        Route::post('iffco-tracking'  , [iffco::class, 'iffco_tracking']);
    });

    /********** crop calender *********/
    Route::prefix('crop-calender')->group(function(){
        Route::post('season'       , [Api::class,'season']);
        Route::post('season-crop'  , [Api::class,'season_crop']);
    });

    /********** company *********/
    Route::prefix('company')->group(function(){
        Route::post('company'              , [Api::class, 'company']);
        Route::post('products'             , [Api::class, 'company_products']);
        Route::post('company-tracking'     , [Api::class, 'company_tracking']);
        Route::post('products-category-id' , [Api::class, 'products_category_id']);
        Route::post('dealer'               , [Api::class, 'company_dealer']);
    });

    /******** Filter In App *********/
    Route::post('brand-data-show'               , [FilterController::class ,'getBrandModelData']);
    Route::post('state-wish-district-show'      , [FilterController::class ,'stateWishDistrictName']);
    Route::post('year-of-purchase-data'         , [FilterController::class ,'getYear']);
    Route::post('price-max-min-data'            , [FilterController::class ,'getMaxMinPrice']);
    Route::post('tractor-filter'                , [FilterController::class ,'tractorFilter']);
    Route::post('gv-filter'                     , [FilterController::class ,'goodVehicleFilter']);
    Route::post('harvester-filter'              , [FilterController::class ,'harvesterFilter']);
    Route::post('implement-filter'              , [FilterController::class ,'implementFilter']);
    Route::post('tyre-filter'                   , [FilterController::class ,'tyreFilter']);
    Route::post('seed-filter'                   , [FilterController::class ,'seedFilter']);
    Route::post('pesticides-filter'             , [FilterController::class ,'pesticidesFilter']);
    Route::post('fertilizer-filter'             , [FilterController::class ,'fertilizerFilter']);
    Route::post('crops-filter'                  , [FilterController::class ,'cropsFilter']);


    #  My Product Post List
    Route::post('my-post-list'                  , [TestController::class,'my_post']);

    Route::post('notification-counter'          , [Api::class,'notification_counter']);
    Route::post('notification-open-count'       , [Api::class,'notification_open_count']);
    Route::post('chose-user-type'               , [Api::class,'choose_user_type']);
    Route::post('user1'                         , [Api::class,'user1']);

    # Subscription List
    Route::controller(SubcriptionController::class)->group(function(){ 
        Route::post('subscription-interest-record','subscription_interest_record');
        Route::get('subscription' , 'subscriptionDetails');
        Route::post('coupon' , 'coupon');
        Route::post('subscription-payment' , 'payment_subscription');
        Route::post('my-subscriptions','my_subscriptions');
        Route::post('invoice','invoice');
        Route::post('subscription-renewal','subscription_renew');
        Route::post('subscription-upgrade','subscription_upgrade');
    });

    # Banner Controller
    Route::controller(Ads_banner::class)->group(function(){ 
        Route::post('ads-banner-counter','ads_banner_counter');
        Route::post('ads_banner' , 'index');
        Route::post('banner-update' , 'banner_update');
        Route::post('banner-delete','banner_delete');
        Route::post('banner-list' , 'get_banner_list');
        Route::get('state-list' , 'state_name_get');
        Route::post('banner-position' , 'bannerPosition');
        Route::post('my-banner','my_banner');
        Route::post('pop-checker','pop_checker');

        Route::post('banner-lead','banner_lead');
        Route::post('total-banner-lead','total_banner_lead');
        Route::post('total-user-lead','total_user_lead');

        /** Dibyendu Add Post Details  */
        Route::post('post-details','lead_user_all_product_post_details');

    });

    # Product Boots
    Route::controller(Boost::class)->group(function(){ 
        //Route::post('user-posts','user_posts');
        Route::post('boost','boostDetails');
        Route::post('boost-payment','boost_payment');
        Route::post('boost-invoice','boost_invoice');
        Route::post('boost-all-product','boost_all_product');
    });

    # Notification Controller
    Route::controller(NC::class)->group(function(){
        Route::post('notification','notification');
        Route::post('n_banner_todays_login','n_banner_todays_login');
        Route::post('n_banner_state_user','n_banner_state_user');
        Route::post('n_banner_nearest_user','n_banner_nearest_user');
        Route::post('n_direct_lead','n_direct_lead');
    }); 

    # Mahindra Controller
    Route::prefix('mahindra')->group(function () {
    Route::controller(MahindraCompany::class)->group(function(){
        Route::post('all-product','all_product');
        Route::post('lead','add_lead');
        Route::post('user_feedback_save','user_feedback_save');
    }); 
    });


    # Crops Controller
    Route::prefix('crops')->group(function () {
        Route::controller(Crop::class)->group(function () {
            Route::post('package-details','package_details')->name('package.details');
            Route::post('address-details','address_details')->name('address.details');
            Route::post('total-price','total_price')->name('total.price');
            Route::post('crops-subscribed-list','cropSubscribedList')->name('crops.subscribed');
            Route::post('crops-category-subscribed-list','cropCategorySubscribedList')->name('crops.category.subscribed');
            Route::post('add-crops','addCropsPost')->name('add.crops');
            Route::post('resend-crop-otp','resend_otp')->name('resend.otp');
            Route::post('crop-boost-otp-send','cropBoostOtpSend')->name('otp.send');
            Route::post('crop-banner-list','cropBannerList')->name('crop.bannerList');
            Route::post('crop-boost-list','cropBoostList')->name('crop.boostList');
            Route::post('add-subscribed-crop-post','addSubscribedCropsPost')->name('add.subscribed.crops');
            Route::post('crop-post-list','cropPostList')->name('crop.PostList');
            Route::post('crop-banner-list-wish-subscribed-id','cropBannerListWishSubscribedId')->name('crop.bannerList.subscribed');
            Route::post('crop-post-list-wish-subscribed-id','cropPostListWishSubscribedId')->name('crop.postList.subscribed');
            Route::post('crop-post-status-update','cropsPostStatusUpdate')->name('crop.statusUpdate');
        });
    });


   


 



