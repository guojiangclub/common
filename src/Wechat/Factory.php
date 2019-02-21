<?php

namespace iBrand\Common\Wechat;

use EasyWeChat\Kernel\Support\Str;

class Factory
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @return \EasyWeChat\Kernel\ServiceContainer
     */
    public static function make($name, array $config)
    {
        if(is_string($config)){

        }

        $namespace = Str::studly($name);
        $application = "\\EasyWeChat\\{$namespace}\\Application";
        return new $application($config);
    }
    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}