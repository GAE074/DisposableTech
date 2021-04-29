<?php

namespace Modules\DisposableTech\Providers;

use App\Services\ModuleService;
use Illuminate\Support\ServiceProvider;
use Route;

class TechServiceProvider extends ServiceProvider
{
  protected $moduleSvc;

  /** Boot the application events */
  public function boot()
  {
    $this->moduleSvc = app(ModuleService::class);

    $this->registerRoutes();
    $this->registerTranslations();
    $this->registerConfig();
    $this->registerViews();
    $this->registerLinks();

    $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
  }

  /** Register The Service Provider **/
  public function register() { }

  /** Register Module Links **/
  public function registerLinks()
  {
    $this->moduleSvc->addAdminLink('Disposable Tech', '/admin/disposabletech');
  }

  /** Register Routes **/
  protected function registerRoutes()
  {
    /** Frontend Routes **/
    Route::group([
        'as'     => 'DisposableTech.',
        'prefix' => '',
        'middleware' => ['web'],
        'namespace'  => 'Modules\DisposableTech\Http\Controllers',
    ], function () {
      Route::group([
        'middleware' => ['auth'],
      ], function () {
        // Main Controller Routes - None Needed For Tech Module
      });
    });

    /** Admin Routes **/
    Route::group([
        'as'     => 'DisposableTech.',
        'prefix' => 'admin',
        'middleware' => ['web', 'role:admin'],
        'namespace'  => 'Modules\DisposableTech\Http\Controllers',
    ], function () {
      Route::group([],
        function () {
        Route::get('disposabletech', 'TechAdminController@dtadmin')->name('techadmin');
        // Aircraft And Subfleet Specs Admin Routes
        Route::get('dtacspecs', 'TechSpecsController@dtspecs')->name('dtacspecs');
        Route::post('dtstorespecs', 'TechSpecsController@dtstorespecs')->name('dtstorespecs');
        Route::post('dtupdatespecs', 'TechSpecsController@dtupdatespecs')->name('dtupdatespecs');
        });
    });
  }

  protected function registerConfig()
  {
    $this->publishes([ __DIR__.'/../Config/config.php' => config_path('DisposableTech.php'),], 'config');
    $this->mergeConfigFrom( __DIR__.'/../Config/config.php', 'DisposableTech');
  }

  public function registerTranslations()
  {
    $langPath = resource_path('lang/modules/DisposableTech');

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, 'DisposableTech');
    } else {
      $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'DisposableTech');
    }
  }

  public function registerViews()
  {
    $viewPath = resource_path('views/modules/DisposableTech');
    $sourcePath = __DIR__.'/../Resources/views';

    $this->publishes([$sourcePath => $viewPath,], 'views');

    $this->loadViewsFrom(array_merge(array_map(function ($path) {
      return $path . '/modules/DisposableTech';
    }, \Config::get('view.paths')), [$sourcePath]), 'DisposableTech');
  }

  public function provides(): array { return []; }
}
