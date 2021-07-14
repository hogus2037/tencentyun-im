<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\ProfileClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ProfileServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['profile'] = function ($app) {
            return new ProfileClient($app);
        };
    }
}
