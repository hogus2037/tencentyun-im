<?php


namespace Hogus\Tencent\Tim\Messages;


class Face extends Message
{
    protected $type = "TIMFaceElem";

    protected $properties = [
        'index', 'data'
    ];

    protected $aliases = [
        'Index' => 'index',
        'Data' => 'data'
    ];

    protected $required = [
        'index', 'data'
    ];
}
