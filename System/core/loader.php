 <?php

require_once 'url.php';

class Loader {

    function __construct(){
    }

    function autoload(){
        $core_files=array_diff(scandir( (dirname(__FILE__))), array('..', '.'));
        foreach($core_files as $file){
                require_once dirname(__FILE__).'/'.$file;
        }
    }

    function model($name){
        require_once dirname(__FILE__).'/../../application/models/'.$name.'_model.php';
    }

    function helper($name){
        require_once dirname(__FILE__).'/../helpers/'.$name.'.php';
    }

}