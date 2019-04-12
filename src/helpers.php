<?php

if (!function_exists('platform_application')) {

    /**
     * get platform application.
     *
     * @return \iBrand\Common\Platform\Application
     */
    function platform_application(): \iBrand\Common\Platform\Application
    {
        return app('ibrand.platform');
    }
}

if (!function_exists('is_mobile')) {

    /**
     * Check string is a mobile number.
     *
     * @param string $mobile
     * @param string $type : 'china' or 'international'
     * @return bool|string
     */
    function is_mobile(string $mobile, string $type = 'china')
    {
        if ($type == 'china') {
            $regExp = '/^(?:\+?86)?1(?:3\d{3}|5[^4\D]\d{2}|8\d{3}|7(?:[01356789]\d{2}|4(?:0\d|1[0-2]|9\d))|9[189]\d{2}|6[567]\d{2}|4[579]\d{2})\d{6}$/';
        } else {
            $regExp = '/^(\\+\\d{2}-)?(\\d{2,3}-)?([1][3,4,5,7,8][0-9]\\d{8})$/';
        }
        return preg_match($regExp, $mobile) ? $mobile : false;
    }
}

if (!function_exists('is_mail')) {

    /**
     * check string is a email
     *
     * @param string $email
     * @return bool|string
     */
    function is_mail(string $email)
    {
        $regExp = '/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
        return preg_match($regExp, $email) ? $email : false;
    }
}

if (!function_exists('is_username')) {


    /**
     * check string is a username
     *
     * @param string $username
     * @return bool|string
     */
    function is_username(string $username)
    {
        $regExp = '/^[a-zA-Z\d\x{4e00}-\x{9fa5}]{2,20}$/u';
        return preg_match($regExp, $username) ? $username : false;
    }
}

if (!function_exists('api_prefix')) {

    /**
     * get api prefix
     *
     * @param string $prefix
     * @param string $version
     * @return string
     */
    function api_prefix($prefix = 'api', $version = '')
    {
        $version = $version ?? config('ibrand.app.api_version');

        if ($version == 'v1') {
            return $prefix;
        }

        return $prefix . '/' . $version;
    }
}

if (!function_exists('get_wechat_config')) {

    /**
     * get wechat config.
     * @param string $app
     * @param string $type
     * @return \Illuminate\Config\Repository|mixed
     */
    function get_wechat_config($app = 'default', $type = 'official_account')
    {
        return config('ibrand.wechat.' . $type . '.' . $app);
    }
}