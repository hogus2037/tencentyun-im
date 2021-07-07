<?php


namespace Hogus\Tencent\Tim\Messages;


class Text extends Message
{
    protected $type = 'TIMTextElem';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['text'];

    protected $aliases = [
        'Text' => 'text'
    ];

    public function __construct(string $text = '')
    {
        parent::__construct(compact('text'));
    }
}
