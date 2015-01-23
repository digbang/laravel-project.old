<?php
return array(

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

	'debug' => !isset($_SERVER['APP_ENV']) ?: $_SERVER['APP_ENV'] != 'production',

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	| Also, we are using this parameter to build the Live Reload URL, and
	| for that, we need it to be WITHOUT trailing slash!
	|
	*/

	'url' => $_ENV['SERVER_URL'],

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

	'timezone' => 'UTC',

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

	'locale' => 'en',

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

	'fallback_locale' => 'en',

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

	'key' => 'WzNi28vDtdtwbP9naeGNLKCDlebVMTzX',

	'cipher' => MCRYPT_RIJNDAEL_128,

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

	'providers' => array(

		Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
		Illuminate\Auth\AuthServiceProvider::class,
		Illuminate\Cache\CacheServiceProvider::class,
		Illuminate\Session\CommandsServiceProvider::class,
		Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		Illuminate\Routing\ControllerServiceProvider::class,
		Illuminate\Cookie\CookieServiceProvider::class,
		Illuminate\Database\DatabaseServiceProvider::class,
		Illuminate\Encryption\EncryptionServiceProvider::class,
		Illuminate\Filesystem\FilesystemServiceProvider::class,
		Illuminate\Hashing\HashServiceProvider::class,
		Illuminate\Html\HtmlServiceProvider::class,
		Illuminate\Log\LogServiceProvider::class,
		Illuminate\Mail\MailServiceProvider::class,
		Illuminate\Database\MigrationServiceProvider::class,
		Illuminate\Pagination\PaginationServiceProvider::class,
		Illuminate\Queue\QueueServiceProvider::class,
		Illuminate\Redis\RedisServiceProvider::class,
		Illuminate\Remote\RemoteServiceProvider::class,
		Illuminate\Auth\Reminders\ReminderServiceProvider::class,
		Illuminate\Database\SeedServiceProvider::class,
		Illuminate\Session\SessionServiceProvider::class,
		Illuminate\Translation\TranslationServiceProvider::class,
		Illuminate\Validation\ValidationServiceProvider::class,
		Illuminate\View\ViewServiceProvider::class,
		Illuminate\Workbench\WorkbenchServiceProvider::class,
		Mitch\LaravelDoctrine\LaravelDoctrineServiceProvider::class,
		Jenssegers\Agent\AgentServiceProvider::class,
		Barryvdh\Debugbar\ServiceProvider::class,
		Fedeisas\LaravelJsRoutes\LaravelJsRoutesServiceProvider::class,
		Intervention\Image\ImageServiceProvider::class,
		Cviebrock\ImageValidator\ImageValidatorServiceProvider::class,
		App\ServiceProviders\DomainServiceProvider::class,
		App\ServiceProviders\DataSourceServiceProvider::class,
		App\ServiceProviders\HttpServiceProvider::class
	),

	/*
	|--------------------------------------------------------------------------
	| Service Provider Manifest
	|--------------------------------------------------------------------------
	|
	| The service provider manifest is used by Laravel to lazy load service
	| providers which are not needed for each request, as well to keep a
	| list of all of the services. Here, you may set its storage spot.
	|
	*/

	'manifest' => storage_path().'/meta',

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

	'aliases' => array(

		'App'               => Illuminate\Support\Facades\App::class,
		'Artisan'           => Illuminate\Support\Facades\Artisan::class,
		'Auth'              => Illuminate\Support\Facades\Auth::class,
		'Blade'             => Illuminate\Support\Facades\Blade::class,
		'Cache'             => Illuminate\Support\Facades\Cache::class,
		'ClassLoader'       => Illuminate\Support\ClassLoader::class,
		'Config'            => Illuminate\Support\Facades\Config::class,
		'Controller'        => Illuminate\Routing\Controller::class,
		'Cookie'            => Illuminate\Support\Facades\Cookie::class,
		'Crypt'             => Illuminate\Support\Facades\Crypt::class,
		'DB'                => Illuminate\Support\Facades\DB::class,
		'Eloquent'          => Illuminate\Database\Eloquent\Model::class,
		'Event'             => Illuminate\Support\Facades\Event::class,
		'File'              => Illuminate\Support\Facades\File::class,
		'Form'              => Illuminate\Support\Facades\Form::class,
		'Hash'              => Illuminate\Support\Facades\Hash::class,
		'HTML'              => Illuminate\Support\Facades\HTML::class,
		'Input'             => Illuminate\Support\Facades\Input::class,
		'Lang'              => Illuminate\Support\Facades\Lang::class,
		'Log'               => Illuminate\Support\Facades\Log::class,
		'Mail'              => Illuminate\Support\Facades\Mail::class,
		'Paginator'         => Illuminate\Support\Facades\Paginator::class,
		'Password'          => Illuminate\Support\Facades\Password::class,
		'Queue'             => Illuminate\Support\Facades\Queue::class,
		'Redirect'          => Illuminate\Support\Facades\Redirect::class,
		'Redis'             => Illuminate\Support\Facades\Redis::class,
		'Request'           => Illuminate\Support\Facades\Request::class,
		'Response'          => Illuminate\Support\Facades\Response::class,
		'Route'             => Illuminate\Support\Facades\Route::class,
		'Schema'            => Illuminate\Support\Facades\Schema::class,
		'Seeder'            => Illuminate\Database\Seeder::class,
		'Session'           => Illuminate\Support\Facades\Session::class,
		'SoftDeletingTrait' => Illuminate\Database\Eloquent\SoftDeletingTrait::class,
		'SSH'               => Illuminate\Support\Facades\SSH::class,
		'Str'               => Illuminate\Support\Str::class,
		'URL'               => Illuminate\Support\Facades\URL::class,
		'Validator'         => Illuminate\Support\Facades\Validator::class,
		'View'              => Illuminate\Support\Facades\View::class,
		'Agent'             => Jenssegers\Agent\Facades\Agent::class,
		'Debugbar'          => Barryvdh\Debugbar\Facade::class,
		'Image'             => Intervention\Image\Facades\Image::class,
	),
);
