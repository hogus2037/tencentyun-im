<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Supports\UserSig;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class UserSigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['user_sig'] = function ($app) {
            return new UserSig($app);
        };
    }
}
