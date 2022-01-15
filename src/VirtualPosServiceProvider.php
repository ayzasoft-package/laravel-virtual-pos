<?php
namespace Ibrahimcadirci\VirtualPos;

use Illuminate\Support\ServiceProvider;

class VirtualPosServiceProvider extends ServiceProvider {
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/virtualpos.php' => config_path('virtualpos.php')
        ], 'courier-config'); 
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/virtualpos'),
        ], 'public');
        $this->loadRoutesFrom(__DIR__.'/../routes/virtualpos.php');

    }

    public function register(){
        
    }
}