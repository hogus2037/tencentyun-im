<?php


namespace Hogus\Tencent\Tim\Pagination;


use Hogus\Tencent\Tim\Clients\BaseClient;
use Illuminate\Support\Str;

abstract class Paginator
{
    protected $limit = 15;

    protected $offset;

    protected $wheres = [];

    protected $client;

    public function __construct(BaseClient $client)
    {
        $this->client = $client;
    }

    public function forPage($page, $limit = 15)
    {
        return $this->offset(($page - 1) * $limit)->limit($limit);
    }

    public function offset($value)
    {
        $this->offset = max(0, $value);

        return $this;
    }

    public function limit($value)
    {
        $this->limit = $value;

        return $this;
    }

    public function where($key, $value)
    {
        $this->wheres[] = compact('key', 'value');

        return $this;
    }

    public function paginate($page = 1, $columns = [], $limit = null)
    {
        $limit = $limit ?? $this->limit;

        return $this->forPage($page, $limit)->get($columns);
    }

    protected function dynamicWhere()
    {
        foreach ($this->wheres as $where) {
            $property = $where['key'];

            $parameters = $where['value'];

            $this->addDynamic($property, $parameters);
        }

        return $this;
    }

    protected function addDynamic($property, $parameters)
    {
        $method = "where".Str::studly($property);

        if (method_exists($this, $method)) {
            return $this->$method($parameters);
        }

        if (property_exists($this, $property)) {
            return $this->$property = $parameters;
        }
    }

    abstract public function get($columns = []);
}
