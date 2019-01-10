<?php

/*
 * This file is part of ibrand/common.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common\Wechat\Platform\Services;

use iBrand\Common\Wechat\Platform\AccessToken;
use iBrand\Common\Wechat\Platform\Cache;
use iBrand\Common\Wechat\Platform\Http;

class PlatformService
{
    protected $token;

    protected $http;

    protected $accountRepository;

    protected $appid;

    protected $uuid;

    public function __construct($appid, $uuid)
    {
        $this->appid = $appid;

        $this->uuid = $uuid;

        $this->config = config('ibrand.wechat_platform');

        $this->token = new AccessToken($this->config['wechat_api_url'] . 'oauth/token', 'wx.api.access_token', $this->config['wechat_api_client_id'], $this->config['wechat_api_client_secret'], $this->appid, $this->uuid);

        $this->http = new Http($this->token);
    }

    /**
     * @param $scene
     * @param array $optional
     *
     * @return type
     */
//    public function getMiniProgramCode($appid, $scene, array $optional = [])
//    {
//        $data = [
//            'scene' => $scene,
//            'optional' => $optional,
//        ];
//
//        return $this->wxCurl(self::$appUrl.'api/mini/app_code/getUnlimit?client_id='.self::$CLIENT_ID.'&appid='.$appid, $data, false);
//    }


    public function getUrl($appid,$str)
    {

        return $this->config['wechat_api_url'] . $str . '?client_id=' . $this->config['wechat_api_client_id'] . '&appid=' . $appid;
    }

    public function getToken($forceRefresh = false)
    {
        $Cache = new Cache('wx.api.access_token');
        $Cache->forget('wx.api.access_token');

        return $this->token->getToken($forceRefresh);
    }

    public function upload($type, $path, $url)
    {
        $image = curl_file_create($path);
        $data = [
            $type => $image,
        ];

        $headers[] = 'Authorization:Bearer ' . $this->token->getToken();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /* 内置函数 */

    /**
     * 微信简易curl.
     *
     * @param type $url
     * @param type $optData
     *
     * @return type
     */
    public function wxCurl($url, $optData = null, $json_decode = true)
    {
        $headers[] = 'Authorization:Bearer ' . $this->token->getToken();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (!empty($optData)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($optData));
        }

        $res = curl_exec($ch);

        if (!$json_decode) {
            return $res;
        }

        return json_decode($res);
    }
}
