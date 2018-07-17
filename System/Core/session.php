<?php


class Session
{
    public function __construct($duration = 1440)
    {
        /**Set session duration 1440 default php7**/
        session_set_cookie_params($duration);
    }

    public function start()
    {
        return session_start();
    }

    public function destroy()
    {
        session_unset();
        return session_destroy();
    }

    public function userdata($name = null, $value = null)
    {
        if ($name === null) {
            return $_SESSION;
        }
        if ($value !== null) {
            $_SESSION[$name] = $value;
        }
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function loged()
    {
        return !empty($_SESSION);
    }

    public function unset_userdata($name = null)
    {
        if ($name === null) {
            session_unset();
            return true;
        }
        $_SESSION[$name] = null;
        return true;
    }
}
