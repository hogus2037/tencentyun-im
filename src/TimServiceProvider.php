<?php


namespace Hogus\Tencent\Tim;


use Illuminate\Support\ServiceProvider;

class TimServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();

        $this->app->singleton('tim', function ($app) {
            return new Application($app->config->get('tim'));
        });

        $this->app->alias('tim', Application::class);
    }

    protected function registerConfig()
    {
        $configPath = __DIR__ .'/config.php';

        $this->publishes([$configPath => config_path('tim.php')], 'config');

        $this->mergeConfigFrom($configPath, 'tim');
    }
}
