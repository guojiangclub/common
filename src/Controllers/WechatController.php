<?php

namespace iBrand\Common\Controllers;

use iBrand\Common\Wechat\Factory;

class WechatController extends Controller
{
    public function getJsConfig()
    {
        //1. get app name,such as ec, activity etc.
        $app = request('app') ?? 'default';

        if (config('ibrand.platform.enabled_jssdk')) {
            return platform_application()->getJsConfig(request('url'), config('ibrand.wechat.official_account.' . $app . '.app_id'));
        }

        if (!config('ibrand.wechat.official_account.' . $app . '.app_id') OR !config('ibrand.wechat.official_account.' . $app . '.secret')) {
            return $this->failed('please set wechat account.');
        }

        $options = [
            'app_id' => config('ibrand.wechat.official_account.' . $app . '.app_id'),
            'secret' => config('ibrand.wechat.official_account.' . $app . '.secret'),
        ];

        $app = Factory::officialAccount($options);;
        
        $js = $app->jssdk;

        $js->setUrl(urldecode(request('url')));

        return $js->buildConfig([]);
    }
}