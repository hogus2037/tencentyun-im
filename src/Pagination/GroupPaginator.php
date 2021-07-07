<?php


namespace Hogus\Tencent\Tim\Pagination;


class GroupPaginator extends Paginator
{
    /** @var string 群组形态 */
    protected $type;

    public function whereType($type)
    {
        $this->type = $type;
    }

    public function get($columns = [])
    {
        if (count($this->wheres) > 0) {
            $this->dynamicWhere();
        }

        return $this->client->get($this->runSelect());
    }

    protected function runSelect(): array
    {
        $select = [];

        $select['Limit'] = $this->limit;
        $select['Next'] = $this->offset;

        if ($this->type) {
            $select['GroupType'] = $this->type;
        }

        return $select;
    }
}
