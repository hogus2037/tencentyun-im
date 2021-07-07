<?php


namespace Hogus\Tencent\Tim\Messages;


class Custom extends Message
{
    protected $type = "TIMCustomElem";

    protected $properties = [
        'data', 'desc', 'ext', 'sound'
    ];

    protected $aliases = [
        'Data' => 'data',
        'Desc' => 'desc',
        'Ext' => 'ext',
        'Sound' => 'sound',
    ];
}
