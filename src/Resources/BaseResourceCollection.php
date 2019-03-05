<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Common\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * @var array
     */
    protected $withoutFields = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    /**
     * Send fields to hide to UsersResource while processing the collection.
     *  将隐藏字段通过 UsersResource 处理集合.
     *
     * @param $request
     *
     * @return array
     */
    protected function processCollection($request)
    {
        return $this->collection->map(function (BaseResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
            ? (new PaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}
