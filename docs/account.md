# 账号管理

## 导入账号

```
$tim->account->import($userid, $nickname, $avatar);
```

## 查询账号

```
$tim->account->check($userid);
```

## 查询帐号在线状态

```
$tim->account->querystate($member_id, int $is_need_detail = 0);
```

## 失效帐号登录状态

```
$tim->account->kick($member_id);
```

## 获取用户签名

```
$tim->account->login($userid, int $expire = 86400*180);
```
