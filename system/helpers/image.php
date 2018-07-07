<?php
if ( ! function_exists('upload')){

	function upload($file=NULL,$location=''){


        $target_dir = $_SERVER['DOCUMENT_ROOT'].'/'.Config::get("parentFolder").'assets/img/'.$location;
        $target_file = $target_dir.basename($file["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $testFileType = ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" );

        if(getImageSize($file["tmp_name"])===FALSE||$file===NULL||file_exists($target_file)||$file["size"] > 500000||$testFileType){
            return false;
        }
        
        // si tout est ok on télécharge
        if(move_uploaded_file($file["tmp_name"], $target_file)){
            return true;
        }else{
            return false;
        }
	}
}
if ( ! function_exists('img_remove')){

	function img_remove($location=''){

        $target_dir = img_url('uploads/'.$location);
        if(file_exists($target_file)){
            if(unlink($target_dir)){
                return true;
            }
            return false;
        }
        return false;
	}
}
