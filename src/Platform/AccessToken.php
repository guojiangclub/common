<?php

/*
 * This file is part of ibrand/common.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common\Platform;

use iBrand\Common\Exceptions\Exception;
use Overtrue\Http\Client as HttpClient;
/**
 *  Laravel passport access_token
 */
class AccessToken
{
    protected $baseUri;

    /**
     * 应用ID.
     *
     * @var string
     */
    protected $client_id;

    /**
     * 应用secret.
     *
     * @var string
     */
    protected $client_secret;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * 缓存前缀
     *
     * @var string
     */
    protected $cacheKey = 'ibrand.platform.access_token';

    /**
     * AccessToken constructor.
     * @param $tokenUrl
     * @param $client_id
     * @param $client_secret
     * @throws \Exception
     */
    public function __construct($baseUri, $client_id, $client_secret)
    {
        $this->baseUri = $baseUri;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->cache = cache();
    }

    /**
     * @param $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }


    /**
     * @param bool $forceRefresh
     * @return \Illuminate\Contracts\Cache\Repository|mixed
     * @throws Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->cacheKey;

        $cached = $this->cache->get($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();

            $expires_in = isset($token['expires_in']) ? $token['expires_in'] : 2592000;

            if (isset($token['access_token'])) {
                $this->cache->set($cacheKey, $token['access_token'], $expires_in - 800);
                return $token['access_token'];
            }

            throw new Exception('Failure to get token.');
        }

        return $cached;
    }

    /**
     * get token from server.
     *
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     */
    protected function getTokenFromServer()
    {

        $config = ['base_uri' => $this->baseUri];

        $http = HttpClient::create($config);

        $params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credentials',
        ];

        return $http->post('oauth/token', $params);
    }
}
