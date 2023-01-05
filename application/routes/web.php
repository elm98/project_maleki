<?php

use Illuminate\Support\Facades\Route;

Route::match(['post','get'],'/admin',function (){return redirect('/log-in');});
Route::get('/log-in','LoginController@log_in');
Route::post('/logged-in','LoginController@logged_in');
Route::get('/log-out','LoginController@log_out');

Route::group([
    'prefix' => 'management',
    'middleware'=>['web','AdminPanel','auth']],function()
{
    //Dashboard And Public
    Route::get('/',function(){return redirect()->intended('/management/dashboard');});
    Route::get('dashboard','DashboardController@dashboard');
    Route::get('/access-denied', function () {return view('back-end.access_denied');});
    Route::get('/empty', function () {return view('back-end._empty');});
    Route::get('/find-post','AppController@find_post');
    Route::get('/find-cat','AppController@find_cat');
    Route::get('/find-comment','AppController@find_comment');
    Route::get('/find-user','AppController@find_user');
    Route::get('/find-rs-agent','AppController@find_rs_agent');
    Route::get('/search-menu','AppController@search_menu');
    Route::get('redirect',function (){return redirect()->intended('/management/access-denied');});
    Route::post('cat-item-update','CatController@menu_all_update');
    Route::get('chart','DashboardController@chart');

    Route::match(['get','post'],'elementor','DashboardController@elementor');

    //--Gallery
    Route::get('galleryList','GalleryController@galleryList');
    Route::post('galleryUpload','GalleryController@galleryUpload');
    Route::post('galleryDelete','GalleryController@galleryDelete');

    //Options - Setting
    Route::post('save-them-setting','OptionController@save_them_setting');
    Route::get('get-them-setting','OptionController@get_them_setting');
    Route::get('setting','OptionController@setting');
    Route::post('setting-update','OptionController@setting_update');
    Route::post('setting-image-update','OptionController@setting_image_update');
    Route::post('json-save','OptionController@json_save');
    Route::get('setting-social','OptionController@setting_social');
    Route::get('setting-address','OptionController@setting_address');


    /*فایل منیجر*/
    Route::get('file-list','FileController@file_list');
    Route::post('file-uploader','FileController@file_uploader');
    Route::post('files-delete','FileController@files_delete');
    Route::post('new-directory','FileController@new_directory');

    //PERMISSION
    Route::get('/permission-source', 'PermissionController@permission_source');
    Route::get('/permission-route', 'PermissionController@permission_route');
    Route::get('/select-permission-group/{id}', 'PermissionController@select_permission_group');
    Route::post('/permission-new-group', 'PermissionController@permission_new_group');
    Route::post('/permission-new-subGroup', 'PermissionController@permission_new_subGroup');
    Route::post('/permission-insert-route', 'PermissionController@permission_insert_route');
    Route::post('/permission-delete-route', 'PermissionController@permission_delete_route');
    Route::post('/permission-delete-subGroup', 'PermissionController@permission_delete_subGroup');
    Route::post('/permission-delete-group', 'PermissionController@permission_delete_group');
    Route::get('/permission-list', 'PermissionController@permission_list');
    Route::post('/permission-list-dt', 'PermissionController@permission_list_dt');
    Route::get('/permission-add', 'PermissionController@permission_add');
    Route::get('/permission-edit/{id}', 'PermissionController@permission_edit');
    Route::post('/permission-update', 'PermissionController@permission_update');
    Route::post('/permission-delete', 'PermissionController@permission_delete');
    Route::post('/permission-status-group', 'PermissionController@permission_status_group');

    //PROFILE
    Route::get('profile','ProfileController@profile');
    Route::post('profile-update','ProfileController@profile_update');
    Route::post('profile-meta-save','ProfileController@profile_meta_save');
    Route::post('profile-notify-save','ProfileController@profile_notify_save');

    //USERS
    Route::get('user-list','UserController@user_list');
    Route::post('user-list-dt','UserController@user_list_dt');
    Route::get('user-add','UserController@user_add');
    Route::post('user-insert','UserController@user_insert');
    Route::get('user-edit/{id}','UserController@user_edit');
    Route::post('user-update','UserController@user_update');
    Route::post('user-delete','UserController@user_delete');
    Route::post('user-meta-save','UserController@user_meta_save');
    Route::post('user-notify-save','UserController@user_notify_save');
    Route::match(['get','post'],'login-list','UserController@login_list');
    Route::post('login-delete','UserController@login_delete');

    //CUSTOMER
    Route::get('customer-list','CustomerController@customer_list');
    Route::post('customer-list-dt','CustomerController@customer_list_dt');
    Route::get('customer-add','CustomerController@customer_add');
    Route::post('customer-insert','CustomerController@customer_insert');
    Route::get('customer-edit/{id}','CustomerController@customer_edit');
    Route::post('customer-update','CustomerController@customer_update');
    Route::post('customer-delete','CustomerController@customer_delete');
    Route::post('customer-meta-save','CustomerController@customer_meta_save');
    Route::post('customer-notify-save','CustomerController@customer_notify_save');

    //Users Public operation
    Route::post('change-pass','UserController@change_pass');
    Route::get('address-list/{id}','UserController@address_list');
    Route::post('address-insert','UserController@address_insert');
    Route::post('address-delete','UserController@address_delete');
    Route::post('change-credit','UserController@change_credit');

    //Post
    Route::get('post-list','PostController@post_list');
    Route::post('post-list-dt','PostController@post_list_dt');
    Route::get('post-add','PostController@post_add');
    Route::get('post-edit/{id}','PostController@post_edit');
    Route::post('post-update','PostController@post_update');
    Route::get('post-get-gallery/{id}','PostController@post_get_gallery');
    Route::post('post-save-gallery','PostController@post_save_gallery');
    Route::post('post-delete','PostController@post_delete');
    Route::get('post-cat','PostController@post_cat');
    Route::post('post-cat-detail','PostController@post_cat_detail');
    Route::post('post-cat-detail-update','PostController@post_cat_detail_update');
    Route::post('post-cat-item-delete','PostController@post_cat_item_delete');
    Route::post('add-fast-category','PostController@add_fast_category');
	Route::get('post-copy/{id}','PostController@copy');
	Route::get('cat-edit/{id}','CatController@cat_edit');
	Route::post('cat-update','CatController@cat_update');
    Route::match(['get','post','head'],'post-excel-import', 'Shop\ImportController@post_excel_import');

    //portfolio -- نمونه کار
    Route::get('portfolio-list','PortfolioController@portfolio_list');
    Route::post('portfolio-list-dt','PortfolioController@portfolio_list_dt');
    Route::get('portfolio-add','PortfolioController@portfolio_add');
    Route::get('portfolio-edit/{id}','PortfolioController@portfolio_edit');
    Route::post('portfolio-update','PortfolioController@portfolio_update');
    Route::get('portfolio-get-gallery/{id}','PortfolioController@portfolio_get_gallery');
    Route::post('portfolio-save-gallery','PortfolioController@portfolio_save_gallery');
    Route::post('portfolio-delete','PortfolioController@portfolio_delete');
    Route::get('portfolio-cat','PortfolioController@portfolio_cat');
    Route::post('portfolio-cat-detail','PortfolioController@portfolio_cat_detail');
    Route::post('portfolio-cat-detail-update','PortfolioController@portfolio_cat_detail_update');
    Route::post('portfolio-cat-item-delete','PortfolioController@portfolio_cat_item_delete');
    Route::post('portfolio-fast-category','PortfolioController@portfolio_fast_category');
    Route::get('portfolio-copy/{id}','PortfolioController@copy');


    //Comment
    Route::get('comment-list','CommentController@comment_list');
    Route::get('comment-trash-list','CommentController@comment_trash_list');
    Route::post('comment-list-dt','CommentController@comment_list_dt');
    Route::get('comment-edit/{id}','CommentController@comment_edit');
    Route::post('comment-update','CommentController@comment_update');
    Route::get('comment-trashed/{id}/{list_address?}','CommentController@comment_trashed');
    Route::get('comment-restore/{id}/{list_address?}','CommentController@comment_restore');
    Route::post('comment-delete','CommentController@comment_delete');

    //Qquestion
    Route::get('question-list','QuestionController@question_list');
    Route::get('question-trash-list','QuestionController@question_trash_list');
    Route::post('question-list-dt','QuestionController@question_list_dt');
    Route::get('question-edit/{id}','QuestionController@question_edit');
    Route::post('question-update','QuestionController@question_update');
    Route::get('question-trashed/{id}/{list_address?}','QuestionController@question_trashed');
    Route::get('question-restore/{id}/{list_address?}','QuestionController@question_restore');
    Route::post('question-delete','QuestionController@question_delete');

    //First Page
    Route::get('first-page-list','DashboardController@first_page_list');
    Route::post('first-page-list-dt','DashboardController@first_page_list_dt');
    Route::get('/design-f-page','DashboardController@design_f_page');
    Route::get('/design-page-edit/{id}','DashboardController@design_page_edit');
    Route::post('/first-page-update','DashboardController@first_page_update');
    Route::post('/first-page-delete','DashboardController@first_page_delete');

    //Category Actions
    Route::match(['get','post','head'],'/my-menu','CatController@my_menu'); // -- عملیاتهای اصلی
    Route::post('menu-all-update','CatController@menu_all_update'); // -- بروز رسانی همه ایتمها
    Route::post('index-menu-delete','CatController@index_menu_delete'); // -- حذف اختصاصی

    //Transaction
    Route::get('transaction-list','TransactionController@transaction_list');
    Route::post('transaction-list-dt','TransactionController@transaction_list_dt');
    Route::post('transaction-insert','TransactionController@transaction_insert');
    Route::post('transaction-delete','TransactionController@transaction_delete');

    //Payment request - درخواستهای تسویه حساب
    Route::match(['get','post'],'payment-request','PaymentRequestController@index');


    //Payment
    Route::get('payment-list','PaymentController@payment_list');
    Route::post('payment-list-dt','PaymentController@payment_list_dt');
    Route::get('payment-detail','PaymentController@payment_detail');
    Route::post('payment-delete','PaymentController@payment_delete');

    //Sms
    Route::get('sms-list','SmsController@sms_list');
    Route::post('sms-list-dt','SmsController@sms_list_dt');
    Route::post('sms-send','SmsController@sms_send');
    Route::get('sms-detail','SmsController@sms_detail');
    Route::post('sms-delete','SmsController@sms_delete');

    //Notify
    Route::get('notify-list','NotifyController@notify_list');
    Route::post('notify-list-dt','NotifyController@notify_list_dt');
    Route::post('notify-read','NotifyController@notify_read');
    Route::post('notify-delete','NotifyController@notify_delete');
    Route::post('notify-refresh','NotifyController@notify_refresh');

    //Notify Template
    Route::match(['get','post','head','delete'],'notify-temp', 'NotifyTempController@index');

    Route::match(['get','post'],'ticket-list','TicketController@ticket_list');
    Route::get('ticket-message/{id}','TicketController@ticket_message');
    Route::post('ticket-save','TicketController@ticket_save');
    Route::post('ticket-delete','TicketController@ticket_delete');
    Route::post('ticket-message-delete','TicketController@ticket_message_delete');
    Route::post('ticket-closed','TicketController@ticket_closed');

    //Contact - دفترچه تلفن
    Route::get('contact-list','ContactController@list');
    Route::post('contact-list-dt','ContactController@list_dt');
    Route::get('contact-add','ContactController@add');
    Route::post('contact-insert','ContactController@insert');
    Route::get('contact-edit/{id}','ContactController@edit');
    Route::post('contact-update','ContactController@update');
    Route::post('contact-delete','ContactController@delete');

    //Locate - استان - شهر - محله
    Route::match(['get','post'],'state-list','LocationController@state_list');
    Route::match(['get','post'],'city-list','LocationController@city_list');
    Route::match(['get','post'],'area-list','LocationController@area_list');
    Route::post('locate-done','LocationController@locate_done');
    Route::post('locate-delete','LocationController@locate_delete');

    /*نظر سنجی  - poll*/
    Route::get('poll-list', 'PollController@poll_list');
    Route::post('poll-list-dt', 'PollController@poll_list_dt');
    Route::get('poll-add', 'PollController@poll_add');
    Route::get('poll-edit/{id}', 'PollController@poll_edit');
    Route::post('poll-insert', 'PollController@poll_done');
    Route::post('poll-update', 'PollController@poll_done');
    Route::post('poll-delete', 'PollController@poll_delete');
    Route::post('poll-item-update', 'PollController@poll_item_done');
    Route::get('poll-result/{id?}', 'PollController@poll_result');
    Route::post('poll-result-dt', 'PollController@poll_result_dt');

    /*Redirect - انتقال صفحه*/
    Route::get('redirect-list', 'RedirectController@redirect_list');
    Route::post('redirect-list-dt', 'RedirectController@redirect_list_dt');
    Route::post('redirect-insert', 'RedirectController@redirect_done');
    Route::post('redirect-update', 'RedirectController@redirect_done');
    Route::post('redirect-delete', 'RedirectController@redirect_delete');

    // history - تاریخچه
    Route::get('history-list','HistoryController@history_list');
    Route::post('history-list-dt','HistoryController@history_list_dt');
    Route::post('history-delete','HistoryController@history_delete');

    // Truncate -خالی کردن جدول
    Route::post('truncate-table','OptionController@truncate_table');


    /*Element or - المنتور*/
    Route::get('element-get-list', 'ElementorController@get_list');
    Route::post('element-save-list', 'ElementorController@save_list');
    Route::post('element-delete-item', 'ElementorController@delete_item');
    Route::get('element-widget-reader', 'ElementorController@widget_reader');
    Route::get('/elementor-item-add','ElementorController@elementor_item_add');
    Route::get('/elementor-item','ElementorController@elementor_item');
    Route::post('/elementor-item-update','ElementorController@elementor_item_update');
    Route::post('/elementor-item-delete','ElementorController@elementor_item_delete');

    /***Public Rout**/
    Route::get('find-user', 'AppController@find_user');
    Route::get('get-city/{parent_id?}', function ($parent_id=0){return getCity($parent_id);})->where('parent_id','[0-9]+');
    Route::post('export-database', 'AppController@export_database');
    Route::post('import-database', 'AppController@import_database');
    Route::match(['post','get'],'backup-list', 'OptionController@backup_list');
});

// **************
// Bank Callback
//***************
Route::group([
        'prefix' => 'callback'
    ]
    ,function ()
{
    Route::match(['get','post','head'],'/bank/{gate?}','Bank\IndexController@callback');
});

//*****************************
//Front End سمت مشتری قالب یکتا
//*****************************

Route::group([
    'middleware'=>['FrontEnd']
    ]
    ,function ()
    {
        Route::match(['post','get'],'/','Ui\IndexController@index');
        Route::get('/login','LoginController@login');
        Route::post('/login-done','LoginController@login_done');
        Route::get('/login-mobile','LoginController@login_mobile');
        Route::post('/mobile-verify-code','LoginController@mobile_verify_code');
        Route::post('/mobile-check-code','LoginController@mobile_check_code');
        Route::get('/register','LoginController@register');
        Route::post('/register-done','LoginController@register_done');


        //************************************
        //Front Helper - روتهای عمومی یا آزاد
        //***********************************/
        Route::match(['post','get'],'/404','Ui\IndexController@_404');
        Route::match(['post','get'],'/login', [ 'as' => 'login', 'uses' => 'LoginController@login']);
        Route::post('/x-login','LoginController@x_login');
        Route::match(['get','post'],'/x-logout','LoginController@x_logout');
        Route::match(['get','post'],'/logout','LoginController@logout');
        Route::post('/save-comment','Ui\CommentController@save_comment');
        Route::get('/get-city','LocateController@get_city');
        Route::get('/get-cat','AppController@get_cat');
        Route::get('/get-cat-html','AppController@get_cat_html');
        Route::get('/get-cat-api/{id}/{type?}', function ($id,$type=''){return getCatApi($id,$type);})->name('getCatApi')->where(['id'=>'[0-9,-1]+']);
        Route::get('/find-product','AppController@find_product');
        Route::get('/find-store','AppController@find_store');
        Route::match(['get','post'],'/get-address','UserController@get_address');
        Route::match(['get','post'],'/check-invoice-quantity','Shop\InvoiceController@check_invoice_quantity');


        //************************************
        //Forget password    فراموشی رمز عبور
        // **********************************/
        Route::get('/forget-password','UserController@forget_password');
        Route::match(['get','post'],'/forget-password-request','UserController@forget_password_request');
        Route::get('/recovery-password/{recovery_token}','UserController@recovery_password');
        Route::post('/set-new-password','UserController@set_new_password');



    });
//******** انتهای روتینگ فرانت **********//



//**************************
//   develop - روتهای دولوپر
//*************************/
Route::get('event',function (){return view('front-end.event');});
Route::get('event-notify',function (){
    $data=[
        'event'=>'newUser',
        'data'=>[
            'username'=>'mohammadShoja'
        ]
    ];
    $a=\Illuminate\Support\Facades\Redis::publish('test',json_encode($data));
    return $a.' : done New Emit Broadcasting';
});
Route::get('test/test',function (){
dd (getProductList(/*[
    'filters'=>['144<separator>دالبی دیجیتال با صدای استریو']
]*/));
});

Route::get('/cache/clear', function () {
    Artisan::call('cache:clear');
    //Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');

    dd("cache clear All");
});

Route::get('/migrate', function(){
    Artisan::call('migrate-');
    dd('migrated done!');
});
Route::get('rollback',function(){
    Artisan::call('migrate:rollback-');
    dd('migrated rollback!');
});
