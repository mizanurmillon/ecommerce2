<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
//login route---
Route::get('/login',function(){
     return redirect()->to('/');      
})->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customer-logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('customer.logout');
// Frontend Route Here---------------
Route::group(['namespace' => 'App\Http\Controllers\Front'], function() {
    Route::get('/','IndexController@index');
    Route::get('/product-details/{slug}','IndexController@ProductDetails')->name('product.details');
    
    //Add to Cart Route----
    Route::post('/add-to-cart-Quickview','CartController@AddToCartQV')->name('add.to.cart.Quickview');
    //All Cart------
    Route::get('/all-cart','CartController@AllCart')->name('all.cart');
    Route::get('/cart-empty','CartController@CartEmpty')->name('cart.empty');
    //chackout route
    Route::get('/cart-checkout','CheckoutController@CheckoutCart')->name('checkout.cart');
    //Apply coupon route
    Route::post('/coupon-apply','CheckoutController@Applycoupon')->name('apply.coupon');
    Route::get('/coupon-remove','CheckoutController@RemoveCoupon')->name('coupon.remove');
    //order place route
    Route::post('/order-place','CheckoutController@OrderPlace')->name('order.place');
    //My Cart-----
    Route::get('/my-cart','CartController@MyCart')->name('cart');
    Route::get('/cartproduct-remove/{rowId}','CartController@Remove');
    Route::get('/cartproduct-updateqty/{rowId}/{qty}','CartController@updateQty');
    Route::get('/cartproduct-updatecolor/{rowId}/{color}','CartController@updateColor');
    Route::get('/cartproduct-updatesize/{rowId}/{size}','CartController@updateSize');

    //Wishlist------
    Route::get('/wishlist','CartController@Wishlist')->name('wishlist');
    Route::get('/clear-wishlist','CartController@ClearWishlist')->name('clear.wishlist');
    Route::get('/add-wishlist/{id}','CartController@AddWishlist')->name('add.wishlist');
    Route::get('/wishlist-product-delete/{id}','CartController@Delete')->name('wishlistproduct.delete');

    //Quick Views Route-------
    Route::get('/product-quick-view/{id}','IndexController@ProductQuickView');
    //categorywise product Route----
    Route::get('/categorywise-product/{id}','IndexController@CategorywiseProduct')->name('categorywise.product');
    Route::get('/subcategorywise-product/{id}','IndexController@SubcategorywiseProduct')->name('subcategorywise.product');
    Route::get('/childcategorywise-product/{id}','IndexController@ChildcategorywiseProduct')->name('childcategorywise.product');
    //Brand Wise product route---
    Route::get('/brandwise-product/{id}','IndexController@BrandwiseProduct')->name('brandwise.product');
    //product review Route------
    Route::post('/product-review','ReviewController@store')->name('product.review');
    //this is Website review Route------
    Route::get('/write-review','ReviewController@WriteReview')->name('write.review');
    Route::post('/website-review-store','ReviewController@WebReviewStore')->name('website.review.store');
    //Profile Setting Route-----
    Route::get('profile-setting','ProfileController@ProfileSetting')->name('profile.setting');
    Route::post('password-update','ProfileController@PasswordChange')->name('password.change');
    //My order------
    Route::get('my-order','ProfileController@MyOrder')->name('my.order');
    Route::get('/order-view/{id}','ProfileController@orderView')->name('view.order');
    //page view route------
    Route::get('/page-view/{page_slug}','IndexController@PageView')->name('page.view');

    //newsletter store route---
    Route::post('/newsletter','IndexController@NewsletterStore')->name('store.newsletter');

    //support ticket------
    Route::get('/open-ticket','ProfileController@OpenTicket')->name('open.ticket');
    Route::get('/new-ticket','ProfileController@NewTicket')->name('new.ticket');
    Route::post('/store-ticket','ProfileController@StoreTicket')->name('store.ticket');
    Route::get('/show-ticket/{id}','ProfileController@ShowTicket')->name('show.ticket');
    Route::post('/reply-ticket','ProfileController@ReplyTicket')->name('reply.ticket');

    //order Tracking route
    Route::get('/order-tracking','IndexController@OrderTracking')->name('order.tracking');
    Route::post('/check-order','IndexController@CheckOrder')->name('check.order');
    //payment gateway route
    Route::post('/success','CheckoutController@success')->name('success');
    Route::post('/fail','CheckoutController@fail')->name('fail');
    Route::get('/fail',function()
    {
        return redirect()->to('/');
    })->name('cancel');
    //Contact route------
    Route::post('/store','IndexController@Store')->name('contact.store');
    Route::get('/contact-us','IndexController@Contact')->name('contact');
    Route::get('/blog-us','IndexController@Blog')->name('blog');

    //__campaing route 
    Route::get('/campaing-product/{id}','IndexController@CampaingProduct')->name('campaing.product');
    Route::get('/campaing-product-details/{slug}','IndexController@CampaingProductDetails')->name('campaing.product.details');


});
//__socialite route
Route::get('/oauth/{driver}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('/oauth/{driver}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('social.callback');
