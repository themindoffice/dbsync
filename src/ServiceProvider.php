<?php

namespace TheMindOffice\DBSync;

use Illuminate\Support\ServiceProvider as SP;

use TheMindOffice\DBSync\Commands\Pull;
use TheMindOffice\DBSync\Commands\Push;

class ServiceProvider extends SP
{
    protected $commands = [
        Pull::class,
        Push::class
    ];

    public static function install()
    {
        \Artisan::call('vendor:publish', ['--provider' => self::class, '--tag' => 'config']);
        \File::append(base_path('.gitignore'), '/config/dbsync.php');
    }

    public function register(){

    }

    public function boot()
    {
        $this->commands($this->commands);

        $this->publishes([
            __DIR__ . '/Config/dbsync.php' => config_path('dbsync.php'),
        ], 'config');
    }
}
