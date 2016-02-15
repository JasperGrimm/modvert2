<?php namespace Modvert\Resource;

class ResourceType {
	const CATEGORY = 'category';
	const CONTENT = 'content';
	const CHUNK = 'chunk';
	const SNIPPET = 'snippet';
	const TEMPLATE = 'template';
	const TV = 'tv';

	public static function asArray()
	{
		return [
			self::CATEGORY,
			self::CONTENT,
			self::CHUNK,
			self::SNIPPET,
			self::TEMPLATE,
			self::TV
		];
	}

	public static function isValid($type)
	{
			return in_array($type, self::asArray());
	}

	public static function fromPath($path) {
		$path = str_replace('\\', '/', $path);
		preg_match('/storage\/(' . implode('|', self::asArray()) . ')\//', $path, $matches);
		if (count($matches)>1) {
			return $matches[1];
		}
		return null;
	}
}
