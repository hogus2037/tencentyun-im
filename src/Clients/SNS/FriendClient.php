<?php


namespace Hogus\Tencent\Tim\Clients\SNS;


use Hogus\Tencent\Tim\Clients\BaseClient;
use Hogus\Tencent\Tim\Formats\Formatter;
use Hogus\Tencent\Tim\Formats\FormatterInterface;
use Hogus\Tencent\Tim\Formats\FriendFormatter;

class FriendClient extends BaseClient implements FormatterInterface
{
    // 拉取好友
    public function get($from, $offset = 0, $standard = 0, $custom = 0)
    {
        $data = [
            'From_Account' => (string)$from,
            'StartIndex' => $offset,
            'StandardSequence' => $standard,
            'CustomSequence' => $custom,
        ];

        return $this->httpPostJson('sns/friend_get', $data);
    }

    // 拉取指定好友
    public function find(array $data)
    {
        return $this->httpPostJson('sns/friend_get_list', $data);
    }

    public function add(array $data)
    {
        return $this->httpPostJson('sns/friend_add', $data);
    }

    public function import(array $data)
    {
        return $this->httpPostJson('sns/friend_import', $data);
    }

    public function delete(array $data)
    {
        return $this->httpPostJson('sns/friend_delete', $data);
    }

    public function delete_all(array $data)
    {
        return $this->httpPostJson('sns/friend_delete_all', $data);
    }

    public function update(array $data)
    {
        return $this->httpPostJson('sns/friend_update', $data);
    }

    public function check(array $data)
    {
        return $this->httpPostJson('sns/friend_check', $data);
    }

    public function formatter(array $attributes = []): Formatter
    {
        return new FriendFormatter($this, $attributes);
    }
}
