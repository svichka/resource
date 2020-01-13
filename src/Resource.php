<?php


namespace Zoon\Resource;


class Resource {

	/**
	 * The resource instance.
	 *
	 * @var mixed
	 */
	public $resource;

	/**
	 * Create a new resource instance.
	 *
	 * @param  mixed  $resource
	 * @return void
	 */
	public function __construct($resource) {
		$this->resource = $resource;
	}

	/**
	 * Transform the resource into an array.
	 *
	 * @return array
	 */
	public function toArray() {
		if (is_null($this->resource)) {
			return [];
		}
		return is_array($this->resource)
			? $this->resource
			: $this->resource->toArray();
	}

	/**
	 * Create new anonymous resource collection.
	 *
	 * @param  array  $list
	 * @return array
	 */
	public static function collection(array $list) : array {
		$result = [];
		foreach ($list as $item) {
			array_push($result, (new static($item))->toArray());
		}

		return $result;
	}
}
