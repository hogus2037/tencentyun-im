<?php


namespace Hogus\Tencent\Tim\Providers;


use Hogus\Tencent\Tim\Clients\GroupMemberClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GroupMemberServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['group_member'] = function ($app) {
            return new GroupMemberClient($app);
        };
    }
}
