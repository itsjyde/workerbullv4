<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value is the version of your application. This value is used when
    | the framework needs to place the application's version in a notification
    | or any other location as required by the application or its packages.
    |
    */
    'version' => '5.4.1',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Date Format
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default date format for your application, which
    | will be used with date and date-time functions.
    |
    */

    'date_format' => 'Y-m-d',
    'date_format_js' => 'yy-mm-dd',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */
    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | PHP Locale Code
    |--------------------------------------------------------------------------
    |
    | The PHP locale determines the default locale that will be used
    | by the Carbon library when setting Carbon's localization.
    |
    */
    'locale_php' => env('APP_LOCALE_PHP', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,

        /*
         * Package Service Providers that aren't auto-discover...
         */
        UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,
        Yajra\DataTables\DataTablesServiceProvider::class,
        Yajra\DataTables\ButtonsServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        //        Gerardojbaez\Messenger\MessengerServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        Darryldecode\Cart\CartServiceProvider::class,
        ConsoleTVs\Invoices\InvoicesServiceProvider::class,
        Harimayco\Menu\MenuServiceProvider::class,

        Barryvdh\TranslationManager\ManagerServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,

        Maatwebsite\Excel\ExcelServiceProvider::class,
        BC\Laravel\DropboxDriver\ServiceProvider::class,
        Mtownsend\ReadTime\Providers\ReadTimeServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BladeServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\ObserverServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'Active' => HieuLe\Active\Facades\Active::class,
        'Agent' => Jenssegers\Agent\Facades\Agent::class,
        'Cart' => Darryldecode\Cart\Facades\CartFacade::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Form' => Collective\Html\FormFacade::class,
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Menu' => Harimayco\Menu\Facades\Menu::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
    ])->toArray(),

    /*
   |--------------------------------------------------------------------------
   | Theme layout type
   |--------------------------------------------------------------------------
   */
    'theme_layout' => 1,

    /*
   |--------------------------------------------------------------------------
   | Theme Font color
   | you can any of the following :
   | "color-2", "color-3", "color-4", "color-5", "color-6", "color-7", "color-8",
   | "color-9" and "default"
   |--------------------------------------------------------------------------
   */
    'font_color' => 'default',

    /*
   |--------------------------------------------------------------------------
   | Theme Layout Type
   | You can choose from any two "wide" and "box"
   |--------------------------------------------------------------------------
   */
    'layout_type' => 'wide',

    /*
   |--------------------------------------------------------------------------
   | Counter
   | You can use "static" or "Database" option from backend
   |--------------------------------------------------------------------------
   */
    'counter' => 1,
    'total_students' => '1M+',
    'total_courses' => '1k+',
    'total_teachers' => '200+',

    /*
    |--------------------------------------------------------------------------
    | Logos
    | For entire frontend.
    |--------------------------------------------------------------------------
    *
    'logo_b_image' => 'logo-b-image.png',
    'logo_w_image' => 'logo-w-image.png',
    'logo_white_image' => 'logo-white.png',
    'popup_logo' => 'popup-logo.jpg',
    'favicon_image' => 'popup-logo.jpg',

     /*
    |--------------------------------------------------------------------------
    | Contact Data
    |--------------------------------------------------------------------------
    */
    'contact_data' => '{[]}',

    'debug_blacklist' => [
        '_ENV' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET',
        ],
        '_SERVER' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET',
        ],
        '_POST' => [
            'password',
        ],
    ],

];
