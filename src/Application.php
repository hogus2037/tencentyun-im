<?php


namespace Hogus\Tencent\Tim;


use Hogus\Tencent\Tim\Clients\AccountClient;
use Hogus\Tencent\Tim\Clients\GroupClient;
use Hogus\Tencent\Tim\Clients\GroupMemberClient;
use Hogus\Tencent\Tim\Clients\OpenimClient;
use Hogus\Tencent\Tim\Providers\AccountServiceProvider;
use Hogus\Tencent\Tim\Providers\GroupMemberServiceProvider;
use Hogus\Tencent\Tim\Providers\GroupServiceProvider;
use Hogus\Tencent\Tim\Providers\UserSigServiceProvider;

/**
 * Class Application
 *
 * @package Hogus\Tencent\Tim
 *
 * @property AccountClient $account
 * @property GroupClient $group
 * @property GroupMemberClient $group_member
 * @property OpenimClient $openim
 */
class Application extends ServiceContainer
{
    protected $providers = [
        UserSigServiceProvider::class,
        AccountServiceProvider::class,
        GroupServiceProvider::class,
        GroupMemberServiceProvider::class,
    ];
}
