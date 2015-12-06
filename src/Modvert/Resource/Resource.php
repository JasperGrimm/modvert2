<?php namespace Modvert\Resource;

abstract class Resource implements IResource {

	protected $hidden_fields;

	protected $id;

	protected $name;

	protected $type;

	protected $data;

	/**
	 * Resource constructor.
	 * @param $data
	 */
	public final function __construct($data=null)
	{
		if ($data) {
			$this->data = $data;
			if (!array_key_exists('id', $data)) throw new \InvalidArgumentException('Data array must contain an `id` key');
			$this->id = $data['id'];
			$this->setName($data);
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($data)
	{
		if (array_key_exists('name', $data)) {
			$this->name = $data['name'];
		}
	}

	public function getType() {
		return $this->type;
	}


	public function setType($type) {
		if (in_array($type, ResourceType::asArray())) {
			$this->type = $type;
		} else {
			throw new Exception("Resource must be once of " . implode(', ', ResourceType::asArray()));
		}
	}

	public function getCleanFields() {
		$cleaned = [];
		foreach ($this->data as $k=>$v) {
			if (!in_array($k, $this->hidden_fields))
				$cleaned[$k] = $v;
		}
		return $cleaned;
	}

	protected function specialEscape($str)
	{
		return preg_replace("/(?<!\\\\)'/sm", '\\\'', $str);
	}

	abstract public function getInfo();

	abstract public function getContent();

	private function simpleArrayToString($arr)
	{
		return '['  . PHP_EOL . implode(', ', $arr) . PHP_EOL . ']';
	}

	private function assocArrayToString($arr)
	{
		$str_info = '[' . PHP_EOL;
		foreach ($arr as $key => $value) {
			$str_info .= "'$key' => '$value'," . PHP_EOL;
		}
		$str_info .= ']';
		return $str_info;
	}

	public function getStringInfo()
	{
		$info = $this->getInfo();
		$str_info = 'return [' . PHP_EOL;
		foreach ($info as $key => $value) {
			if (is_array($value)) {
				if ('templates' === $key) {
					$str_info .= "'$key' => " . $this->simpleArrayToString($value) . ',' . PHP_EOL;
				} else {
					$str_info .= "'$key' => " . $this->assocArrayToString($value) . ',' . PHP_EOL;
				}
			} else {
				$str_info .= "'$key' => '$value'," . PHP_EOL;
			}
		}
		$str_info .= '];';
		return $str_info;
	}

	public function setData($data)
	{
		$this->data = (array)$data;
		$this->id = $this->data['id'];
		$this->setName($this->data);
	}

	public function getData()
	{
		return $this->data;
	}
}