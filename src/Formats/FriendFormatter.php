<?php


namespace Hogus\Tencent\Tim\Formats;


use Hogus\Tencent\Tim\Formats\Friend\FriendAddItem;
use Hogus\Tencent\Tim\Formats\Friend\FriendItem;
use Hogus\Tencent\Tim\Formats\Friend\FriendUpdateItem;
use Illuminate\Support\Str;

class FriendFormatter extends Formatter
{
    /** @var array */
    protected $items = [];

    protected $aliases = [
        'From_Account' => 'from',
        'To_Account' => 'to',
        'AddType' => 'add_type',
        'DeleteType' => 'delete_type',
        'CheckType' => 'check_type',
        'ForceAddFlags' => 'add_flags',
        'AddFriendItem' => 'add_item',
        'UpdateItem' => 'update_item',
        'TagList' => 'tags',
    ];

    protected $required = [
        'from'
    ];

    public function from($account): FriendFormatter
    {
        $this->set('from', (string)$account);

        return $this;
    }

    public function to($to): FriendFormatter
    {
        $this->set('to', (array)$to);

        return $this;
    }

    public function type(string $key, string $value): FriendFormatter
    {
        $this->set($key, $this->formatType($key, $value));

        return $this;
    }

    public function flag(int $flag): FriendFormatter
    {
        $this->set('add_flags', $flag);

        return $this;
    }

    protected function formatType($key, $value): string
    {
        if (Str::startsWith($value, $key)) {
            return Str::title($value);
        }

        if (Str::startsWith($value, ['single', 'both'])) {
            if (Str::startsWith($key, ['check', 'check_type'])) {
                return "CheckResult_Type_".ucfirst($value);
            }

            return Str::title($key.'_'.$value);
        }

        return $value;
    }

    public function add_type($type): FriendFormatter
    {
        return $this->type('add_type', $type);
    }

    public function check_type($type): FriendFormatter
    {
        return $this->type('check_type', $type);
    }

    public function delete_type($type): FriendFormatter
    {
        return $this->type('delete_type', $type);
    }

    public function tags($tags)
    {
        $this->set('tags', (array)$tags);

        return $this;
    }

    public function item(array $attributes = []): FriendItem
    {
        return new FriendItem($this->client, $attributes);
    }

    public function addItem(array $attributes = []): FriendItem
    {
        return new FriendAddItem($this->client, $attributes);
    }

    public function updateItem(array $attributes = []): FriendItem
    {
        return new FriendUpdateItem($this->client, $attributes);
    }

    public function setItem($item): FriendFormatter
    {
        $this->items[] = $item instanceof FriendItem ? $item->transformForJsonRequest() : $item;

        return $this;
    }

    public function items(array $items): FriendFormatter
    {
        foreach ($items as $item) {
            $this->setItem($item);
        }

        return $this;
    }

    protected function addRequired($keys)
    {
        $keys = (array)$keys;

        foreach ($keys as $key) {
            array_push($this->required, $key);
        }

        return $this;
    }

    public function add()
    {
        $this->set('add_item', $this->items);

        $this->addRequired(['add_item']);

        return $this->client->add($this->transformForJsonRequest());
    }

    public function import()
    {
        $this->set('add_item', $this->items);

        $this->addRequired(['add_item']);

        return $this->client->import($this->transformForJsonRequest());
    }

    public function update()
    {
        $this->set('update_item', $this->items);

        $this->addRequired(['update_item']);

        return $this->client->update($this->transformForJsonRequest());
    }

    public function delete()
    {
        $this->addRequired(['to']);

        return $this->client->delete($this->transformForJsonRequest());
    }

    public function delete_all()
    {
        return $this->client->delete_all($this->transformForJsonRequest());
    }

    public function check()
    {
        $this->addRequired(['to']);

        return $this->client->check($this->transformForJsonRequest());
    }

    public function find()
    {
        $this->addRequired(['to', 'tags']);

        $ids = func_get_args();

        if (!empty($ids)) {
            $this->to($ids);
        }

        return $this->client->find($this->transformForJsonRequest());
    }
}
