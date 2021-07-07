<?php


namespace Hogus\Tencent\Tim\Messages;


use Hogus\Tencent\Tim\Supports\HasAttributes;

class Message
{
    use HasAttributes;

    protected $properties = [];

    protected $aliases = [];

    /**
     * @var string
     */
    protected $type;

    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Return type name message.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Magic getter.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return $this->getAttribute($property);
    }

    /**
     * @return array
     */
    public function transformForJsonRequest(): array
    {
        $messageType = $this->getType();

        return [
            'MsgType' => $messageType,
            'MsgContent' => $this->propertiesToArray([], $this->aliases)
        ];
    }

    /**
     * propertiesToArray
     *
     * @param array $data
     * @param array $aliases
     *
     * @return array
     */
    protected function propertiesToArray(array $data, array $aliases  = []): array
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
