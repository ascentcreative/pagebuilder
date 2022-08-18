<?php

namespace AscentCreative\PageBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

class PageBuilderServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(
        __DIR__.'/../config/pagebuilder.php', 'pagebuilder'
    );

     // Register the helpers php file which includes convenience functions:
     require_once (__DIR__.'/../helpers/pagebuilder-helpers.php');

  }

  public function boot()
  {

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'pagebuilder');

    $this->loadRoutesFrom(__DIR__.'/../routes/pagebuilder-web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $this->bootComponents();

    $this->bootPublishes();

    
  }

  

  // register the components
  public function bootComponents() {

        Blade::component('pagebuilder', 'AscentCreative\PageBuilder\Components\PageBuilder');

        Blade::component('pagebuilder-row', 'AscentCreative\PageBuilder\Components\Row');
        Blade::component('pagebuilder-container', 'AscentCreative\PageBuilder\Components\Container');
        Blade::component('pagebuilder-block', 'AscentCreative\PageBuilder\Components\Block');

  }




  

    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/../assets' => public_path('vendor/ascent/pagebuilder'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/config/pagebuilder.php' => config_path('pagebuilder.php'),
      ]);

    }



}