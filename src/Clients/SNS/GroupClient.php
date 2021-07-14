<?php


namespace Hogus\Tencent\Tim\Clients\SNS;


use Hogus\Tencent\Tim\Clients\BaseClient;
use Hogus\Tencent\Tim\Pagination\FriendGroupPaginator;
use Hogus\Tencent\Tim\Pagination\Paginator;

class GroupClient extends BaseClient
{
    public function get(array $data)
    {
        return $this->httpPostJson('sns/group_get', $data);
    }

    public function add($from, $group_name, $to = null)
    {
        $data = [
            'From_Account' => (string)$from,
            'GroupName' => (array)$group_name,
        ];

        if ($to) {
            $data['To_Account'] = (array)$to;
        }

        return $this->httpPostJson('sns/group_add', $data);
    }

    public function delete($from, $group_name)
    {
        $data = [
            'From_Account' => (string)$from,
            'GroupName' => (array)$group_name,
        ];

        return $this->httpPostJson('sns/group_delete', $data);
    }

    public function paginator(): Paginator
    {
        return new FriendGroupPaginator($this);
    }
}
