<?php

namespace iBrand\Common\Platform;

use Overtrue\Http\Client as HttpClient;
use Storage;

/**
 * Class Client
 * @package iBrand\Common\Platform
 */
class Client
{
    /**
     * @var
     */
    protected $baseUri;

    /**
     * @var
     */
    protected $accessToken;

    /**
     * @var
     */
    protected $httpClient;

    /**
     * Client constructor.
     * @param $baseUri
     * @param $accessToken
     */
    public function __construct($baseUri, $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->baseUri = $baseUri;
    }


    /**
     * get wechat oauth url from open platform.
     * @param $redirectUri
     * @param $appid
     * @return string
     */
    public function getOauthUrl($redirectUri, $appid)
    {
        $query = http_build_query(['appid' => $appid, 'redirect' => $redirectUri]);
        return $this->baseUri . 'oauth?' . $query;
    }

    /**
     * get user.
     * @param $appid
     * @param $openid
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     */
    public function getUser($appid, $openid)
    {
        $params = ['query' => compact('appid', 'openid')];
        return $this->request('api/oauth/user', $params);
    }

	/**
	 * @param $appid
	 * @param $openid
	 *
	 * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
	 * @throws \iBrand\Common\Exceptions\Exception
	 */
    public function getFans($appid, $openid)
    {
	    $params = ['query' => compact('appid', 'openid')];

	    return $this->request('api/fans/get', $params, 'POST');
    }


    /**
     * @param $appid
     * @param $page
     * @param $width
     * @param $scene
     * @param string $type
     * @param string $storage
     * @param $uuid
     * @return mixed
     */
    public function createMiniQrcode($appid, $page, $width, $scene, $type = 'share', $storage = 'public', $uuid)
    {

        $img_name = $scene . '_' . $type . '_' . $appid . '_mini_qrcode.jpg';

        $savePath = $type . '/mini/qrcode/' . $img_name;

        if (!empty($uuid)) {

            $savePath = $uuid . '/' . $savePath;
        }
        $params = [
            'scene' => $scene,
            'optional' => [
                'page' => $page,
                'width' => $width
            ],
        ];

        $new['json'] = $params;

        $body = $this->request("api/mini/app_code/getUnlimit?appid=$appid&uuid=$uuid", $new, 'POST', true);

        Storage::disk($storage)->put($savePath, $body->getBody());

        $result = Storage::disk($storage)->url($savePath);

        return $result;

    }


    /**
     *
     * @param $appid
     * @param $message
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     */
    public function sendTemplateMessage($appid, $message)
    {
        $data['json'] = $message;

        return $this->request("api/notice/send?appid=$appid", $data, 'POST');

    }


    /**
     * get js config.
     * @param $url
     * @param $appid
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     */
    public function getJsConfig($url, $appid)
    {
        return $this->request("api/js/config?appid=" . $appid . "&url=" . $url);
    }

    /**
     * @param $url
     * @param array $params
     * @param string $method
     * @param bool $returnRaw
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \iBrand\Common\Exceptions\Exception
     */
    protected function request($url, $params = [], $method = 'GET', $returnRaw = false)
    {
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken()->getToken()
            ]
        ];

        $params = array_merge($params, $headers);

        return $this->getHttpClient()->request($url, $method, $params, $returnRaw);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        $config = ['base_uri' => $this->baseUri];
        $http = HttpClient::create($config);
        $this->httpClient = $http;
        return $this->httpClient;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }
}