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
}