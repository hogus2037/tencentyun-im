<?php


namespace Hogus\Tencent\Tim\Formats\Friend;


use Hogus\Tencent\Tim\Formats\Formatter;

class FriendItem extends Formatter
{
    protected $items = [];

    public function to($account)
    {
        $this->set('to', (string)$account);

        return $this;
    }

    public function custom(array $custom, $key = 'item')
    {
        $this->set($key, $custom);

        return $this;
    }

    public function setCustom($tag, $value, $key = 'item')
    {
        $item = $this->get($key, []);

        array_push($item, [
            'Tag' => $tag,
            'Value' => $value
        ]);

        $this->custom($item, $key);

        return $this;
    }
}
