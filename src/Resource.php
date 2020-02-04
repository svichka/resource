<?php


namespace Zoon\Resource;


class Resource {

	/**
	 * The resource instance.
	 *
	 * @var mixed
	 */
	public $resource;
	protected $additional;

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
	 * Add additional meta data to the resource response.
	 *
	 * @param  array  $data
	 * @return $this
	 */
	public function additional(array $data)
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
		return $this;
	}

	/**
	 * Create new resource collection.
	 *
	 * @param  array $list
	 * @param  array $data
	 * @return array
	 */
	public static function collection(array $list, array $data = []) : array {
		$result = [];
		foreach ($list as $item) {
			array_push($result, (new static($item))->additional($data)->toArray());
		}
		return $result;
	}

	/**
	 * Create new response from collection.
	 *
	 * @param array $list
	 * @param array $data
	 * @return array
	 */
	public static function response(array $list, array $data = []) : array {
		$result = static::collection($list, $data);
		return [
			'count' => count($result),
			'items' => $result,
		];
	}
}
