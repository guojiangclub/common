<?php

namespace iBrand\Common\Wechat\Contracts;

interface AuthContract
{
    /**
     * @param string $url
     * @param string $name
     * @return mixed
     */
    public function createOauthUrl(string $url = '', string $name = 'default');
}