<?php


namespace Hogus\Tencent\Tim\Pagination;


use Hogus\Tencent\Tim\Supports\Filter;
use Illuminate\Support\Arr;

class JoinGroupPaginator extends GroupPaginator
{
    protected $member;

    protected $with = [
        'live' => 0, // 直播群
        'work' => 0, // 工作群
    ];

    /**
     * with
     *
     * @param mixed $withs
     */
    public function with($withs): JoinGroupPaginator
    {
        $reloads = is_string($withs) ? func_get_args() : $withs;

        foreach ($reloads as $reload) {
            if (Arr::exists($this->with, $reload)) {
                $this->with[$reload] = 1;
            }
        }

        return $this;
    }

    public function get($columns = [])
    {
        if (count($this->wheres)) {
            $this->dynamicWhere();
        }

        $data = [
            'Member_Account' => (string)$this->member,
            'Limit' => $this->limit,
            'Offset' => $this->offset,
            'WithHugeGroups' => $this->with['live'],
            'WithNoActiveGroups' => $this->with['work'],
        ];

        if ($this->type) {
            $data['GroupType'] = $this->type;
        }

        $data['ResponseFilter'] = new Filter();

        return $this->client->get_joined_group_list($data);
    }
}
