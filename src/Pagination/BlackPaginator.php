<?php


namespace Hogus\Tencent\Tim\Pagination;


class BlackPaginator extends Paginator
{
    protected $from;

    protected $seq = 0;

    public function whereFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function whereSeq($seq)
    {
        $this->seq = $seq;

        return $this;
    }

    public function seq(int $seq)
    {
        $this->seq = $seq;

        return $this;
    }

    public function get($columns = [])
    {
        return $this->client->get($this->runSelect());
    }

    protected function runSelect()
    {
        $select = [];

        if (count($this->wheres) > 0) {
            $this->dynamicWhere();
        }

        $select['From_Account'] = $this->from;

        $select['StartIndex'] = $this->offset;
        $select['MaxLimited'] = $this->limit;

        $select['LastSequence'] = $this->seq;

        return $select;
    }
}
