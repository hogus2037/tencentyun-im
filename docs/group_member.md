# 群组会员管理

```php
$group_member = $tim->group_member;
```

## 获取群成员详细资料

- 基础方法
```php
$group_member->get($data);
```

-  `paginator`方法
```php
$paginator = $group_member->paginator();

$paginator->where('role', 'Admin'); // or ->whereRole('Admin')
$paginator->where('group_id', 'id'); // or ->whereGroupId('id')
//$paginator->where('filter', []);
//$paginator->where('define', []);

$paginator->paginate();
// or
$paginator->forPage('offset', 'limit')->get();
```

## 添加群成员

```php
$group_member->add($group_id, $member_ids, $silence);
```

## 删除群成员

```php
$group_member->destroy($group_id, $member_ids, $silence, $reason = null);
```

## 导入
```php
$group_member->import($group_id, array $member_list);
```

## 修改资料

- 基础
```php
$group_member->update($group_id, $member_id, array $attributes);
```

- 修改某项资料
```php
// 角色
$group_member->update_role($group_id, $member_id, $role);
// 设置成员消息屏蔽位
$group_member->update_flag($group_id, $member_id, $flag);
// 群名片
$group_member->update_name_card($group_id, $member_id, $name_card);
// 设置群成员禁言时间
$group_member->update_shut_up($group_id, $member_id, $shut_up_time = 0);
```
