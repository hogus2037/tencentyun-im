<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\GroupClient;
use Hogus\Tencent\Tim\Clients\OpenimClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OpenImServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['openim'] = function ($app) {
            return new OpenimClient($app);
        };
    }
}
