<?php

namespace iBrand\Common\Wechat\Contracts;

interface AuthContract
{
    /**
     * get openid.
     * @param string $url
     * @return mixed
     */
    public function getOpenid(string $url = '');
}