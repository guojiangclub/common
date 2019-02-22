<?php

namespace iBrand\Common\Wechat\OfficialAccount\Channels;

use iBrand\Common\Wechat\Contracts\AuthContract;
use iBrand\Common\Wechat\Factory;

class DefaultAuthChannel implements AuthContract
{
    /**
     * @param string $url
     * @param string $name
     * @return mixed|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createOauthUrl(string $url = '', string $name = 'default')
    {
        $app = Factory::officialAccount($name);

        return $app->oauth->scopes(['snsapi_base'])->setRedirectUrl($url)
            ->redirect();
    }

    public function getOpenid(){

    }
}