<?php

namespace Hexacore\Core\Storage\Session;

use Hexacore\Core\Storage\StorageInterface;
use Hexacore\Core\Storage\Session\SessionInterface;

class Session implements StorageInterface, SessionInterface
{
    public function start() : void
    {
        session_start();
    }

    public function destroy() : void
    {
        session_unset();
        session_destroy();
    }

   public function add($name, $value = null) : boolean
   {
       $value = $value ?? $name;
       if(isset($_SESSION[$name])){
           return false;
       } else {
           $_SESSION[$name] = $value;
           return true;
       }
   }

   public function remove($name) : bool
   {
       if(isset($_SESSION[$name])){
           unset($_SESSION[$name]);
           return true;
       } else {
           return false;
       }
   }

   public function get($name)
   {
       return $_SESSION[$name];
   }
}
