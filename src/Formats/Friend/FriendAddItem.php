<?php


namespace Hogus\Tencent\Tim\Formats\Friend;


class FriendAddItem extends FriendItem
{
    protected $aliases = [
        'To_Account' => 'to',
        'AddSource' => 'source',
        'Remark' => 'remark',
        'RemarkTime' => 'remark_time',
        'GroupName' => 'group_name',
        'AddWording' => 'wording',
        'AddTime' => 'add_time',
        'CustomItem' => 'item',
    ];

    protected $required = [
        'to', 'source'
    ];

    public function source(string $source)
    {
        $this->set('source', $source);

        return $this;
    }

    public function wording(string $wording)
    {
        $this->set('wording', $wording);

        return $this;
    }

    public function remark(string $remark)
    {
        $this->set('remark', $remark);

        return $this;
    }

    public function remark_time($time = null)
    {
        $this->set('remark_time', $time ?? time());

        return $this;
    }

    public function add_time($time = null)
    {
        $this->set('add_time', $time ?? time());

        return $this;
    }

    public function group($group)
    {
        $this->set('group_name', (array)$group);

        return $this;
    }
}
