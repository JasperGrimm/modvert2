<?php namespace Modvert\Helper;

class ArrayHelper {

  public static function get($array, $path)
  {
    $keys_set = explode('.', $path);
    $value = null;
    if (count($keys_set) == 1) {
      return $array[$keys_set[0]];
    }
    $key = array_shift($keys_set);
    $path = implode('.', $keys_set);
    return self::get($array[$key], $path);
  }

  public static function pluck($array, $key)
  {
    $result = [];
    foreach ($array as $value) {
      $result[] = self::get($value, $key);
    }
    return $result;
  }

  public static function matchValue($array, $key, $regexp)
  {
    $result = [];
    $values = self::pluck($array, $key);
    foreach ($values as $key => $value) {
      if (!is_array($value) && preg_match($regexp, $value)) {
        $result[] = $value;
      }
    }
    return $result;
  }

}
