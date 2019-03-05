<?php 
namespace App\Modules;
 
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $modules = config("module.modules");

        while (list(,$module) = @each($modules)) {

            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                $a = "\a";
                $nama_modul = str_replace("a","",$a);
                $nama_modul .= $module;
                include __DIR__.'/'.$module.'/routes.php';
            }
         
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }
    }

    public function register() {}

}