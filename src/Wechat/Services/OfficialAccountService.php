<?php


namespace iBrand\Common\Wechat\Services;


use iBrand\Common\Exceptions\Exception;

class OfficialAccountService
{

    /**
     * @param string $url
     * @throws Exception
     */
    public function getOpenid(string $url)
    {
        if (empty($url)) {
            throw new Exception('url cannot be empty.');
        }

        return fdsfsdfds;
    }
}