# 果酱社区通用包

适用于 Laravel 项目的通用包，目前广泛引用果酱社区的所有开源与商业项目，

## 安装

```
$ composer require ibrand/common:~1.0 -vvv
$ php artisan vendor:publish --provider="iBrand\DatabaseLogger\ServiceProvider" 
```

## 使用


### 微信

基于 overtrue/wechat 适配 Laravel，同时又支持多项目配置，使用方法与 overtrue/wechat 基本一致。

在果酱社区的项目中，经常会配置多个微信公众号或者小程序，在这种场景下需要用到多项目配置的方式。


#### 创建实例

- 代码中直接声明配置
```
use iBrand\Common\Wechat\Factory;

$config = [
    'app_id' => 'wx3cf0f39249eb0exx',
    'secret' => 'f1c242f4f28f735d4687abb469072axx',

    // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
    'response_type' => 'array',

    //...
];

$app = Factory::officialAccount($config);
```

- 基于 config/ibrand/wechat.php  config 文件
```
use iBrand\Common\Wechat\Factory;

$app = Factory::officialAccount(); //use default
$app = Factory::officialAccount('ec'); //use ec project config
```

#### 使用

具体参加 overtrue/wechat 官方文档： https://www.easywechat.com/docs

#### 获取微信 js config

待完成


### 第三方平台

目前在微信的体系中，经常会涉及到第三方平台，比如：

- 公众号授权第三方平台提供服务。
- 小程序托管发布。果酱团队虽然不怎么接外包，但是也有不少客户，那么通过授权后统一托管发布很更简单一点。

果酱也提供了官方的第三方平台源码：[laravel-wechat-platform](https://github.com/guojiangclub/laravel-wechat-platform)


### 帮助函数

`helpers.php` 文件里是目前常用的一些辅助函数，后续会陆续增加。这里只简单罗列下清单：

- `platform_application()` :   实例化第三方平台应用对象。
- `is_mobile` : 手机判断。
- `is_mail`：邮箱判断。
- `is_username`：用户名判断。
- `get_wechat_config`：获取微信配置信息
- `collect_to_array`：把 Laravel 的 collection 集合转化成数组，常用语 json 数据返回前转化一下。

### API Resource 封装

这个模块主要核心实现如下功能：

- 兼容 Dingo/api ，因为历史原因，在返回前端数据上，需要和 dingo/api 保持一致。在果酱的所有系列产品中，无论是 dingo/api 还是 API Resource 返回的数据结构一定是一致的。
- 实现了 API Resource 返回数据时隐藏字段功能，在 Model 中通过 `$withoutFields` 字段指定即可。
- `iBrand\Common\Controllers\Controller` 封装常见的 API 返回方法。
