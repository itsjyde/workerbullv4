<?php

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
    Route::resource('orders', 'Admin\OrderController');
});
Route::middleware('role:administrator')->group(function () {
    //===== Teachers Routes =====//
    Route::resource('teachers', 'Admin\TeachersController');
    Route::get('get-teachers-data', 'Admin\TeachersController@getData')->name('teachers.get_data');
    Route::post('teachers_mass_destroy', 'Admin\TeachersController@massDestroy')->name('teachers.mass_destroy');
    Route::post('teachers_restore/{id}', 'Admin\TeachersController@restore')->name('teachers.restore');
    Route::delete('teachers_perma_del/{id}', 'Admin\TeachersController@perma_del')->name('teachers.perma_del');
    Route::post('teacher/status', 'Admin\TeachersController@updateStatus')->name('teachers.status');

    //===== FORUMS Routes =====//
    Route::resource('forums-category', 'Admin\ForumController');
    Route::get('forums-category/status/{id}', 'Admin\ForumController@status')->name('forums-category.status');

    //===== Orders Routes =====//
    Route::get('get-orders-data', 'Admin\OrderController@getData')->name('orders.get_data');
    Route::post('orders_mass_destroy', 'Admin\OrderController@massDestroy')->name('orders.mass_destroy');
    Route::post('orders/complete', 'Admin\OrderController@complete')->name('orders.complete');
    Route::delete('orders_perma_del/{id}', 'Admin\OrderController@perma_del')->name('orders.perma_del');

    //===== Settings Routes =====//
    Route::get('settings/general', 'Admin\ConfigController@getGeneralSettings')->name('general-settings');

    Route::post('settings/general', 'Admin\ConfigController@saveGeneralSettings')->name('general-settings');

    Route::post('settings/contact', 'Admin\ConfigController@saveGeneralSettings')->name('general-contact');

    Route::get('settings/social', 'Admin\ConfigController@getSocialSettings')->name('social-settings');

    Route::post('settings/social', 'Admin\ConfigController@saveSocialSettings')->name('social-settings');

    Route::get('contact', 'Admin\ConfigController@getContact')->name('contact-settings');

    Route::get('footer', 'Admin\ConfigController@getFooter')->name('footer-settings');

    Route::get('newsletter', 'Admin\ConfigController@getNewsletterConfig')->name('newsletter-settings');

    Route::post('newsletter/sendgrid-lists', 'Admin\ConfigController@getSendGridLists')->name('newsletter.getSendGridLists');

    Route::get('settings/zoom', 'Admin\ConfigController@getZoomSettings')->name('zoom-settings');

    Route::post('settings/zoom', 'Admin\ConfigController@saveZoomSettings')->name('zoom-settings');

    //===== Slider Routes =====/
    Route::resource('sliders', 'Admin\SliderController');
    Route::get('sliders/status/{id}', 'Admin\SliderController@status')->name('sliders.status', 'id');
    Route::post('sliders/save-sequence', 'Admin\SliderController@saveSequence')->name('sliders.saveSequence');
    Route::post('sliders/status', 'Admin\SliderController@updateStatus')->name('sliders.status');

    //===== Sponsors Routes =====//
    Route::resource('sponsors', 'Admin\SponsorController');
    Route::get('get-sponsors-data', 'Admin\SponsorController@getData')->name('sponsors.get_data');
    Route::post('sponsors_mass_destroy', 'Admin\SponsorController@massDestroy')->name('sponsors.mass_destroy');
    Route::get('sponsors/status/{id}', 'Admin\SponsorController@status')->name('sponsors.status', 'id');
    Route::post('sponsors/status', 'Admin\SponsorController@updateStatus')->name('sponsors.status');

    //===== Testimonials Routes =====//
    Route::resource('testimonials', 'Admin\TestimonialController');
    Route::get('get-testimonials-data', 'Admin\TestimonialController@getData')->name('testimonials.get_data');
    Route::post('testimonials_mass_destroy', 'Admin\TestimonialController@massDestroy')->name('testimonials.mass_destroy');
    Route::get('testimonials/status/{id}', 'Admin\TestimonialController@status')->name('testimonials.status', 'id');
    Route::post('testimonials/status', 'Admin\TestimonialController@updateStatus')->name('testimonials.status');

    //===== FAQs Routes =====//
    Route::resource('faqs', 'Admin\FaqController');
    Route::get('get-faqs-data', 'Admin\FaqController@getData')->name('faqs.get_data');
    Route::post('faqs_mass_destroy', 'Admin\FaqController@massDestroy')->name('faqs.mass_destroy');
    Route::get('faqs/status/{id}', 'Admin\FaqController@status')->name('faqs.status');
    Route::post('faqs/status', 'Admin\FaqController@updateStatus')->name('faqs.status');

    //====== Contacts Routes =====//
    Route::resource('contact-requests', 'ContactController');
    Route::get('get-contact-requests-data', 'ContactController@getData')->name('contact_requests.get_data');

    //====== Tax Routes =====//
    Route::resource('tax', 'TaxController');
    Route::get('tax/status/{id}', 'TaxController@status')->name('tax.status', 'id');
    Route::post('tax/status', 'TaxController@updateStatus')->name('tax.status');

    //====== Coupon Routes =====//
    Route::resource('coupons', 'CouponController');
    Route::get('coupons/status/{id}', 'CouponController@status')->name('coupons.status', 'id');
    Route::post('coupons/status', 'CouponController@updateStatus')->name('coupons.status');

    //==== Remove Locale FIle ====//
    Route::post('delete-locale', function () {
        \Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

        \Illuminate\Support\Facades\File::deleteDirectory(public_path('../lang/'.request('locale')));
    })->name('delete-locale');

    //==== Update Theme Routes ====//
    Route::get('update-theme', 'UpdateController@index')->name('update-theme');
    Route::post('update-theme', 'UpdateController@updateTheme')->name('update-files');
    Route::post('list-files', 'UpdateController@listFiles')->name('list-files');
    Route::get('backup', 'BackupController@index')->name('backup');
    Route::get('generate-backup', 'BackupController@generateBackup')->name('generate-backup');

    Route::post('backup', 'BackupController@storeBackup')->name('backup.store');

    //===Trouble shoot ====//
    Route::get('troubleshoot', 'Admin\ConfigController@troubleshoot')->name('troubleshoot');

    //==== API Clients Routes ====//
    Route::prefix('api-client')->group(function () {
        Route::get('all', 'Admin\ApiClientController@all')->name('api-client.all');
        Route::post('generate', 'Admin\ApiClientController@generate')->name('api-client.generate');
        Route::post('status', 'Admin\ApiClientController@status')->name('api-client.status');
    });

    //==== Sitemap Routes =====//
    Route::get('sitemap', 'SitemapController@getIndex')->name('sitemap.index');
    Route::post('sitemap', 'SitemapController@saveSitemapConfig')->name('sitemap.config');
    Route::get('sitemap/generate', 'SitemapController@generateSitemap')->name('sitemap.generate');

    Route::post('translations/locales/add', 'LangController@postAddLocale');
    Route::post('translations/locales/remove', 'LangController@postRemoveLocaleFolder')->name('delete-locale-folder');
});

//Common - Shared Routes for Teacher and Administrator
Route::middleware('role:administrator|teacher')->group(function () {
    //====== Reports Routes =====//
    Route::get('report/sales', 'ReportController@getSalesReport')->name('reports.sales');
    Route::get('report/students', 'ReportController@getStudentsReport')->name('reports.students');

    Route::get('get-course-reports-data', 'ReportController@getCourseData')->name('reports.get_course_data');
    Route::get('get-bundle-reports-data', 'ReportController@getBundleData')->name('reports.get_bundle_data');
    Route::get('get-subscribe-reports-data', 'ReportController@getSubscibeData')->name('reports.get_subscribe_data');
    Route::get('get-students-reports-data', 'ReportController@getStudentsData')->name('reports.get_students_data');

    //====== Wallet  =====//
    Route::get('payments', 'PaymentController@index')->name('payments');
    Route::get('get-earning-data', 'PaymentController@getEarningData')->name('payments.get_earning_data');
    Route::get('get-withdrawal-data', 'PaymentController@getwithdrawalData')->name('payments.get_withdrawal_data');
    Route::get('payments/withdraw-request', 'PaymentController@createRequest')->name('payments.withdraw_request');
    Route::post('payments/withdraw-store', 'PaymentController@storeRequest')->name('payments.withdraw_store');
    Route::get('payments-requests', 'PaymentController@paymentRequest')->name('payments.requests');
    Route::get('get-payment-request-data', 'PaymentController@getPaymentRequestData')->name('payments.get_payment_request_data');
    Route::post('payments-request-update', 'PaymentController@paymentsRequestUpdate')->name('payments.payments_request_update');

    Route::get('menu-manager', 'MenuController@index')->name('menu-manager');
});

//===== Categories Routes =====//
Route::resource('categories', 'Admin\CategoriesController');
Route::get('get-categories-data', 'Admin\CategoriesController@getData')->name('categories.get_data');
Route::post('categories_mass_destroy', 'Admin\CategoriesController@massDestroy')->name('categories.mass_destroy');
Route::post('categories_restore/{id}', 'Admin\CategoriesController@restore')->name('categories.restore');
Route::delete('categories_perma_del/{id}', 'Admin\CategoriesController@perma_del')->name('categories.perma_del');

//===== Courses Routes =====//
Route::resource('courses', 'Admin\CoursesController');
Route::get('get-courses-data', 'Admin\CoursesController@getData')->name('courses.get_data');
Route::post('courses_mass_destroy', 'Admin\CoursesController@massDestroy')->name('courses.mass_destroy');
Route::post('courses_restore/{id}', 'Admin\CoursesController@restore')->name('courses.restore');
Route::delete('courses_perma_del/{id}', 'Admin\CoursesController@perma_del')->name('courses.perma_del');
Route::post('course-save-sequence', 'Admin\CoursesController@saveSequence')->name('courses.saveSequence');
Route::get('course-publish/{id}', 'Admin\CoursesController@publish')->name('courses.publish');

//===== Bundles Routes =====//
Route::resource('bundles', 'Admin\BundlesController');
Route::get('get-bundles-data', 'Admin\BundlesController@getData')->name('bundles.get_data');
Route::post('bundles_mass_destroy', 'Admin\BundlesController@massDestroy')->name('bundles.mass_destroy');
Route::post('bundles_restore/{id}', 'Admin\BundlesController@restore')->name('bundles.restore');
Route::delete('bundles_perma_del/{id}', 'Admin\BundlesController@perma_del')->name('bundles.perma_del');
Route::post('bundle-save-sequence', 'Admin\BundlesController@saveSequence')->name('bundles.saveSequence');
Route::get('bundle-publish/{id}', 'Admin\BundlesController@publish')->name('bundles.publish');

//===== Lessons Routes =====//
Route::resource('lessons', 'Admin\LessonsController');
Route::get('get-lessons-data', 'Admin\LessonsController@getData')->name('lessons.get_data');
Route::post('lessons_mass_destroy', 'Admin\LessonsController@massDestroy')->name('lessons.mass_destroy');
Route::post('lessons_restore/{id}', 'Admin\LessonsController@restore')->name('lessons.restore');
Route::delete('lessons_perma_del/{id}', 'Admin\LessonsController@perma_del')->name('lessons.perma_del');

//===== Questions Routes =====//
Route::resource('questions', 'Admin\QuestionsController');
Route::get('get-questions-data', 'Admin\QuestionsController@getData')->name('questions.get_data');
Route::post('questions_mass_destroy', 'Admin\QuestionsController@massDestroy')->name('questions.mass_destroy');
Route::post('questions_restore/{id}', 'Admin\QuestionsController@restore')->name('questions.restore');
Route::delete('questions_perma_del/{id}', 'Admin\QuestionsController@perma_del')->name('questions.perma_del');

//===== Questions Options Routes =====//
Route::resource('questions_options', 'Admin\QuestionsOptionsController');
Route::get('get-qo-data', 'Admin\QuestionsOptionsController@getData')->name('questions_options.get_data');
Route::post('questions_options_mass_destroy', 'Admin\QuestionsOptionsController@massDestroy')->name('questions_options.mass_destroy');
Route::post('questions_options_restore/{id}', 'Admin\QuestionsOptionsController@restore')->name('questions_options.restore');
Route::delete('questions_options_perma_del/{id}', 'Admin\QuestionsOptionsController@perma_del')->name('questions_options.perma_del');

//===== Tests Routes =====//
Route::resource('tests', 'Admin\TestsController');
Route::get('get-tests-data', 'Admin\TestsController@getData')->name('tests.get_data');
Route::post('tests_mass_destroy', 'Admin\TestsController@massDestroy')->name('tests.mass_destroy');
Route::post('tests_restore/{id}', 'Admin\TestsController@restore')->name('tests.restore');
Route::delete('tests_perma_del/{id}', 'Admin\TestsController@perma_del')->name('tests.perma_del');

//===== Media Routes =====//
Route::post('media/remove', 'Admin\MediaController@destroy')->name('media.destroy');

//===== User Account Routes =====//
Route::middleware('auth', 'password_expires')->group(function () {
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::patch('account/{email?}', [UserPasswordController::class, 'update'])->name('account.post');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('role:teacher')->group(function () {
    //====== Review Routes =====//
    Route::resource('reviews', 'ReviewController');
    Route::get('get-reviews-data', 'ReviewController@getData')->name('reviews.get_data');
});

Route::middleware('role:student')->group(function () {
    //==== Certificates ====//
    Route::get('certificates', 'CertificateController@getCertificates')->name('certificates.index');
    Route::post('certificates/generate', 'CertificateController@generateCertificate')->name('certificates.generate');
    Route::get('certificates/download', 'CertificateController@download')->name('certificates.download');
});

//==== Messages Routes =====//
Route::get('messages', 'MessagesController@index')->name('messages');
Route::post('messages/unread', 'MessagesController@getUnreadMessages')->name('messages.unread');
Route::post('messages/send', 'MessagesController@send')->name('messages.send');
Route::post('messages/reply', 'MessagesController@reply')->name('messages.reply');

//=== Invoice Routes =====//
Route::get('invoice/download/{order}', 'Admin\InvoiceController@getInvoice')->name('invoice.download');
Route::get('invoices/view/{code}', 'Admin\InvoiceController@showInvoice')->name('invoices.view');
Route::get('invoices', 'Admin\InvoiceController@getIndex')->name('invoices.index');

//======= Blog Routes =====//
Route::prefix('blog')->group(function () {
    Route::get('/create', 'Admin\BlogController@create');
    Route::post('/create', 'Admin\BlogController@store');
    Route::get('delete/{id}', 'Admin\BlogController@destroy')->name('blogs.delete');
    Route::get('edit/{id}', 'Admin\BlogController@edit')->name('blogs.edit');
    Route::post('edit/{id}', 'Admin\BlogController@update');
    Route::get('view/{id}', 'Admin\BlogController@show');
//        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
    Route::post('{id}/storecomment', 'Admin\BlogController@storeComment')->name('storeComment');
});
Route::resource('blogs', 'Admin\BlogController');
Route::get('get-blogs-data', 'Admin\BlogController@getData')->name('blogs.get_data');
Route::post('blogs_mass_destroy', 'Admin\BlogController@massDestroy')->name('blogs.mass_destroy');

//======= Pages Routes =====//
Route::resource('pages', 'Admin\PageController');
Route::get('get-pages-data', 'Admin\PageController@getData')->name('pages.get_data');
Route::post('pages_mass_destroy', 'Admin\PageController@massDestroy')->name('pages.mass_destroy');
Route::post('pages_restore/{id}', 'Admin\PageController@restore')->name('pages.restore');
Route::delete('pages_perma_del/{id}', 'Admin\PageController@perma_del')->name('pages.perma_del');

//==== Reasons Routes ====//
Route::resource('reasons', 'Admin\ReasonController');
Route::get('get-reasons-data', 'Admin\ReasonController@getData')->name('reasons.get_data');
Route::post('reasons_mass_destroy', 'Admin\ReasonController@massDestroy')->name('reasons.mass_destroy');
Route::get('reasons/status/{id}', 'Admin\ReasonController@status')->name('reasons.status');
Route::post('reasons/status', 'Admin\ReasonController@updateStatus')->name('reasons.status');

//==== Live Lessons ====//
Route::prefix('live-lessons')->group(function () {
    Route::get('data', 'LiveLessonController@getData')->name('live-lessons.get_data');
    Route::post('restore/{id}', 'LiveLessonController@restore')->name('live-lessons.restore');
    Route::delete('permanent/{id}', 'LiveLessonController@permanent')->name('live-lessons.perma_del');
});
Route::resource('live-lessons', 'LiveLessonController');

//==== Live Lessons Slot ====//
Route::prefix('live-lesson-slots')->group(function () {
    Route::get('data', 'LiveLessonSlotController@getData')->name('live-lesson-slots.get_data');
    Route::post('restore/{id}', 'LiveLessonSlotController@restore')->name('live-lesson-slots.restore');
    Route::delete('permanent/{id}', 'LiveLessonSlotController@permanent')->name('live-lesson-slots.perma_del');
});
Route::resource('live-lesson-slots', 'LiveLessonSlotController');

Route::namespace('Admin\Stripe')->prefix('stripe')->name('stripe.')->group(function () {
    //==== Stripe Plan Controller ====//
    Route::prefix('plans')->group(function () {
        Route::get('data', 'StripePlanController@getData')->name('plans.get_data');
        Route::post('restore/{id}', 'StripePlanController@restore')->name('plans.restore');
        Route::delete('permanent/{id}', 'StripePlanController@permanent')->name('plans.perma_del');
    });
    Route::resource('plans', 'StripePlanController');
});

Route::get('subscriptions', 'SubscriptionController')->name('subscriptions');
Route::get('subscription/invoice/{invoice}', 'SubscriptionController@downloadInvoice')->name('subscriptions.download_invoice');
Route::get('subscriptions/cancel', 'SubscriptionController@deleteSubscription')->name('subscriptions.delete');

// Wishlist Route
Route::get('wishlist/data', 'WishlistController@getData')->name('wishlist.get_data');
Route::resource('wishlist', 'WishlistController');
