<?php namespace Modvert;

class StringUtil {
  	public static function specialEscape($str)
	{
		return preg_replace("/(?<!\\\\)'/sm", '\\\'', $str);
	}
}
