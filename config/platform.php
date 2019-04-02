<?php

return [

    'url' => env('WECHAT_API_URL', ''),

    'client_id' => env('WECHAT_API_CLIENT_ID', ''),

    'client_secret' => env('WECHAT_API_CLIENT_SECRET', ''),

    /*
     * 是否通过第三方平台调用JSSDK
     */
    'enabled_jssdk' => false
];