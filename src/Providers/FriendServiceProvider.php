<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\SNS\BlackClient;
use Hogus\Tencent\Tim\Clients\SNS\FriendClient;
use Hogus\Tencent\Tim\Clients\SNS\GroupClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class FriendServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['friend'] = function ($app) {
            return new FriendClient($app);
        };

        $app['black'] = function ($app) {
            return new BlackClient($app);
        };

        $app['friend_group'] = function ($app) {
            return new GroupClient($app);
        };
    }
}
