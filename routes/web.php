<?php

use App\Http\Controllers\Backend;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BundlesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

Route::get('/sitemap-'.str_slug(config('app.name')).'/{file?}', [SitemapController::class, 'index']);

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
Route::name('frontend.')->group(function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::prefix('user')->name('admin.')->middleware('admin')->group(function () {
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

Route::prefix('user')->name('admin.')->middleware('auth')->group(function () {
    //==== Messages Routes =====//
    Route::get('messages', [Backend\MessagesController::class, 'index'])->name('messages');
    Route::post('messages/unread', [Backend\MessagesController::class, 'getUnreadMessages'])->name('messages.unread');
    Route::post('messages/send', [Backend\MessagesController::class, 'send'])->name('messages.send');
    Route::post('messages/reply', [Backend\MessagesController::class, 'reply'])->name('messages.reply');
});

Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
Route::get('blog/{slug?}', [BlogController::class, 'getIndex'])->name('blogs.index');
Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

Route::get('teachers', [Frontend\HomeController::class, 'getTeachers'])->name('teachers.index');
Route::get('teachers/{id}/show', [Frontend\HomeController::class, 'showTeacher'])->name('teachers.show');

Route::post('newsletter/subscribe', [Frontend\HomeController::class, 'subscribe'])->name('subscribe');

//============Course Routes=================//
Route::get('courses', [CoursesController::class, 'all'])->name('courses.all');
Route::get('course/{slug}', [CoursesController::class, 'show'])->name('courses.show')->middleware('subscribed');
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('course/{course_id}/rating', [CoursesController::class, 'rating'])->name('courses.rating');
Route::get('category/{category}/courses', [CoursesController::class, 'getByCategory'])->name('courses.category');
Route::post('courses/{id}/review', [CoursesController::class, 'addReview'])->name('courses.review');
Route::get('courses/review/{id}/edit', [CoursesController::class, 'editReview'])->name('courses.review.edit');
Route::post('courses/review/{id}/edit', [CoursesController::class, 'updateReview'])->name('courses.review.update');
Route::get('courses/review/{id}/delete', [CoursesController::class, 'deleteReview'])->name('courses.review.delete');

//============Bundle Routes=================//
Route::get('bundles', [BundlesController::class, 'all'])->name('bundles.all');
Route::get('bundle/{slug}', [BundlesController::class, 'show'])->name('bundles.show');
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('bundle/{bundle_id}/rating', [BundlesController::class, 'rating'])->name('bundles.rating');
Route::get('category/{category}/bundles', [BundlesController::class, 'getByCategory'])->name('bundles.category');
Route::post('bundles/{id}/review', [BundlesController::class, 'addReview'])->name('bundles.review');
Route::get('bundles/review/{id}/edit', [BundlesController::class, 'editReview'])->name('bundles.review.edit');
Route::post('bundles/review/{id}/edit', [BundlesController::class, 'updateReview'])->name('bundles.review.update');
Route::get('bundles/review/{id}/delete', [BundlesController::class, 'deleteReview'])->name('bundles.review.delete');

Route::middleware('auth')->group(function () {
    Route::get('lesson/{course_id}/{slug}/', [LessonsController::class, 'show'])->name('lessons.show');
    Route::post('lesson/{slug}/test', [LessonsController::class, 'test'])->name('lessons.test');
    Route::post('lesson/{slug}/retest', [LessonsController::class, 'retest'])->name('lessons.retest');
    Route::post('video/progress', [LessonsController::class, 'videoProgress'])->name('update.videos.progress');
    Route::post('lesson/progress', [LessonsController::class, 'courseProgress'])->name('update.course.progress');
    Route::post('lesson/book-slot', [LessonsController::class, 'bookSlot'])->name('lessons.course.book-slot');
});

Route::get('/search', [HomeController::class, 'searchCourse'])->name('search');
Route::get('/search-course', [HomeController::class, 'searchCourse'])->name('search-course');
Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');

Route::get('/faqs', [Frontend\HomeController::class, 'getFaqs'])->name('faqs');

/*=============== Theme blades routes ends ===================*/

Route::get('contact', [Frontend\ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [Frontend\ContactController::class, 'send'])->name('contact.send');

Route::get('download', [Frontend\HomeController::class, 'getDownload'])->name('download');

Route::middleware('auth')->group(function () {
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    Route::post('cart/stripe-payment', [CartController::class, 'stripePayment'])->name('cart.stripe.payment');
    Route::post('cart/paypal-payment', [CartController::class, 'paypalPayment'])->name('cart.paypal.payment');
    Route::get('cart/paypal-payment/status', [CartController::class, 'getPaymentStatus'])->name('cart.paypal.status');

    Route::post('cart/instamojo-payment', [CartController::class, 'instamojoPayment'])->name('cart.instamojo.payment');
    Route::get('cart/instamojo-payment/status', [CartController::class, 'getInstamojoStatus'])->name('cart.instamojo.status');

    Route::post('cart/razorpay-payment', [CartController::class, 'razorpayPayment'])->name('cart.razorpay.payment');
    Route::post('cart/razorpay-payment/status', [CartController::class, 'getRazorpayStatus'])->name('cart.razorpay.status');

    Route::post('cart/cashfree-payment', [CartController::class, 'cashfreeFreePayment'])->name('cart.cashfree.payment');
    Route::post('cart/cashfree-payment/status', [CartController::class, 'getCashFreeStatus'])->name('cart.cashfree.status');

    Route::post('cart/payu-payment', [CartController::class, 'payuPayment'])->name('cart.payu.payment');
    Route::post('cart/payu-payment/status', [CartController::class, 'getPayUStatus'])->name('cart.pauy.status');

    Route::match(['GET', 'POST'], 'cart/flutter-payment', ['uses' => [CartController::class, 'flatterPayment'], 'as' => 'cart.flutter.payment']);
    Route::get('cart/flutter-payment/status', [CartController::class, 'getFlatterStatus'])->name('cart.flutter.status');

    Route::get('status', function () {
        return view('frontend.cart.status');
    })->name('status');
    Route::post('cart/offline-payment', [CartController::class, 'offlinePayment'])->name('cart.offline.payment');
    Route::post('cart/getnow', [CartController::class, 'getNow'])->name('cart.getnow');
});

//============= Menu  Manager Routes ===============//
Route::prefix('admin')->middleware(config('menu.middleware'))->group(function () {
    //Route::get('wmenuindex', array('uses'=>'\Harimayco\Menu\Controllers\MenuController@wmenuindex'));
    Route::post('add-custom-menu', [Backend\MenuController::class, 'addcustommenu'])->name('haddcustommenu');
    Route::post('delete-item-menu', [Backend\MenuController::class, 'deleteitemmenu'])->name('hdeleteitemmenu');
    Route::post('delete-menug', [Backend\MenuController::class, 'deletemenug'])->name('hdeletemenug');
    Route::post('create-new-menu', [Backend\MenuController::class, 'createnewmenu'])->name('hcreatenewmenu');
    Route::post('generate-menu-control', [Backend\MenuController::class, 'generatemenucontrol'])->name('hgeneratemenucontrol');
    Route::post('update-item', [Backend\MenuController::class, 'updateitem'])->name('hupdateitem');
    Route::post('save-custom-menu', [Backend\MenuController::class, 'saveCustomMenu'])->name('hcustomitem');
    Route::post('change-location', [Backend\MenuController::class, 'updateLocation'])->name('update-location');
});

Route::get('certificate-verification', [Backend\CertificateController::class, 'getVerificationForm'])->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', [Backend\CertificateController::class, 'verifyCertificate'])->name('frontend.certificates.verify');
Route::get('certificates/download', [Backend\CertificateController::class, 'download'])->name('certificates.download');

if (config('show_offers') == 1) {
    Route::get('offers', [CartController::class, 'getOffers'])->name('frontend.offers');
}

Route::prefix('laravel-filemanager')->middleware('web', 'auth', 'role:teacher|administrator')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('subscription')->group(function () {
    Route::get('plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::get('/{plan}/{name}', [SubscriptionController::class, 'showForm'])->name('subscription.form');
    Route::post('subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('update/{plan}', [SubscriptionController::class, 'updateSubscription'])->name('subscription.update');
    Route::get('status', [SubscriptionController::class, 'status'])->name('subscription.status');
    Route::post('subscribe', [SubscriptionController::class, 'courseSubscribed'])->name('subscription.course_subscribe');
});

// wishlist
Route::post('add-to-wishlist', [Backend\WishlistController::class, 'store'])->name('add-to-wishlist');

Route::name('frontend.')->group(function () {
    Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
});
