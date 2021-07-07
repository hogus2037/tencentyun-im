<?php


namespace Hogus\Tencent\Tim\Pagination;



class GroupMemberPaginator extends Paginator
{

    protected $group_id;

    protected $filter;

    protected $role;

    protected $define;

    public function whereRole($role)
    {
        $this->role = (array)$role;

        return $this;
    }

    public function whereGroupId($group_id)
    {
        $this->group_id = $group_id;

        return $this;
    }

    public function get($columns = [])
    {
        if (count($columns) > 0) {
            $this->filter = array_merge($this->filter, $columns);
        }

        return $this->client->get($this->runSelect());
    }

    protected function runSelect(): array
    {
        $select = [];

        if (count($this->wheres) > 0) {
            $this->dynamicWhere();
        }

        $select['Limit'] = $this->limit;
        $select['Offset'] = $this->offset;
        $select['GroupId'] = $this->group_id;

        if (count((array)$this->filter) > 0) {
            $select['MemberInfoFilter'] = (array)$this->filter;
        }

        if (count((array)$this->role) > 0) {
            $select['MemberRoleFilter'] = (array)$this->role;
        }

        if (count((array)$this->define) > 0) {
            $select['AppDefinedDataFilter_GroupMember'] = (array)$this->define;
        }

        return $select;
    }
}
