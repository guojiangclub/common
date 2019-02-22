<?php


namespace iBrand\Common\Platform;

use Overtrue\Http\Client as HttpClient;

class Client
{
    protected $baseUri;

    protected $accessToken;

    protected $httpClient;

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

    protected function request($url, $params = [], $method = 'GET')
    {
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken()->getToken(),
            ]
        ];

        $params = array_merge($params, $headers);

        return $this->getHttpClient()->request($url, $method, $params);
    }

    public function getHttpClient()
    {
        $config = ['base_uri' => $this->baseUri];
        $http = HttpClient::create($config);
        $this->httpClient = $http;
        return $this->httpClient;
    }

    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }
}