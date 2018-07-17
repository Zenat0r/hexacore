<?php

if (!function_exists('error_description')) {
    // renvoie les messages d'erreurs selon leurs codes
    function getError($codeError)
    {
        $filePath = "application/config/error.ini";
        if (!file_exists($filePath)) {
            throw new Exception("Aucun fichier de configuration error.ini manqant");
        } else {
            $params = parse_ini_file($filePath);
        }
        return isset($params[$codeError]) ? $params[$codeError] : null;
    }
}
