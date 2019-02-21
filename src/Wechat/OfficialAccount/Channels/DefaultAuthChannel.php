<?php

namespace iBrand\Common\Wechat\OfficialAccount\Channels;

use iBrand\Common\Wechat\Contracts\AuthContract;

class DefaultAuthChannel implements AuthContract
{
    /**
     * get openid.
     * @param string $url
     * @return mixed
     */
    public function getOpenid(string $url = '')
    {
        $config = [

            'oauth' => [
                'scopes'   => ['snsapi_base'],
                'callback' => '/oauth_callback',
            ],
        ];
    }
}