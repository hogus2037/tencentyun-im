# 关系链管理

## 添加好友

- 基础方法

```php
$tim->friend->add($data);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    //->add_type('single') // 单向
    ->add_type('both') // 双向 默认
    ->flag(1) // 管理员强制加好友标记：1表示强制加好友，0表示常规加好友方式
    ->items([
        $formatter->addItem([
            'to' => 'to2',
            'source' => 'source',
        ]),
        $formatter->addItem([
            'to' => 'to3',
            'source' => 'source',
            'remark' => 'remark',
            'wording' => 'wording',
            'group_name' => ['group_name1', 'group_name2'],
        ]),
    ])
    ->add();
```

## 导入好友

- 基础方法
```php
$tim->friend->import([
    'From_Account' => 'to1',
    'AddFriendItem' => [
        [
            'To_Account' => 'to2',
            'AddSource' => 'source',
        ],
        ...
    ]
]);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    //->add_type('single') // 单向
    //->add_type('both') // 双向 默认 导入不支持
    ->items([
        $formatter->addItem([
            'to' => 'to2',
            'source' => 'source',
        ])
        ->setCustom('tag1', 'value1'), //自定义好友数据
        $formatter->addItem([
            'to' => 'to3', // 好友的 UserID
            'source' => 'source', // 加好友来源字段
            'remark' => 'remark', // 备注
            'wording' => 'wording', // 附言信息
            'group_name' => ['group_name1', 'group_name2'], // 分组信息
            'add_time' => time(),
            'remark_time' => time(),
        ]),
    ])
    ->import();
```

## 更新好友

- 基础方法
```php
$tim->friend->update([
    'From_Account' => 'to1',
    'UpdateItem' => [
        [
            'To_Account' => 'to2',
            'SnsItem' => [
                [
                    'Tag' => 'Tag_SNS_IM_Remark',        
                    'Value' => 'remark1',        
                ]       
            ],
        ],
        ...
    ]
]);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    ->items([
        $formatter->updateItem()
        ->to('to2')
        ->setCustom('tag1', 'value1'), //自定义好友数据
    ])
    ->update();
```

## 删除好友

- 基础方法
```php
$tim->friend->delete([
    'From_Account' => 'to1',
    'To_Account' => ["id1","id2","id3"],
    'DeleteType' => 'Delete_Type_Both',
]);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    ->to(["id1","id2","id3"])
    //->delete_type('single') // 单向
    ->delete_type('both') // 双向
    ->delete();
```

## 删除所有好友

- 基础方法
```php
$tim->friend->delete_all($data);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    //->delete_type('single') // 单向 默认
    ->delete_type('both') // 双向
    ->delete_all();
```

## 检验好友

- 基础方法
```php
$tim->friend->check([
    'From_Account' => 'to1',
    'To_Account' => ["id1","id2","id3"],
    'CheckType' => 'CheckResult_Type_Both',
]);
```

- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    ->to(["id1","id2","id3"])
    //->check_type('single') // 单向
    ->check_type('both') // 双向
    ->check();
```

## 拉取指定好友

- 基础方法
```php
$tim->friend->find([
    'From_Account' => 'to1',
    'To_Account' => ["id1","id2","id3"],
    'TagList' => [],
]);
```
- formatter

```php
use Hogus\Tencent\Tim\Formats\FriendFormatter;

/** @var FriendFormatter $formatter*/
$formatter = $tim->friend->formatter();

$formatter->from('to1')
    ->to(["id1","id2","id3"])
    ->tags(['Tag_Profile_Custom_Test', 'Tag_Profile_IM_Image'])
    ->find();
```

## 拉取好友

```php
$tim->friend->get($from, $offset = 0, $standard = 0, $custom = 0);
```

## 添加黑名单
```php
$tim->black->add($from, $to);
```

## 删除黑名单
```php
$tim->black->delete($from, $to);
```

## 拉取黑名单
```php
$tim->black->get($data);

// or
$paginator = $tim->black->paginator();
// offset = StartIndex
// limit = MaxLimited
// seq = LastSequence 初始0
$paginator->where('from', 'to1')->where('seq', 0);

$paginator->offset(0)->limit(15)->get();
```

## 检验黑名单
```php
use Hogus\Tencent\Tim\Clients\SNS\BlackClient;

$tim->black->check($from, $to, BlackClient::BLACK_CHECK_TYPE_SINGLE); // 单向
$tim->black->check($from, $to, BlackClient::BLACK_CHECK_TYPE_BOTH); // 双向 默认
```

## 添加分组

```php
$tim->friend_group->add($from, $group_name, $to = null);
```

## 删除分组

```php
$tim->friend_group->delete($from, $group_name);
```

## 拉取分组

```php
$data = [
    'From_Account' => 'to1',
    'LastSequence' => 0,
    'GroupName' => [],
    'NeedFriend' => 'Need_Friend_Type_Yes'
];

$tim->friend_group->get($data);

// or
$paginator = $tim->friend_group->paginator();

$paginator->where('seq', 0)
->where('from', 'to1')
->where('group_name', ['name1', 'name2'])
->where('need_friend', true)
->get();
```
