<?php

/*
 * This file is part of ibrand/common.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common\Wechat;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/wechat.php' => config_path('ibrand/wechat.php'),
            ]);
        }
    }
}
