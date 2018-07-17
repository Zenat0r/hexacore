<?php

if (!function_exists('xss_clean')) {
    function xss_clean($param = '')
    {
        return strip_tags(htmlspecialchars($param));
    }
}

if (!function_exists('query_clean')) {
    function query_clean($string = '')
    {
        if (ctype_digit($string)) {
            $string = intval($string);
        } else {
            $string = mysqli_real_escape_string($string);
            $string = addcslashes($string, '%_');
        }

        return $string;
    }
}

if (!function_exists('url_clean')) {
    function url_clean($str = '')
    {
        $str = strtr($str, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
        $str = strtr($str, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
        $str = strtr($str, ' ', '_');
        $str = str_replace('\'', '', $str);
        return strtolower($str);
    }
}
