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

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;

class BaseResource extends JsonResource
{
	/**
	 * @var array
	 */
	protected $withoutFields = [];

	public static function collection($resource)
	{
		if (!$resource instanceof AbstractPaginator) {
			$resource = collect(collect_to_array($resource));
		}

		return new BaseResourceCollection($resource, get_called_class());
	}

	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request
	 *
	 * @return array
	 */
	public function toArray($request)
	{
		return $this->filterFields(parent::toArray($request));
	}

	/**
	 * Set the keys that are supposed to be filtered out.
	 *
	 * @param array $fields
	 *
	 * @return $this
	 */
	public function hide(array $fields)
	{
		$this->withoutFields = $fields;

		return $this;
	}

	/**
	 * Remove the filtered keys.
	 *
	 * @param $array
	 *
	 * @return array
	 */
	protected function filterFields($array)
	{
		return collect($array)->forget($this->withoutFields)->toArray();
	}
}
