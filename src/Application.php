<?php


namespace Hogus\Tencent\Tim;


use Hogus\Tencent\Tim\Providers\AccountServiceProvider;
use Hogus\Tencent\Tim\Providers\FriendServiceProvider;
use Hogus\Tencent\Tim\Providers\GroupMemberServiceProvider;
use Hogus\Tencent\Tim\Providers\GroupServiceProvider;
use Hogus\Tencent\Tim\Providers\OpenImServiceProvider;
use Hogus\Tencent\Tim\Providers\ProfileServiceProvider;
use Hogus\Tencent\Tim\Providers\UserSigServiceProvider;

/**
 * Class Application
 *
 * @package Hogus\Tencent\Tim
 *
 * @property \Hogus\Tencent\Tim\Clients\AccountClient $account
 * @property \Hogus\Tencent\Tim\Clients\GroupClient $group
 * @property \Hogus\Tencent\Tim\Clients\GroupMemberClient $group_member
 * @property \Hogus\Tencent\Tim\Clients\OpenimClient $openim
 * @property \Hogus\Tencent\Tim\Clients\ProfileClient $profile
 * @property \Hogus\Tencent\Tim\Clients\SNS\FriendClient $friend
 * @property \Hogus\Tencent\Tim\Clients\SNS\BlackClient $black
 * @property \Hogus\Tencent\Tim\Clients\SNS\GroupClient $friend_group
 */
class Application extends ServiceContainer
{
    protected $providers = [
        UserSigServiceProvider::class,
        AccountServiceProvider::class,
        GroupServiceProvider::class,
        GroupMemberServiceProvider::class,
        OpenImServiceProvider::class,
        ProfileServiceProvider::class,
        FriendServiceProvider::class,
    ];
}
