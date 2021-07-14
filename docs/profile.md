# 资料管理

## 拉取资料

```php
$tim->profile->get($userid, $tag);
```

## 设置资料

```php
$profiles = [
    'tag1' => 'value1'
];

// or
$profiles = [
    ['Tag' => 'tag1', 'Value' => 'value1'],
    ['Tag' => 'tag2', 'Value' => 'value2'],
];

$tim->profile->update($userid, $profiles);
```
