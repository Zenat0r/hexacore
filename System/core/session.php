<?php



class Session {

    function __construct($duration=1440){
        /**Set session duration 1440 default php7**/
        session_set_cookie_params($duration);
    }

    public function start(){
        return session_start();
    }

    public function destroy(){
        session_unset();
        return session_destroy();
    }

    public function userdata($name=NULL,$value=NULL){
        if($name===NULL){
            return $_SESSION;
        }
        if($value!==NULL){
            $_SESSION[$name]=$value;
        }
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return NULL;
    }

    public function loged(){
        return !empty($_SESSION);
    }

    public function unset_userdata($name=NULL){
        if($name===NULL){
            session_unset();
            return true;
        }
        $_SESSION[$name]=NULL;
        return true;
    }
}