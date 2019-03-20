<?php


namespace iBrand\Common\Platform;

/**
 * Class Application.
 * @method Client            getOauthUrl($redirectUri,$appid)
 * @method Client            getUser($appid,$openid)
 * @method Client            createMiniQrcode($appid, $page, $width, $scene, $type = 'share', $storage = 'public', $uuid)
 * @method Client            sendTemplateMessage($appid,$message)
 */
class Application
{
    protected $client;

    /**
     * Application constructor.
     * @param $baseUri
     * @param $clientId
     * @param $clientSecret
     * @throws \Exception
     */
    public function __construct($baseUri, $clientId, $clientSecret)
    {
        $this->client = new Client($baseUri,new AccessToken($baseUri,$clientId,$clientSecret));
    }

    public function __call($name, $arguments)
    {
        return $this->client->$name(...$arguments);
    }
}