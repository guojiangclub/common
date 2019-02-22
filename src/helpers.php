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