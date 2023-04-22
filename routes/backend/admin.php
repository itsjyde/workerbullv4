<?php

use App\Http\Controllers\Backend\Admin;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\LiveLessonSlotController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\TaxController;
use App\Http\Controllers\Backend\WishlistController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\LiveLessonController;
use App\Http\Controllers\LiveLessonSlotController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\User\AccountController;
use App\Http\Controllers\Backend\Auth\User\ProfileController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\DashboardController;

/*
 * All route names are prefixed with 'admin.'.
 */

//===== General Routes =====//
Route::redirect('/', '/user/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('role:teacher|administrator')->group(function () {
    Route::resource('orders', Admin\OrderController::class);
});
Route::middleware('role:administrator')->group(function () {
    //===== Teachers Routes =====//
    Route::resource('teachers', Admin\TeachersController::class);
    Route::get('get-teachers-data', [Admin\TeachersController::class, 'getData'])->name('teachers.get_data');
    Route::post('teachers_mass_destroy', [Admin\TeachersController::class, 'massDestroy'])->name('teachers.mass_destroy');
    Route::post('teachers_restore/{id}', [Admin\TeachersController::class, 'restore'])->name('teachers.restore');
    Route::delete('teachers_perma_del/{id}', [Admin\TeachersController::class, 'perma_del'])->name('teachers.perma_del');
    Route::post('teacher/status', [Admin\TeachersController::class, 'updateStatus'])->name('teachers.status');

    //===== FORUMS Routes =====//
    Route::resource('forums-category', Admin\ForumController::class);
    Route::get('forums-category/status/{id}', [Admin\ForumController::class, 'status'])->name('forums-category.status');

    //===== Orders Routes =====//
    Route::get('get-orders-data', [Admin\OrderController::class, 'getData'])->name('orders.get_data');
    Route::post('orders_mass_destroy', [Admin\OrderController::class, 'massDestroy'])->name('orders.mass_destroy');
    Route::post('orders/complete', [Admin\OrderController::class, 'complete'])->name('orders.complete');
    Route::delete('orders_perma_del/{id}', [Admin\OrderController::class, 'perma_del'])->name('orders.perma_del');

    //===== Settings Routes =====//
    Route::get('settings/general', [Admin\ConfigController::class, 'getGeneralSettings'])->name('general-settings');

    Route::post('settings/general', [Admin\ConfigController::class, 'saveGeneralSettings'])->name('general-settings');

    Route::post('settings/contact', [Admin\ConfigController::class, 'saveGeneralSettings'])->name('general-contact');

    Route::get('settings/social', [Admin\ConfigController::class, 'getSocialSettings'])->name('social-settings');

    Route::post('settings/social', [Admin\ConfigController::class, 'saveSocialSettings'])->name('social-settings');

    Route::get('contact', [Admin\ConfigController::class, 'getContact'])->name('contact-settings');

    Route::get('footer', [Admin\ConfigController::class, 'getFooter'])->name('footer-settings');

    Route::get('newsletter', [Admin\ConfigController::class, 'getNewsletterConfig'])->name('newsletter-settings');

    Route::post('newsletter/sendgrid-lists', [Admin\ConfigController::class, 'getSendGridLists'])->name('newsletter.getSendGridLists');

    Route::get('settings/zoom', [Admin\ConfigController::class, 'getZoomSettings'])->name('zoom-settings');

    Route::post('settings/zoom', [Admin\ConfigController::class, 'saveZoomSettings'])->name('zoom-settings');

    //===== Slider Routes =====/
    Route::resource('sliders', Admin\SliderController::class);
    Route::get('sliders/status/{id}', [Admin\SliderController::class, 'status'])->name('sliders.status', 'id');
    Route::post('sliders/save-sequence', [Admin\SliderController::class, 'saveSequence'])->name('sliders.saveSequence');
    Route::post('sliders/status', [Admin\SliderController::class, 'updateStatus'])->name('sliders.status');

    //===== Sponsors Routes =====//
    Route::resource('sponsors', Admin\SponsorController::class);
    Route::get('get-sponsors-data', [Admin\SponsorController::class, 'getData'])->name('sponsors.get_data');
    Route::post('sponsors_mass_destroy', [Admin\SponsorController::class, 'massDestroy'])->name('sponsors.mass_destroy');
    Route::get('sponsors/status/{id}', [Admin\SponsorController::class, 'status'])->name('sponsors.status', 'id');
    Route::post('sponsors/status', [Admin\SponsorController::class, 'updateStatus'])->name('sponsors.status');

    //===== Testimonials Routes =====//
    Route::resource('testimonials', Admin\TestimonialController::class);
    Route::get('get-testimonials-data', [Admin\TestimonialController::class, 'getData'])->name('testimonials.get_data');
    Route::post('testimonials_mass_destroy', [Admin\TestimonialController::class, 'massDestroy'])->name('testimonials.mass_destroy');
    Route::get('testimonials/status/{id}', [Admin\TestimonialController::class, 'status'])->name('testimonials.status', 'id');
    Route::post('testimonials/status', [Admin\TestimonialController::class, 'updateStatus'])->name('testimonials.status');

    //===== FAQs Routes =====//
    Route::resource('faqs', Admin\FaqController::class);
    Route::get('get-faqs-data', [Admin\FaqController::class, 'getData'])->name('faqs.get_data');
    Route::post('faqs_mass_destroy', [Admin\FaqController::class, 'massDestroy'])->name('faqs.mass_destroy');
    Route::get('faqs/status/{id}', [Admin\FaqController::class, 'status'])->name('faqs.status');
    Route::post('faqs/status', [Admin\FaqController::class, 'updateStatus'])->name('faqs.status');

    //====== Contacts Routes =====//
    Route::resource('contact-requests', 'ContactController');
    Route::get('get-contact-requests-data', [ContactController::class, 'getData'])->name('contact_requests.get_data');

    //====== Tax Routes =====//
    Route::resource('tax', TaxController::class);
    Route::get('tax/status/{id}', [TaxController::class, 'status'])->name('tax.status', 'id');
    Route::post('tax/status', [TaxController::class, 'updateStatus'])->name('tax.status');

    //====== Coupon Routes =====//
    Route::resource('coupons', CouponController::class);
    Route::get('coupons/status/{id}', [CouponController::class, 'status'])->name('coupons.status', 'id');
    Route::post('coupons/status', [CouponController::class, 'updateStatus'])->name('coupons.status');

    //==== Remove Locale FIle ====//
    Route::post('delete-locale', function () {
        \Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

        \Illuminate\Support\Facades\File::deleteDirectory(public_path('../lang/'.request('locale')));
    })->name('delete-locale');

    //==== Update Theme Routes ====//
    Route::get('update-theme', [UpdateController::class, 'index'])->name('update-theme');
    Route::post('update-theme', [UpdateController::class, 'updateTheme'])->name('update-files');
    Route::post('list-files', [UpdateController::class, 'listFiles'])->name('list-files');
    Route::get('backup', [BackupController::class, 'index'])->name('backup');
    Route::get('generate-backup', [BackupController::class, 'generateBackup'])->name('generate-backup');

    Route::post('backup', [BackupController::class, 'storeBackup'])->name('backup.store');

    //===Trouble shoot ====//
    Route::get('troubleshoot', [Admin\ConfigController::class, 'troubleshoot'])->name('troubleshoot');

    //==== API Clients Routes ====//
    Route::prefix('api-client')->group(function () {
        Route::get('all', [Admin\ApiClientController::class, 'all'])->name('api-client.all');
        Route::post('generate', [Admin\ApiClientController::class, 'generate'])->name('api-client.generate');
        Route::post('status', [Admin\ApiClientController::class, 'status'])->name('api-client.status');
    });

    //==== Sitemap Routes =====//
    Route::get('sitemap', [SitemapController::class, 'getIndex'])->name('sitemap.index');
    Route::post('sitemap', [SitemapController::class, 'saveSitemapConfig'])->name('sitemap.config');
    Route::get('sitemap/generate', [SitemapController::class, 'generateSitemap'])->name('sitemap.generate');

    Route::post('translations/locales/add', [LangController::class, 'postAddLocale']);
    Route::post('translations/locales/remove', [LangController::class, 'postRemoveLocaleFolder'])->name('delete-locale-folder');
});

//Common - Shared Routes for Teacher and Administrator
Route::middleware('role:administrator|teacher')->group(function () {
    //====== Reports Routes =====//
    Route::get('report/sales', [ReportController::class, 'getSalesReport'])->name('reports.sales');
    Route::get('report/students', [ReportController::class, 'getStudentsReport'])->name('reports.students');

    Route::get('get-course-reports-data', [ReportController::class, 'getCourseData'])->name('reports.get_course_data');
    Route::get('get-bundle-reports-data', [ReportController::class, 'getBundleData'])->name('reports.get_bundle_data');
    Route::get('get-subscribe-reports-data', [ReportController::class, 'getSubscibeData'])->name('reports.get_subscribe_data');
    Route::get('get-students-reports-data', [ReportController::class, 'getStudentsData'])->name('reports.get_students_data');

    //====== Wallet  =====//
    Route::get('payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('get-earning-data', [PaymentController::class, 'getEarningData'])->name('payments.get_earning_data');
    Route::get('get-withdrawal-data', [PaymentController::class, 'getwithdrawalData'])->name('payments.get_withdrawal_data');
    Route::get('payments/withdraw-request', [PaymentController::class, 'createRequest'])->name('payments.withdraw_request');
    Route::post('payments/withdraw-store', [PaymentController::class, 'storeRequest'])->name('payments.withdraw_store');
    Route::get('payments-requests', [PaymentController::class, 'paymentRequest'])->name('payments.requests');
    Route::get('get-payment-request-data', [PaymentController::class, 'getPaymentRequestData'])->name('payments.get_payment_request_data');
    Route::post('payments-request-update', [PaymentController::class, 'paymentsRequestUpdate'])->name('payments.payments_request_update');

    Route::get('menu-manager', [MenuController::class, 'index'])->name('menu-manager');
});

//===== Categories Routes =====//
Route::resource('categories', Admin\CategoriesController::class);
Route::get('get-categories-data', [Admin\CategoriesController::class, 'getData'])->name('categories.get_data');
Route::post('categories_mass_destroy', [Admin\CategoriesController::class, 'massDestroy'])->name('categories.mass_destroy');
Route::post('categories_restore/{id}', [Admin\CategoriesController::class, 'restore'])->name('categories.restore');
Route::delete('categories_perma_del/{id}', [Admin\CategoriesController::class, 'perma_del'])->name('categories.perma_del');

//===== Courses Routes =====//
Route::resource('courses', 'Admin\CoursesController');
Route::get('get-courses-data', [Admin\CoursesController::class, 'getData'])->name('courses.get_data');
Route::post('courses_mass_destroy', [Admin\CoursesController::class, 'massDestroy'])->name('courses.mass_destroy');
Route::post('courses_restore/{id}', [Admin\CoursesController::class, 'restore'])->name('courses.restore');
Route::delete('courses_perma_del/{id}', [Admin\CoursesController::class, 'perma_del'])->name('courses.perma_del');
Route::post('course-save-sequence', [Admin\CoursesController::class, 'saveSequence'])->name('courses.saveSequence');
Route::get('course-publish/{id}', [Admin\CoursesController::class, 'publish'])->name('courses.publish');

//===== Bundles Routes =====//
Route::resource('bundles', 'Admin\BundlesController');
Route::get('get-bundles-data', [Admin\BundlesController::class, 'getData'])->name('bundles.get_data');
Route::post('bundles_mass_destroy', [Admin\BundlesController::class, 'massDestroy'])->name('bundles.mass_destroy');
Route::post('bundles_restore/{id}', [Admin\BundlesController::class, 'restore'])->name('bundles.restore');
Route::delete('bundles_perma_del/{id}', [Admin\BundlesController::class, 'perma_del'])->name('bundles.perma_del');
Route::post('bundle-save-sequence', [Admin\BundlesController::class, 'saveSequence'])->name('bundles.saveSequence');
Route::get('bundle-publish/{id}', [Admin\BundlesController::class, 'publish'])->name('bundles.publish');

//===== Lessons Routes =====//
Route::resource('lessons', 'Admin\LessonsController');
Route::get('get-lessons-data', [Admin\LessonsController::class, 'getData'])->name('lessons.get_data');
Route::post('lessons_mass_destroy', [Admin\LessonsController::class, 'massDestroy'])->name('lessons.mass_destroy');
Route::post('lessons_restore/{id}', [Admin\LessonsController::class, 'restore'])->name('lessons.restore');
Route::delete('lessons_perma_del/{id}', [Admin\LessonsController::class, 'perma_del'])->name('lessons.perma_del');

//===== Questions Routes =====//
Route::resource('questions', Admin\QuestionsController::class);
Route::get('get-questions-data', [Admin\QuestionsController::class, 'getData'])->name('questions.get_data');
Route::post('questions_mass_destroy', [Admin\QuestionsController::class, 'massDestroy'])->name('questions.mass_destroy');
Route::post('questions_restore/{id}', [Admin\QuestionsController::class, 'restore'])->name('questions.restore');
Route::delete('questions_perma_del/{id}', [Admin\QuestionsController::class, 'perma_del'])->name('questions.perma_del');

//===== Questions Options Routes =====//
Route::resource('questions_options', Admin\QuestionsOptionsController::class);
Route::get('get-qo-data', [Admin\QuestionsOptionsController::class, 'getData'])->name('questions_options.get_data');
Route::post('questions_options_mass_destroy', [Admin\QuestionsOptionsController::class, 'massDestroy'])->name('questions_options.mass_destroy');
Route::post('questions_options_restore/{id}', [Admin\QuestionsOptionsController::class, 'restore'])->name('questions_options.restore');
Route::delete('questions_options_perma_del/{id}', [Admin\QuestionsOptionsController::class, 'perma_del'])->name('questions_options.perma_del');

//===== Tests Routes =====//
Route::resource('tests', Admin\TestsController::class);
Route::get('get-tests-data', [Admin\TestsController::class, 'getData'])->name('tests.get_data');
Route::post('tests_mass_destroy', [Admin\TestsController::class, 'massDestroy'])->name('tests.mass_destroy');
Route::post('tests_restore/{id}', [Admin\TestsController::class, 'restore'])->name('tests.restore');
Route::delete('tests_perma_del/{id}', [Admin\TestsController::class, 'perma_del'])->name('tests.perma_del');

//===== Media Routes =====//
Route::post('media/remove', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

//===== User Account Routes =====//
Route::middleware('auth', 'password_expires')->group(function () {
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::patch('account/{email?}', [UserPasswordController::class, 'update'])->name('account.post');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('role:teacher')->group(function () {
    //====== Review Routes =====//
    Route::resource('reviews', ReviewController::class);
    Route::get('get-reviews-data', [ReviewController::class, 'getData'])->name('reviews.get_data');
});

Route::middleware('role:student')->group(function () {
    //==== Certificates ====//
    Route::get('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
    Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');
    Route::get('certificates/download', [CertificateController::class, 'download'])->name('certificates.download');
});

//==== Messages Routes =====//
Route::get('messages', [MessagesController::class, 'index'])->name('messages');
Route::post('messages/unread', [MessagesController::class, 'getUnreadMessages'])->name('messages.unread');
Route::post('messages/send', [MessagesController::class, 'send'])->name('messages.send');
Route::post('messages/reply', [MessagesController::class, 'reply'])->name('messages.reply');

//=== Invoice Routes =====//
Route::get('invoice/download/{order}', [Admin\InvoiceController::class, 'getInvoice'])->name('invoice.download');
Route::get('invoices/view/{code}', [Admin\InvoiceController::class, 'showInvoice'])->name('invoices.view');
Route::get('invoices', [Admin\InvoiceController::class, 'getIndex'])->name('invoices.index');

//======= Blog Routes =====//
Route::prefix('blog')->group(function () {
    Route::get('/create', [Admin\BlogController::class, 'create']);
    Route::post('/create', [Admin\BlogController::class, 'store']);
    Route::get('delete/{id}', [Admin\BlogController::class, 'destroy'])->name('blogs.delete');
    Route::get('edit/{id}', [Admin\BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('edit/{id}', [Admin\BlogController::class, 'update']);
    Route::get('view/{id}', [Admin\BlogController::class, 'show']);
//        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
    Route::post('{id}/storecomment', [Admin\BlogController::class, 'storeComment'])->name('storeComment');
});
Route::resource('blogs', 'Admin\BlogController');
Route::get('get-blogs-data', [Admin\BlogController::class, 'getData'])->name('blogs.get_data');
Route::post('blogs_mass_destroy', [Admin\BlogController::class, 'massDestroy'])->name('blogs.mass_destroy');

//======= Pages Routes =====//
Route::resource('pages', Admin\PageController::class);
Route::get('get-pages-data', [Admin\PageController::class, 'getData'])->name('pages.get_data');
Route::post('pages_mass_destroy', [Admin\PageController::class, 'massDestroy'])->name('pages.mass_destroy');
Route::post('pages_restore/{id}', [Admin\PageController::class, 'restore'])->name('pages.restore');
Route::delete('pages_perma_del/{id}', [Admin\PageController::class, 'perma_del'])->name('pages.perma_del');

//==== Reasons Routes ====//
Route::resource('reasons', Admin\ReasonController::class);
Route::get('get-reasons-data', [Admin\ReasonController::class, 'getData'])->name('reasons.get_data');
Route::post('reasons_mass_destroy', [Admin\ReasonController::class, 'massDestroy'])->name('reasons.mass_destroy');
Route::get('reasons/status/{id}', [Admin\ReasonController::class, 'status'])->name('reasons.status');
Route::post('reasons/status', [Admin\ReasonController::class, 'updateStatus'])->name('reasons.status');

//==== Live Lessons ====//
Route::prefix('live-lessons')->group(function () {
    Route::get('data', [LiveLessonController::class, 'getData'])->name('live-lessons.get_data');
    Route::post('restore/{id}', [LiveLessonController::class, 'restore'])->name('live-lessons.restore');
    Route::delete('permanent/{id}', [LiveLessonController::class, 'permanent'])->name('live-lessons.perma_del');
});
Route::resource('live-lessons', 'LiveLessonController');

//==== Live Lessons Slot ====//
Route::prefix('live-lesson-slots')->group(function () {
    Route::get('data', [LiveLessonSlotController::class, 'getData'])->name('live-lesson-slots.get_data');
    Route::post('restore/{id}', [LiveLessonSlotController::class, 'restore'])->name('live-lesson-slots.restore');
    Route::delete('permanent/{id}', [LiveLessonSlotController::class, 'permanent'])->name('live-lesson-slots.perma_del');
});
Route::resource('live-lesson-slots', LiveLessonSlotController::class);

Route::prefix('stripe')->name('stripe.')->group(function () {
    //==== Stripe Plan Controller ====//
    Route::prefix('plans')->group(function () {
        Route::get('data', [Admin\Stripe\StripePlanController::class, 'getData'])->name('plans.get_data');
        Route::post('restore/{id}', [Admin\Stripe\StripePlanController::class, 'restore'])->name('plans.restore');
        Route::delete('permanent/{id}', [Admin\Stripe\StripePlanController::class, 'permanent'])->name('plans.perma_del');
    });
    Route::resource('plans', 'StripePlanController');
});

Route::get('subscriptions', SubscriptionController::class)->name('subscriptions');
Route::get('subscription/invoice/{invoice}', [SubscriptionController::class, 'downloadInvoice'])->name('subscriptions.download_invoice');
Route::get('subscriptions/cancel', [SubscriptionController::class, 'deleteSubscription'])->name('subscriptions.delete');

// Wishlist Route
Route::get('wishlist/data', [WishlistController::class, 'getData'])->name('wishlist.get_data');
Route::resource('wishlist', WishlistController::class);
