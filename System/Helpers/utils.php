<?php 

if(!function_exists("generateRandomPassword")){
	function generateRandomPassword($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length - 3; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $number = "0123456789";
	    $char = "abcdefghijklmnopqrstuvwxyz";
	    $charUpperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	    $rand = rand(0,150);

	    if(0 <= $rand && 50 >= $rand){
	    	$randomString .= $number[rand(0, 9)];
	    	$randomString .= $char[rand(0, 25)];
	    	$randomString .= $charUpperCase[rand(0, 25)];
	    }else if(50 <	 $rand && 100 >= $rand){	    	
	    	$randomString .= $char[rand(0, 25)];
	    	$randomString .= $charUpperCase[rand(0, 25)];
	    	$randomString .= $number[rand(0, 9)];
	    }else{
	    	$randomString .= $char[rand(0, 25)];
	    	$randomString .= $number[rand(0, 9)];
	    	$randomString .= $charUpperCase[rand(0, 25)];
	    }

	    return $randomString;
	}
}