<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\AccountClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccountServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['account'] = function ($app) {
            return new AccountClient($app);
        };
    }
}
