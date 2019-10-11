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


### 微信第三方平台

待完成


