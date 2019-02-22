<?php

namespace iBrand\Common\Wechat\OfficialAccount\Channels;

use iBrand\Common\Wechat\Contracts\AuthContract;

class PlatformAuthChannel implements AuthContract
{

    /**
     * @param string $url
     * @param string $name
     * @return mixed
     */
    public function createOauthUrl(string $url = '', string $name = 'default')
    {

    }
}