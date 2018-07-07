<?php

class Config {

  private static $params;

  // Renvoie la valeur d'un paramètre de configuration

  public static function get($param, $defaultValue = null) {
    if (isset(self::getParams()[$param])) {
      $value = self::getParams()[$param];
    }
    else {
      $value = $defaultValue;
    }
    return $value;
  }

  // Renvoie le tableau des paramètres en le chargeant au besoin
  private static function getParams() {
    if (self::$params == null) {
      $filePath = "application/config/prod.ini";
      if (!file_exists($filePath)) {
        $filePath = "application/config/dev.ini";
      }
      if (!file_exists($filePath)) {
        throw new Exception("Aucun fichier de configuration trouvé");
      }
      else {
        self::$params = parse_ini_file($filePath);
      }
    }
    return self::$params;
  }
}