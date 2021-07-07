<?php


namespace Hogus\Tencent\Tim\Formats;


use Hogus\Tencent\Tim\Clients\GroupClient;
use Hogus\Tencent\Tim\Supports\HasAttributes;

class Formatter
{
    use HasAttributes;

    protected $aliases = [];

    protected $client;

    public function __construct(GroupClient $client, array $attributes = [])
    {
        $this->client = $client;

        $this->setAttributes($attributes);
    }

    public function transformForJsonRequest(): array
    {
        return $this->propertiesToArray([], $this->aliases);
    }

    protected function propertiesToArray(array $data = [], array $aliases  = []): array
    {
        $this->checkRequiredAttributes();

        foreach ($this->attributes as $property => $value) {
            if (is_null($value) && !$this->isRequired($property)) {
                continue;
            }

            $alias = array_search($property, $aliases, true);

            $data[$alias ?: $property] = $this->get($property);
        }

        return $data;
    }
}
