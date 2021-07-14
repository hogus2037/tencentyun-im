<?php


namespace Hogus\Tencent\Tim\Formats\Friend;


class FriendUpdateItem extends FriendItem
{
    protected $aliases = [
        'To_Account' => 'to',
        'SnsItem' => 'item',
    ];

    protected $required = [
        'to', 'item'
    ];
}
