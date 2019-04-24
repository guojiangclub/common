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
use iBrand\Common\Platform\ServiceProvider as PlatformServiceProvider;
use Route;
use Schema;

class CommonServiceProvider extends ServiceProvider
{
	public function boot()
	{
		if (!$this->app->routesAreCached()) {

			Route::prefix(api_prefix())
				->middleware(['api', 'cors'])
				->get('wechat/jssdkconfig', [
					'uses' => '\iBrand\Common\Controllers\WechatController@getJsConfig',
					'as'   => 'api.wechat.getJsConfig',
				]);
		}

		$this->publishes([
			__DIR__ . '/../config/app.php' => config_path('ibrand/app.php'),
		]);

		//set https default.
		if (config('ibrand.app.secure')) {
			\URL::forceScheme('https');
		}

		//set utm8bm4 for mysql database.
		Schema::defaultStringLength(191);
	}
}
