<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\GroupClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GroupServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['group'] = function ($app) {
            return new GroupClient($app);
        };
    }
}
