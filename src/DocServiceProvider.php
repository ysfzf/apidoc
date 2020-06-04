<?php
namespace Ycpfzf\Apidoc;

use Illuminate\Support\ServiceProvider;

class DocServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(['Apidoc\\InstallCommand']);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $path=config('doc.directory');
        $this->loadRoutesFrom(base_path().'/routes/doc.php');
    }


}
