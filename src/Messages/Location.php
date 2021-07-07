<?php


namespace Hogus\Tencent\Tim\Messages;


class Location extends Message
{
    protected $type = "TIMLocationElem";

    protected $properties = [
        'desc', 'Latitude', 'Longitude'
    ];

    protected $aliases = [
        'Desc' => 'desc',
        'Latitude' => 'latitude',
        'Longitude' => 'longitude',
    ];
}
