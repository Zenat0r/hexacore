<?php

namespace Hexacore\Core\Config;

use Hexacore\Core\Config\ConfigInterface;

class JsonConfig implements ConfigInterface{

  private $params;
  private static $instance;

  public static function get(string $filepath  = __DIR__ . "/../../App/config/app.json") : ConfigInterface
  {
    if (is_null(self::$instance)) {
      self::$instance = new JsonConfig($filepath);
    }

    return self::$instance;
  }

  private function __contructor(string $filepath) : void
  {
    $string = file_get_contents($filepath);
    $this->params = json_decode($string, true);
  }
}