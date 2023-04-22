<?php

use App\Http\Controllers\v1;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
//    Route::post('login', 'ApiController@login');
        Route::post('signup-form', [v1\ApiController::class, 'signupForm']);
        Route::post('signup-save', [v1\ApiController::class, 'signup']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [v1\ApiController::class, 'logout']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('courses', [v1\ApiController::class, 'getCourses']);
        Route::post('bundles', [v1\ApiController::class, 'getBundles']);
        Route::post('search', [v1\ApiController::class, 'search']);
        Route::post('latest-news', [v1\ApiController::class, 'getLatestNews']);
        Route::post('testimonials', [v1\ApiController::class, 'getTestimonials']);
        Route::post('teachers', [v1\ApiController::class, 'getTeachers']);
        Route::post('single-teacher', [v1\ApiController::class, 'getSingleTeacher']);
        Route::post('teacher-courses', [v1\ApiController::class, 'getTeacherCourses']);
        Route::post('teacher-bundles', [v1\ApiController::class, 'getTeacherBundles']);
        Route::post('get-faqs', [v1\ApiController::class, 'getFaqs']);
        Route::post('why-us', [v1\ApiController::class, 'getWhyUs']);
        Route::post('sponsors', [v1\ApiController::class, 'getSponsors']);
        Route::post('contact-us', [v1\ApiController::class, 'saveContactUs']);
        Route::post('single-course', [v1\ApiController::class, 'getSingleCourse']);
        Route::post('submit-review', [v1\ApiController::class, 'submitReview']);
        Route::post('update-review', [v1\ApiController::class, 'updateReview']);
        Route::post('single-lesson', [v1\ApiController::class, 'getLesson']);
        Route::post('single-live-lesson', [v1\ApiController::class, 'getLiveLesson']);
        Route::post('booked-lesson-slot', [v1\ApiController::class, 'bookedSlot']);
        Route::post('single-test', [v1\ApiController::class, 'getTest']);
        Route::post('save-test', [v1\ApiController::class, 'saveTest']);
        Route::post('video-progress', [v1\ApiController::class, 'videoProgress']);
        Route::post('course-progress', [v1\ApiController::class, 'courseProgress']);
        Route::post('generate-certificate', [v1\ApiController::class, 'generateCertificate']);
        Route::post('single-bundle', [v1\ApiController::class, 'getSingleBundle']);
        Route::post('add-to-cart', [v1\ApiController::class, 'addToCart']);
        Route::post('getnow', [v1\ApiController::class, 'getNow']);
        Route::post('remove-from-cart', [v1\ApiController::class, 'removeFromCart']);
        Route::post('get-cart-data', [v1\ApiController::class, 'getCartData']);
        Route::post('clear-cart', [v1\ApiController::class, 'clearCart']);
        Route::post('payment-status', [v1\ApiController::class, 'paymentStatus']);
        Route::post('get-blog', [v1\ApiController::class, 'getBlog']);
        Route::post('blog-by-category', [v1\ApiController::class, 'getBlogByCategory']);
        Route::post('blog-by-tag', [v1\ApiController::class, 'getBlogByTag']);
        Route::post('add-blog-comment', [v1\ApiController::class, 'addBlogComment']);
        Route::post('delete-blog-comment', [v1\ApiController::class, 'deleteBlogComment']);
        Route::post('forum', [v1\ApiController::class, 'getForum']);
        Route::post('create-discussion', [v1\ApiController::class, 'createDiscussion']);
        Route::post('store-response', [v1\ApiController::class, 'storeResponse']);
        Route::post('update-response', [v1\ApiController::class, 'updateResponse']);
        Route::post('delete-response', [v1\ApiController::class, 'deleteResponse']);
        Route::post('messages', [v1\ApiController::class, 'getMessages']);
        Route::post('compose-message', [v1\ApiController::class, 'composeMessage']);
        Route::post('reply-message', [v1\ApiController::class, 'replyMessage']);
        Route::post('unread-messages', [v1\ApiController::class, 'getUnreadMessages']);
        Route::post('search-messages', [v1\ApiController::class, 'searchMessages']);
        Route::post('my-certificates', [v1\ApiController::class, 'getMyCertificates']);
        Route::post('my-purchases', [v1\ApiController::class, 'getMyPurchases']);
        Route::post('my-account', [v1\ApiController::class, 'getMyAccount']);
        Route::post('update-account', [v1\ApiController::class, 'updateMyAccount']);
        Route::post('update-password', [v1\ApiController::class, 'updatePassword']);
        Route::post('get-page', [v1\ApiController::class, 'getPage']);
        Route::post('subscribe-newsletter', [v1\ApiController::class, 'subscribeNewsletter']);
        Route::post('offers', [v1\ApiController::class, 'getOffers']);
        Route::post('apply-coupon', [v1\ApiController::class, 'applyCoupon']);
        Route::post('remove-coupon', [v1\ApiController::class, 'removeCoupon']);
        Route::post('order-confirmation', [v1\ApiController::class, 'orderConfirmation']);
        Route::post('single-user', [v1\ApiController::class, 'getSingleUser']);
        Route::post('subscription-plans', [v1\ApiController::class, 'subscriptionsPlans']);
        Route::post('my-subscription', [v1\ApiController::class, 'mySubscription']);
        Route::post('subscribed', [v1\ApiController::class, 'subscribeBundleOrCourse']);
        Route::post('subscribed', [v1\ApiController::class, 'subscribeBundleOrCourse']);
        Route::post('add-to-wishlist', [v1\ApiController::class, 'addToWishlist']);
        Route::post('wishlist', [v1\ApiController::class, 'wishlist']);
    });
    Route::post('send-reset-link', v1\ApiController::class);
    Route::post('configs', [v1\ApiController::class, 'getConfigs']);
});
