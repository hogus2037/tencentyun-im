# 群组管理

```php
$group = $tim->group;
```
## 获取 App 中的所有群组

- 基础方法
```php
$group->get($data = []);
```

-  `paginator`方法
```php
$paginator = $group->paginator();

$paginator->where('type', 'Public'); // or ->whereType('Public')

//$paginator->paginate(); // 所有群组不适用

$paginator->offest('next')->get();
```

## 获取群详细资料

```php
$group->find($group_id, $filter = null);
```

## 创建群组

- 基础方法
```php
$group->create($data);
```

- 使用`formatter`方式
```php
$formatter = $group->formatter([
    'introduction' => '群简介',
    'notification' => '群公告',
    'face_url' => '群头像',
    'max_member_num' => '最大群成员数量，缺省时的默认值：私有群是200，公开群是2000，聊天室是6000，音视频聊天室和在线成员广播大群无限制',
    'apply_join' => '申请加群处理方式。包含 FreeAccess（自由加入），NeedPermission（需要验证），DisableApply（禁止加群），不填默认为 NeedPermission（需要验证）仅当创建支持申请加群的 群组 时，该字段有效',
    'shut_up_all' => 'On', //群内群成员禁言，只有群管理员和群主以及系统管理员可以发言
]);

$formatter->type('Public'); // 群组类型,必填
$formatter->name('group1'); // 群名称,必填
//$formatter->owner('owner'); // 群主ID 可选，不传没有群主
//$formatter->group('1111'); // 自定义群组ID
//$formatter->setDefine('key', 'value'); // 设置群组自定义数据
//$formatter->faceUrl('url'); // 设置群组自定义数据
//$formatter->join('FreeAccess'); // 申请加群处理方式
//$formatter->shutUp('Off'); // 群内群成员禁言
//$formatter->disableShutUp(); // 关闭群内群成员禁言
//$formatter->enableShutUp(); // 开启群内群成员禁言

// 添加管理员
$member_formatter = $formatter->memberFormatter();

$member1 = $member_formatter->member('admin1')->role('Admin'); // 角色只能是管理员

$member2 = [
    "Member_Account" => 'admin2',
    'Role' => 'Admin', // 角色只能是管理员
];

$formatter->member($member1);
$formatter->member($member2);

$formatter->create();
```

- 快速创建群组
```php
$data = []; 
// or
// $data = $formatter;

$group->create_public_group($data); // 陌生人社交群
$group->create_work_group($data); // 好友工作群
$group->create_meeting_group($data); // 会议群
$group->create_live_group($data); // 直播群
```

## 修改群基础资料

- 基础方法
```php
$group->update($data);
$group->update_group($group_id, $data);
```

- 使用`formatter`方式
```php
$formatter = $group->formatter();

$formatter->type('Public'); // 群组类型,必填
$formatter->name('group1'); // 群名称,必填
$formatter->group('1111'); // 群组ID,必填

// 参考创建

$formatter->update(); // 调用基础方法
```

## 解散群组
```php
$group->destroy($group_id);
```

## 发送群公告
```php
$group->notification($group_id, string $content, array $member_id = []);
```

## 批量禁言和取消禁言
```php
$group->forbid($group_id, $member_id, int $shut_up_time)
```

## 获取直播群在线人数
```php
$group->get_online_member_num($group_id);
```

## [发送消息](message.md)
