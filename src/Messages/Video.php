<?php


namespace Hogus\Tencent\Tim\Messages;


class Video extends Message
{
    protected $type = 'TIMVideoFileElem';

    protected $properties = [
        'url',
        'size',
        'second',
        'format',
        'thumb_url',
        'thumb_size',
        'thumb_height',
        'thumb_width',
        'thumb_format',
    ];

    protected $aliases = [
        'VideoUrl' => 'url',
        'VideoSize' => 'size',
        'VideoSecond' => 'second',
        'VideoFormat' => 'format',
        'VideoDownloadFlag' => 'flag',
        'ThumbUrl' => 'thumb_url',
        'ThumbSize' => 'thumb_size',
        'ThumbWidth' => 'thumb_width',
        'ThumbHeight' => 'thumb_height',
        'ThumbFormat' => 'thumb_format',
        'ThumbDownloadFlag' => 'thumb_flag',
    ];

    protected $required = [
        'url',
        'size',
        'second',
        'format',
        'thumb_url',
        'thumb_size',
        'thumb_height',
        'thumb_width',
        'thumb_format',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge(['flag' => 2, 'thumb_flag' => 2], $attributes));
    }
}
