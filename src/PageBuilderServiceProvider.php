<?php

namespace AscentCreative\PageBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

class PageBuilderServiceProvider extends ServiceProvider
{
  public function register()
  {
    //

    // Register the helpers php file which includes convenience functions:
    
    $this->mergeConfigFrom(
        __DIR__.'/../config/pagebuilder.php', 'pagebuilder'
    );

  }

  public function boot()
  {

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'donate');

    $this->loadRoutesFrom(__DIR__.'/../routes/pagebuilder-web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $this->bootComponents();

    $this->bootPublishes();

    
  }

  

  // register the components
  public function bootComponents() {


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