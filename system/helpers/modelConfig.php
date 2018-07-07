<?php
/**
 * label: {
 *		name: 'test',
 *		type: 'text', << text, password, email, textarea, option, date >>
 *		hidden: false,
 *		options: 'en, fr, pl'
 * }
 */
if ( ! function_exists('configClass')){

	function configClass($name, $type, $hidden=false, $options=null){
		if(empty($name) || empty($type)) throw new Exception("Erreur argument(s) manquant");

		$typeAccepted = array("text", "number", "password", "email", "textarea", "option", "date");
		
		if(!in_array($type,$typeAccepted) throw new Exception("Erreur type invalide");
		
		$obj = new stdClass();

		$obj->name = $name;
		$obj->type = $type;
		$obj->hidden = $hidden;
		$obj->options = $options;

		return $obj;
	}
}