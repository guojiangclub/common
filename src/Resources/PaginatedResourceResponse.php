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

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();

        return [
                'meta' => ['pagination' => array_merge($this->meta($paginated), ['links' => $this->paginationLinks($paginated)])],
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param array $paginated
     *
     * @return array
     */
    protected function meta($paginated)
    {
        $resource = $this->resource->resource;

        return [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage(),
        ];
    }
}
