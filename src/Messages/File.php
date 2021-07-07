<?php


namespace Hogus\Tencent\Tim\Messages;


class File extends Message
{
    protected $type = "TIMFileElem";

    protected $properties = [
        'url', 'size', 'name'
    ];

    protected $aliases = [
        'Url' => 'url',
        'FileSize' => 'size',
        'FileName' => 'name',
        'Download_Flag' => 'flag',
    ];

    protected $required = [
        'url', 'size', 'name'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge(['flag' => 2], $attributes));
    }
}
