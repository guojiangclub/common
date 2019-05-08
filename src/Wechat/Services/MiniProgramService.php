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

use Storage;

class MiniProgramService
{
	/**
	 *生成小程序太阳码
	 *
	 * @param        $appid
	 * @param        $page
	 * @param        $width
	 * @param        $scene
	 * @param string $type
	 * @param string $storage 存在类型public,qiniu
	 * @param        $uuid
	 *
	 * @return bool
	 */
	public function createMiniQrcode($appid, $page, $width, $scene, $type = 'share', $storage = 'public', $uuid = '')
	{
		$img_name = $scene . '_' . $type . '_' . $appid . '_mini_qrcode.jpg';

		$savePath = $type . '/mini/qrcode/' . $img_name;

		if (!empty($uuid)) {

			$savePath = $uuid . '/' . $savePath;
		}
		
		$data = [
			'scene'    => $scene,
			'optional' => [
				'page'  => $page,
				'width' => $width,
			],
		];

		$platform = new PlatformService($appid, $uuid);

		$url = $platform->getUrl($appid, 'api/mini/app_code/getUnlimit');

		$body = $platform->wxCurl($url, $data, false);

		if (str_contains($body, 'errcode')) {

			return false;
		}

		Storage::disk($storage)->put($savePath, $body);

		$result = Storage::disk($storage)->url($savePath);

		if ($result) {
			return $result;
		}

		return false;
	}

	/**
	 * 通过code获取Session
	 *
	 * @param        $appid
	 * @param        $code
	 * @param string $uuid
	 *
	 * @return array
	 */
	public function getSession($appid, $code, $uuid = '')
	{
		$platform = new PlatformService($appid, $uuid);

		$data['code'] = $code;

		$url = $platform->getUrl($appid, 'api/mini/base/session');

		$res = $platform->wxCurl($url, $data, false);

		$res_arr = [];

		if (json_decode($res)) {
			foreach (json_decode($res) as $key => $item) {
				$res_arr[$key] = $item;
			}
		}

		return $res_arr;
	}

	public function decryptData($appid, $session_key, $iv, $encryptData, $uuid = '')
	{

		$platform = new PlatformService($appid, $uuid);

		$data['session'] = $session_key;

		$data['iv'] = $iv;

		$data['encryptData'] = $encryptData;

		$url = $platform->getUrl($appid, 'api/mini/decrypted');

		return $platform->wxCurl($url, $data);
	}

	public function getToken($appid, $forceRefresh = false, $uuid = '')
	{

		$platform = new PlatformService($appid, $uuid);

		return $platform->getToken($forceRefresh);
	}
}
