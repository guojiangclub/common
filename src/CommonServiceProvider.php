<?php

/*
 * This file is part of ibrand/common.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common;

use iBrand\Common\Wechat\WechatServiceProvider;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(WechatServiceProvider::class);
    }
}
