# 消息

## 消息类型

消息分为以下几种：`文本`、`图片`、`视频`、`文件`、`地理位置`、`语音`、`表情`、`自定义`、`组合消息`。

### 文本消息

属性列表

> - `text` 文本内容

```php
use Hogus\Tencent\Tim\Messages\Text;

$text = new Text('您好');
```

### 图片消息

属性列表

> - `uuid` 图片序列号。后台用于索引图片的键值
> - `format` 图片格式。JPG = 1，GIF = 2，PNG = 3，BMP = 4，其他 = 255
> - `attributes` 原图、缩略图或者大图下载信息

`attributes` 属性列表
> - `type` 图片类型： 1-原图，2-大图，3-缩略图
> - `size` 图片数据大小，单位：字节
> - `width` 图片宽度
> - `height` 图片高度
> - `url` 图片下载地址


```php
use Hogus\Tencent\Tim\Messages\Image;

$image = new Image($uuid, $format, $attributes);
```

### 视频消息

`attributes` 属性列表

> - `url` 视频下载地址
> - `size` 视频数据大小，单位：字节
> - `second` 视频时长，单位：秒
> - `format` 视频格式，例如 mp4
> - `thumb_url` 视频缩略图下载地址
> - `thumb_size` 缩略图大小，单位：字节
> - `thumb_height` 缩略图宽度
> - `thumb_width` 缩略图高度
> - `thumb_format` 缩略图格式

```php
use Hogus\Tencent\Tim\Messages\Video;

$video = new Video($attributes);
```

### 文件消息

属性列表
> - `url` 文件下载地址
> - `size` 文件数据大小，单位：字节
> - `name` 文件名称

```php
use Hogus\Tencent\Tim\Messages\File;

$file = new File($url, $size, $name);
```
### 地理位置消息

`attributes` 属性列表
> - `desc` 地理位置描述信息
> - `latitude` 纬度
> - `longitude` 经度

```php
use Hogus\Tencent\Tim\Messages\Location;

$location = new Location($attributes);
```

### 语音消息

`attributes` 属性列表

> - `url` 下载地址
> - `size` 数据大小，单位：字节
> - `second` 时长，单位：秒

```php
use Hogus\Tencent\Tim\Messages\Voice;

$voice = new Voice($attributes);
```

### 表情消息

`attributes` 属性列表

> - `index` 表情索引，用户自定义
> - `data` 额外数据

```php
use Hogus\Tencent\Tim\Messages\Face;

$face = new Face($attributes);

```
### 自定义消息

`attributes` 属性列表

> - `desc` 自定义消息描述信息。当接收方为 iOS 或 Android 后台在线时，做离线推送文本展示。
    若发送自定义消息的同时设置了 OfflinePushInfo.Desc 字段，此字段会被覆盖，请优先填 OfflinePushInfo.Desc 字段。
    当消息中只有一个 TIMCustomElem 自定义消息元素时，如果 Desc 字段和 OfflinePushInfo.Desc 字段都不填写，将收不到该条消息的离线推送，需要填写 OfflinePushInfo.Desc 字段才能收到该消息的离线推送。
> - `data` 自定义消息数据。 不作为 APNs 的 payload 字段下发，故从 payload 中无法获取 Data 字段
> - `ext` 扩展字段。当接收方为 iOS 系统且应用处在后台时，此字段作为 APNs 请求包 Payloads 中的 Ext 键值下发，Ext 的协议格式由业务方确定，APNs 只做透传
> - `sound` 自定义 APNs 推送铃音。

```php
use Hogus\Tencent\Tim\Messages\Custom;

$custom = new Custom($attributes);
```

### 组合消息

```php
use Hogus\Tencent\Tim\Messages\Text;
use Hogus\Tencent\Tim\Messages\Multi;
use Hogus\Tencent\Tim\Messages\Face;

$items = [
    new Text('hi'),
    new Face([
        'index' => '1',
        'data' => 'xiao',
    ]),
];

$custom = new Multi($items);
```

## 发送消息

### 发送群消息
```php
use Hogus\Tencent\Tim\Messages\Text;

$text = new Text('您好');

$tim->group->message($text)->from('from')->to('group_id')->send();

```

### 单聊消息
```php
use Hogus\Tencent\Tim\Messages\Text;

$text = new Text('您好');

$tim->opemim->message($text)->from('from')->to('to')->send(); // 单发单聊
$tim->opemim->message($text)->from('from')->to(['to1','to2'])->send(); // 批量发单聊

```
