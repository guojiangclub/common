<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $additional = ['status' => true];

    /**
     * @param array $data
     * @param int   $code
     * @param bool  $status
     *
     * @return Response
     */
    public function success($data = [], $code = Response::HTTP_OK, $status = true)
    {
        return new Response(['status' => $status, 'code' => $code, 'data' => empty($data) ? null : $data]);
    }

    /**
     * @param      $message
     * @param int  $code
     * @param bool $status
     *
     * @return mixed
     */
    public function failed($message, $data = [],$code = Response::HTTP_BAD_REQUEST, $status = false)
    {
        return new Response(['status' => $status, 'code' => $code, 'message' => $message,'data' => empty($data) ? null : $data]
        );
    }

    /**
     * @param $data
     * @param $resourceClass
     * @param array $meta
     *
     * @return array
     */
    public function item($data, $resourceClass, $meta = [])
    {
        if (is_null($data)) {
            return compact('data');
        }
        if (empty($meta)) {
            return (new $resourceClass($data))->additional($this->additional);
        }

        return (new $resourceClass($data))->additional(array_merge($this->additional, compact('meta')));
    }

    /**
     * @param $data
     * @param $resourceClass
     * @param array $meta
     *
     * @return mixed
     */
    public function collection($data, $resourceClass, $meta = [])
    {
        if (empty($meta)) {
            return $resourceClass::collection($data)->additional($this->additional);
        }

        return $resourceClass::collection($data)->additional(array_merge($this->additional, compact('meta')));
    }

    /**
     * @param Paginator $paginator
     * @param $resourceClass
     * @param array $meta
     *
     * @return mixed
     */
    public function paginator(Paginator $paginator, $resourceClass, $meta = [])
    {
        return $this->collection($paginator, $resourceClass, $meta);
    }
}
