<?php
namespace Ycpfzf\Apidoc;

use Illuminate\Support\ServiceProvider;

class DocServiceProvider extends ServiceProvider
{

    public function register()
    {
       //
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'doc');
        $this->loadRoutesFrom(__DIR__.'/route.php');
        $this->publishes([
            __DIR__.'/../config/doc.php' => config_path('doc.php'),
            __DIR__.'/../resources/assets' => base_path('public/apidoc/assets'),
        ]);
    }


}
