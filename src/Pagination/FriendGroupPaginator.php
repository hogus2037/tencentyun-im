<?php


namespace Hogus\Tencent\Tim\Pagination;


class FriendGroupPaginator extends Paginator
{
    protected $from;

    protected $seq = 0;

    protected $need_friend = false;

    protected $group_name = [];

    public function get($columns = [])
    {
        if (count($this->wheres) > 0) {
            $this->dynamicWhere();
        }

        $data = [
            'From_Account' => (string)$this->from,
            'LastSequence' => $this->seq,
            'GroupName' => $this->group_name,
        ];

        if ($this->need_friend) {
            $data['NeedFriend'] = 'Need_Friend_Type_Yes';
        }

        return $this->client->get($data);
    }
}
