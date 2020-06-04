<?php
namespace Apidoc;
use Illuminate\Console\Command;

class InstallCommand extends Command
{

    protected $signature = 'apidoc:install';
    protected $description = 'Install the apidoc package';
    protected $directory = '';
    protected $config;

    public function handle()
    {
        try{
            $this->createConfig();
            $this->createRoute();
            $this->createView();
        }catch (\Exception $exception){
            $this->line("<error>{$exception->getMessage()}</error>");
        }
    }

    protected function createRoute(){
        $source_file=realpath(__DIR__.'/../route/doc.php');
        $config_file=base_path().'/routes/doc.php';
        copy($source_file,$config_file);
    }

    protected function createView(){
        $source_path=realpath(__DIR__.'/../resources/');
        $dist_path=base_path().'/public/apidoc/';
        if(is_dir($dist_path)){
            $this->line("<error>{$dist_path}已经存在！</error>");
            return ;
        }
        mkdir($dist_path);
        copy($source_path,$dist_path);
    }

    protected function createConfig(){
        $source_file=realpath(__DIR__.'/../config/doc.php');
        $config_file=config_path().'/doc.php';
        copy($source_file,$config_file);
    }
}
