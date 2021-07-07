<?php


namespace Hogus\Tencent\Tim\Messages;


class Voice extends Message
{
    protected $type = "TIMSoundElem";

    protected $properties = [
        'url',
        'size',
        'second',
        'flag'
    ];

    protected $aliases = [
        'Url' => 'url',
        'Size' => 'size',
        'Second' => 'second',
        'Download_Flag' => 'flag',
    ];

    protected $required = [
        'url', 'size', 'second'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge(['flag' => 2], $attributes));
    }
}
