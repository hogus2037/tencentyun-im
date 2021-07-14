<h1 align="center"> tencentyun-tim </h1>

<p align="center"> .</p>


## Installing

```shell
$ composer require hogus/tencentyun-tim -vvv
```

## Usage

### Init

```php
/** @var \Hogus\Tencent\Tim\Application $tim */
$tim = app('tim');
```

### Docs

- [官方即时通信IM文档](https://cloud.tencent.com/document/product/269/1519)

- [x] [账号](docs/account.md)
    - [x] 导入单个账号
    - [x] 导入多个账号
    - [x] 删除账号
    - [x] 查询账号
    - [x] 失效账号登录态
    - [x] 查询账号在线状态
    - [x] 获取账号签名
- [x] [群组](docs/group.md)
    - [x] 获取 App 中的所有群组
    - [x] 创建群组
    - [x] 获取群详细资料
    - [x] 修改群基础资料
    - [x] 解散群组
    - [ ] 获取用户所加入的群组
    - [x] 批量禁言和取消禁言
    - [x] 获取被禁言群成员列表
    - [x] 在群组中发送普通消息
    - [x] 在群组中发送系统通知
    - [x] 撤回群消息
    - [x] 转让群主
    - [x] 导入群基础资料
    - [ ] 导入群消息
    - [x] 设置成员未读消息计数
    - [x] 删除指定用户发送的消息
    - [x] 拉取群历史消息
    - [x] 获取直播群在线人数
- [x] [群组会员](docs/group_member.md)
    - [x] 查询用户在群组中的身份
    - [x] 获取群成员详细资料
    - [x] 增加群成员
    - [x] 删除群成员
    - [x] 修改群成员资料
    - [x] 导入群成员
- [x] [消息](docs/message.md)
    - [x] 单发单聊消息
    - [x] 批量发单聊消息
- [x] [资料](docs/profile.md)
    - [x] 设置资料
    - [x] 拉取资料
- [x] [关系链](docs/sns.md)
    - [x] 添加好友
    - [x] 导入好友
    - [x] 更新好友
    - [x] 删除好友
    - [x] 删除所有好友
    - [x] 校验好友
    - [x] 拉取好友
    - [x] 拉取指定好友
    - [x] 添加黑名单
    - [x] 删除黑名单
    - [x] 拉取黑名单
    - [x] 校验黑名单
    - [x] 添加分组
    - [x] 删除分组
    - [x] 拉取分组

## Related

- [w7corp/easywechat](https://github.com/w7corp/easywechat)
- [tencentyum/imsdk_restapi-php-sdk](https://github.com/tencentyun/imsdk_restapi-php-sdk)


## License

MIT
