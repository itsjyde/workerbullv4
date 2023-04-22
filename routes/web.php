<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

Route::get('/sitemap-'.str_slug(config('app.name')).'/{file?}', 'SitemapController@index');

//============ Remove this  while creating zip for Envato ===========//

/*This command is useful in demo site you can go to https://demo.neonlms.com/reset-demo and it will refresh site from this URL. */

Route::get('reset-demo', function () {
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 1000);
    try {
        \Illuminate\Support\Facades\Artisan::call('refresh:site');

        return 'Refresh successful!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
//===================================================================//

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::namespace('Frontend')->name('frontend.')->group(function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::namespace('Backend')->prefix('user')->name('admin.')->middleware('admin')->group(function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});

Route::namespace('Backend')->prefix('user')->name('admin.')->middleware('auth')->group(function () {
    //==== Messages Routes =====//
    Route::get('messages', 'MessagesController@index')->name('messages');
    Route::post('messages/unread', 'MessagesController@getUnreadMessages')->name('messages.unread');
    Route::post('messages/send', 'MessagesController@send')->name('messages.send');
    Route::post('messages/reply', 'MessagesController@reply')->name('messages.reply');
});

Route::get('category/{category}/blogs', 'BlogController@getByCategory')->name('blogs.category');
Route::get('tag/{tag}/blogs', 'BlogController@getByTag')->name('blogs.tag');
Route::get('blog/{slug?}', 'BlogController@getIndex')->name('blogs.index');
Route::post('blog/{id}/comment', 'BlogController@storeComment')->name('blogs.comment');
Route::get('blog/comment/delete/{id}', 'BlogController@deleteComment')->name('blogs.comment.delete');

Route::get('teachers', 'Frontend\HomeController@getTeachers')->name('teachers.index');
Route::get('teachers/{id}/show', 'Frontend\HomeController@showTeacher')->name('teachers.show');

Route::post('newsletter/subscribe', 'Frontend\HomeController@subscribe')->name('subscribe');

//============Course Routes=================//
Route::get('courses', 'CoursesController@all')->name('courses.all');
Route::get('course/{slug}', 'CoursesController@show')->name('courses.show')->middleware('subscribed');
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('course/{course_id}/rating', 'CoursesController@rating')->name('courses.rating');
Route::get('category/{category}/courses', 'CoursesController@getByCategory')->name('courses.category');
Route::post('courses/{id}/review', 'CoursesController@addReview')->name('courses.review');
Route::get('courses/review/{id}/edit', 'CoursesController@editReview')->name('courses.review.edit');
Route::post('courses/review/{id}/edit', 'CoursesController@updateReview')->name('courses.review.update');
Route::get('courses/review/{id}/delete', 'CoursesController@deleteReview')->name('courses.review.delete');

//============Bundle Routes=================//
Route::get('bundles', 'BundlesController@all')->name('bundles.all');
Route::get('bundle/{slug}', 'BundlesController@show')->name('bundles.show');
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('bundle/{bundle_id}/rating', 'BundlesController@rating')->name('bundles.rating');
Route::get('category/{category}/bundles', 'BundlesController@getByCategory')->name('bundles.category');
Route::post('bundles/{id}/review', 'BundlesController@addReview')->name('bundles.review');
Route::get('bundles/review/{id}/edit', 'BundlesController@editReview')->name('bundles.review.edit');
Route::post('bundles/review/{id}/edit', 'BundlesController@updateReview')->name('bundles.review.update');
Route::get('bundles/review/{id}/delete', 'BundlesController@deleteReview')->name('bundles.review.delete');

Route::middleware('auth')->group(function () {
    Route::get('lesson/{course_id}/{slug}/', 'LessonsController@show')->name('lessons.show');
    Route::post('lesson/{slug}/test', 'LessonsController@test')->name('lessons.test');
    Route::post('lesson/{slug}/retest', 'LessonsController@retest')->name('lessons.retest');
    Route::post('video/progress', 'LessonsController@videoProgress')->name('update.videos.progress');
    Route::post('lesson/progress', 'LessonsController@courseProgress')->name('update.course.progress');
    Route::post('lesson/book-slot', 'LessonsController@bookSlot')->name('lessons.course.book-slot');
});

Route::get('/search', [HomeController::class, 'searchCourse'])->name('search');
Route::get('/search-course', [HomeController::class, 'searchCourse'])->name('search-course');
Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');

Route::get('/faqs', 'Frontend\HomeController@getFaqs')->name('faqs');

/*=============== Theme blades routes ends ===================*/

Route::get('contact', 'Frontend\ContactController@index')->name('contact');
Route::post('contact/send', 'Frontend\ContactController@send')->name('contact.send');

Route::get('download', 'Frontend\HomeController@getDownload')->name('download');

Route::middleware('auth')->group(function () {
    Route::post('cart/checkout', 'CartController@checkout')->name('cart.checkout');
    Route::post('cart/add', 'CartController@addToCart')->name('cart.addToCart');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::get('cart/clear', 'CartController@clear')->name('cart.clear');
    Route::get('cart/remove', 'CartController@remove')->name('cart.remove');
    Route::post('cart/apply-coupon', 'CartController@applyCoupon')->name('cart.applyCoupon');
    Route::post('cart/remove-coupon', 'CartController@removeCoupon')->name('cart.removeCoupon');
    Route::post('cart/stripe-payment', 'CartController@stripePayment')->name('cart.stripe.payment');
    Route::post('cart/paypal-payment', 'CartController@paypalPayment')->name('cart.paypal.payment');
    Route::get('cart/paypal-payment/status', 'CartController@getPaymentStatus')->name('cart.paypal.status');

    Route::post('cart/instamojo-payment', 'CartController@instamojoPayment')->name('cart.instamojo.payment');
    Route::get('cart/instamojo-payment/status', 'CartController@getInstamojoStatus')->name('cart.instamojo.status');

    Route::post('cart/razorpay-payment', 'CartController@razorpayPayment')->name('cart.razorpay.payment');
    Route::post('cart/razorpay-payment/status', 'CartController@getRazorpayStatus')->name('cart.razorpay.status');

    Route::post('cart/cashfree-payment', 'CartController@cashfreeFreePayment')->name('cart.cashfree.payment');
    Route::post('cart/cashfree-payment/status', 'CartController@getCashFreeStatus')->name('cart.cashfree.status');

    Route::post('cart/payu-payment', 'CartController@payuPayment')->name('cart.payu.payment');
    Route::post('cart/payu-payment/status', 'CartController@getPayUStatus')->name('cart.pauy.status');

    Route::match(['GET', 'POST'], 'cart/flutter-payment', ['uses' => 'CartController@flatterPayment', 'as' => 'cart.flutter.payment']);
    Route::get('cart/flutter-payment/status', 'CartController@getFlatterStatus')->name('cart.flutter.status');

    Route::get('status', function () {
        return view('frontend.cart.status');
    })->name('status');
    Route::post('cart/offline-payment', 'CartController@offlinePayment')->name('cart.offline.payment');
    Route::post('cart/getnow', 'CartController@getNow')->name('cart.getnow');
});

//============= Menu  Manager Routes ===============//
Route::namespace('Backend')->prefix('admin')->middleware(config('menu.middleware'))->group(function () {
    //Route::get('wmenuindex', array('uses'=>'\Harimayco\Menu\Controllers\MenuController@wmenuindex'));
    Route::post('add-custom-menu', 'MenuController@addcustommenu')->name('haddcustommenu');
    Route::post('delete-item-menu', 'MenuController@deleteitemmenu')->name('hdeleteitemmenu');
    Route::post('delete-menug', 'MenuController@deletemenug')->name('hdeletemenug');
    Route::post('create-new-menu', 'MenuController@createnewmenu')->name('hcreatenewmenu');
    Route::post('generate-menu-control', 'MenuController@generatemenucontrol')->name('hgeneratemenucontrol');
    Route::post('update-item', 'MenuController@updateitem')->name('hupdateitem');
    Route::post('save-custom-menu', 'MenuController@saveCustomMenu')->name('hcustomitem');
    Route::post('change-location', 'MenuController@updateLocation')->name('update-location');
});

Route::get('certificate-verification', 'Backend\CertificateController@getVerificationForm')->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', 'Backend\CertificateController@verifyCertificate')->name('frontend.certificates.verify');
Route::get('certificates/download', 'Backend\CertificateController@download')->name('certificates.download');

if (config('show_offers') == 1) {
    Route::get('offers', 'CartController@getOffers')->name('frontend.offers');
}

Route::prefix('laravel-filemanager')->middleware('web', 'auth', 'role:teacher|administrator')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('subscription')->group(function () {
    Route::get('plans', 'SubscriptionController@plans')->name('subscription.plans');
    Route::get('/{plan}/{name}', 'SubscriptionController@showForm')->name('subscription.form');
    Route::post('subscribe/{plan}', 'SubscriptionController@subscribe')->name('subscription.subscribe');
    Route::post('update/{plan}', 'SubscriptionController@updateSubscription')->name('subscription.update');
    Route::get('status', 'SubscriptionController@status')->name('subscription.status');
    Route::post('subscribe', 'SubscriptionController@courseSubscribed')->name('subscription.course_subscribe');
});

// wishlist
Route::post('add-to-wishlist', 'Backend\WishlistController@store')->name('add-to-wishlist');

Route::namespace('Frontend')->name('frontend.')->group(function () {
    Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
});
