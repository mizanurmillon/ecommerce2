<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin-login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::group(['namespace' => 'App\Http\Controllers\Admin','middleware'=>'is_admin'], function() {
    Route::get('/admin/home','AdminController@Admin')->name('admin.home');
    Route::get('/admin/logout','AdminController@AdminLogout')->name('admin.logout');
    Route::get('/password/change','AdminController@PasswordChange')->name('admin.password.change');
    Route::post('/password/update','AdminController@Update')->name('admin.password.update');

    // Category Route Here---------
    Route::group(['prefix' => 'category'], function() {
        Route::get('/','CategoryController@index')->name('category.index');
        Route::post('/store','CategoryController@store')->name('category.store');
        Route::get('/delete/{id}','CategoryController@Delete')->name('category.delete');
        Route::get('/edit/{id}','CategoryController@Edit');
        Route::post('/update','CategoryController@update')->name('category.update');
    });
    //Golbal Route Here---------
    Route::get('/get-child-category/{id}','CategoryController@getchildcategory');
    //Subcategory Route Here------
    Route::group(['prefix' => 'subcategory'], function() {
        Route::get('/','SubcategoryController@index')->name('subcategory.index');
        Route::post('/store','SubcategoryController@store')->name('subcategory.store');
        Route::get('/delete/{id}','SubcategoryController@Delete')->name('subcategory.delete');
        Route::get('/edit/{id}','SubcategoryController@Edit');
        Route::post('/update','SubcategoryController@update')->name('subcategory.update');
    });
    //Childcategory Route Here------
    Route::group(['prefix' => 'childcategory'], function() {
        Route::get('/','ChildcategoryController@index')->name('childcategory.index');
        Route::post('/store','ChildcategoryController@store')->name('childcategory.store');
        Route::get('/delete/{id}','ChildcategoryController@Delete')->name('childcategory.delete');
        Route::get('/edit/{id}','ChildCategoryController@Edit');
        Route::post('/update','ChildCategoryController@update')->name('childcategory.update');
    });
    //Brand Route Here------
    Route::group(['prefix' => 'brand'], function() {
        Route::get('/','BrandController@index')->name('brand.index');
        Route::post('/store','BrandController@store')->name('brand.store');
        Route::get('/delete/{id}','BrandController@Delete')->name('brand.delete');
        Route::get('/edit/{id}','BrandController@Edit');
        Route::post('/update','BrandController@update')->name('brand.update');
    });
    //Warehouse Route Here------
    Route::group(['prefix' => 'warehouse'], function() {
        Route::get('/','WarehouseController@index')->name('warehouse.index');
        Route::post('/store','WarehouseController@store')->name('warehouse.store');
        Route::get('/delete/{id}','WarehouseController@Delete')->name('warehouse.delete');
        Route::get('/edit/{id}','WarehouseController@Edit');
        Route::post('/update','WarehouseController@update')->name('warehouse.update');
    });
    //Coupon Route Here------
    Route::group(['prefix' => 'coupon'], function() {
        Route::get('/','CouponController@index')->name('coupon.index');
        Route::post('/store','CouponController@store')->name('coupon.store');
        Route::delete('/delete/{id}','CouponController@Delete')->name('coupon.delete');
        Route::get('/edit/{id}','CouponController@Edit');
        Route::post('/update','CouponController@update')->name('coupon.update');
    });
    //Campaing Route Here------
    Route::group(['prefix' => 'campaing'], function() {
        Route::get('/','CampaingController@index')->name('campaing.index');
        Route::post('/store','CampaingController@store')->name('campaing.store');
        Route::get('/delete/{id}','CampaingController@Delete')->name('campaing.delete');
        Route::get('/edit/{id}','CampaingController@Edit');
        Route::post('/update','CampaingController@update')->name('campaing.update');
    });
    //___Campaing product Route Here------
    Route::group(['prefix' => 'campaing-product'], function() {
        Route::get('/{campaing_id}','CampaingController@campaingProduct')->name('campaing.product');
        Route::get('/add/{id}/{campaing_id}','CampaingController@ProductAddToCampaing')->name('add.product.to.campaing');
        Route::get('/list/{campaing_id}','CampaingController@ProductList')->name('campaing.product.list');
        Route::get('/remove/{id}','CampaingController@RemoveCampaing')->name('product.remove.campaing');
        // Route::post('/update','CampaingController@update')->name('campaing.update');
    });
    //__Order
    Route::group(['prefix' => 'order'], function() {
        Route::get('/','OrderController@index')->name('admin.order.index');
        Route::delete('/delete/{id}','OrderController@Delete')->name('order.delete');
        Route::get('/edit/{id}','OrderController@Edit');
        Route::post('/update-status','OrderController@UpdateStatus')->name('update.status');
        Route::get('/view/{id}','OrderController@View');
    });
    //Pickup Point Route here----------
    Route::group(['prefix' => 'pickup-point'], function() {
        Route::get('/','PickupController@index')->name('pickuppoint.index');
        Route::post('/store','PickupController@store')->name('pickuppoint.store');
        Route::delete('/delete/{id}','PickupController@Delete')->name('pickuppoint.delete');
        Route::get('/edit/{id}','PickupController@Edit');
        Route::post('/update','PickupController@update')->name('pickuppoint.update');
    });
    //Ticket Route here----------
    Route::group(['prefix' => 'ticket'], function() {
        Route::get('/','TicketController@index')->name('ticket.index');
        Route::get('/ticket-view/{id}','TicketController@TicketView')->name('ticket.view');
        Route::post('/store-reply','TicketController@storeReply')->name('admin.store.reply');
        Route::get('/admin-close-ticket/{id}','TicketController@CloseTicket')->name('admin.close.ticket');
        Route::delete('/admin-ticket-delete/{id}','TicketController@DeleteTicket')->name('admin.ticket.delete');
       
    });
    // Product Route Here-----------
    Route::group(['prefix' => 'product'], function() {
        Route::get('/','ProductController@index')->name('product.index');
        Route::get('/create','ProductController@create')->name('create.product');
        Route::post('/store','ProductController@store')->name('product.store');
        Route::delete('/delete/{id}','ProductController@Delete')->name('product.delete');
        Route::get('/edit/{id}','ProductController@Edit')->name('product.edit');
        Route::post('/update','ProductController@update')->name('product.update');
        Route::get('/deactive/{id}','ProductController@deactive');
        Route::get('/active/{id}','ProductController@active');
        Route::get('/deactive_deal/{id}','ProductController@deactivedeal');
        Route::get('/active_deal/{id}','ProductController@activedeal');
        Route::get('/deactive_status/{id}','ProductController@deactiveStatus');
        Route::get('/active_status/{id}','ProductController@activeStatus');
    });
    //Setting Route Here--------
    Route::group(['prefix' => 'setting'], function() {
        //SEO Setting--------
        Route::group(['prefix' => 'seo'], function() {
            Route::get('/','SettingController@SeoSetting')->name('seo.setting');
            Route::post('/update/{id}','SettingController@SeoUpdate')->name('seo.setting.update');
        });
        //SMTP Setting----------
        Route::group(['prefix' => 'smtp'], function() {
            Route::get('/','SettingController@SmtpSetting')->name('smtp.setting');
            Route::post('/update/{id}','SettingController@SmtpUpdate')->name('smtp.setting.update');
        });
        //WEBSITE Setting-----------
        Route::group(['prefix' => 'website'], function() {
            Route::get('/','SettingController@websiteSetting')->name('website.setting');
            Route::post('/update/{id}','SettingController@websiteUpdate')->name('website.setting.update');
        });
         //Payment Gateway Setting-----------
        Route::group(['prefix' => 'payment-gateway'], function() {
            Route::get('/','SettingController@PaymentGateway')->name('payment.gateway');
            Route::post('/aamerpay-update','SettingController@AamerpayUpdate')->name('aamerpay.update');
            Route::post('/surjopay-update','SettingController@SurjopayUpdate')->name('surjopay.update');
            Route::post('/sslcommerz-update','SettingController@SSlcommerzUpdate')->name('sslcommerz.update');
        });
        //PAGE Setting-------------
        Route::group(['prefix' => 'page'], function() {
            Route::get('/','SettingController@index')->name('page.index');
            Route::get('/create','SettingController@create')->name('page.create');
            Route::post('/store','SettingController@store')->name('page.store');
            Route::get('/delete/{id}','SettingController@delete')->name('page.delete');
            Route::get('/edit/{id}','SettingController@Edit')->name('page.edit');
            Route::post('/update/{id}','SettingController@Update')->name('page.update');
            
        });
    });
    //__Blog Category Route Here---------
    Route::group(['prefix' => 'blog-category'], function() {
        Route::get('/','BlogController@Category')->name('admin.blog.category');
        Route::post('/store','BlogController@store')->name('blog.category.store');
        Route::get('/delete/{id}','BlogController@Delete')->name('blog.category.delete');
        Route::get('/edit/{id}','BlogController@Edit');
        Route::post('/update','BlogController@Update')->name('blog.category.update');
    });
    //__Blog Category Route Here---------
    Route::group(['prefix' => 'report'], function() {
        Route::get('/order','OrderController@ReportIndex')->name('order.report.index');
        Route::get('/order-print','OrderController@ReportPrint')->name('report.order.print');
       
    });
    //__Role Route Here---------
    Route::group(['prefix' => 'role'], function() {
        Route::get('/','RoleController@index')->name('manage.role');
        Route::get('/create','RoleController@create')->name('create.role');
        Route::post('/store','RoleController@store')->name('store.role');
        Route::get('/delete/{id}','RoleController@Delete')->name('role.delete');
        Route::get('/edit/{id}','RoleController@Edit')->name('role.edit');
        Route::post('/update','RoleController@Update')->name('role.update');
    });
});
