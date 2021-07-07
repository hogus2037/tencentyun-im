<?php


namespace Hogus\Tencent\Tim\Messages;


class Multi extends Message
{

    protected $properties = ['items'];

    public function __construct(array $items)
    {
        parent::__construct(compact('items'));
    }

    public function transformForJsonRequest(): array
    {
        return array_map(function ($item) {
            if ($item instanceof Message) {
                return $item->transformForJsonRequest();
            }

        }, $this->get('items'));
    }
}
