<?php

namespace iBrand\Common\Wechat;

use EasyWeChat\Kernel\Support\Str;

/**
 * Class Factory.
 *
 * @method static \EasyWeChat\Payment\Application            payment(array $config)
 * @method static \EasyWeChat\MiniProgram\Application        miniProgram(array $config)
 * @method static \EasyWeChat\OpenPlatform\Application       openPlatform(array $config)
 * @method static \EasyWeChat\OfficialAccount\Application    officialAccount(array $config)
 * @method static \EasyWeChat\BasicService\Application       basicService(array $config)
 * @method static \EasyWeChat\Work\Application               work(array $config)
 * @method static \EasyWeChat\OpenWork\Application           openWork(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param $config
     *
     * @return \EasyWeChat\Kernel\ServiceContainer
     */
    public static function make($name, $config = 'default')
    {
        if (is_string($config)) {
            $snakeName = strtolower(Str::snake($name));
            $config = config('ibrand.wechat.' . $snakeName . '.' . $config);
        }

        if (empty($config)) {
            $config = config('ibrand.wechat.' . $snakeName . '.default');
        }

        $namespace = Str::studly($name);
        $application = "\\EasyWeChat\\{$namespace}\\Application";
        $app = new $application($config);

        $laravelApp = app();
        if (config('ibrand.wechat.defaults.use_laravel_cache')) {
            $app['cache'] = new CacheBridge($laravelApp['cache.store']);
        }

        $app['request'] = $laravelApp['request'];

        return $app;
    }


    /**
     * Dynamically pass methods to the application.
     *
     * @param $name
     * @param $arguments
     * @return \EasyWeChat\Kernel\ServiceContainer
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}