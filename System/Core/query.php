<?php

class Query
{
    // parametres de la requête

    private $gets;

    private $posts;

    public function __construct($gets, $post)
    {
        $this->gets = [
            "controller" => (empty($gets["controller"])) ? "" : $gets["controller"],
            "action" => (empty($gets["action"])) ? "" : $gets["action"],
            "gets" => (empty($gets["gets"])) ? "" : explode("/", $gets["gets"])
        ];
        $this->posts = $post;
    }

    // Renvoie vrai si le paramètre existe dans la requête
    public function existGet($name = "gets")
    {
        return (isset($this->gets[$name]) && $this->gets[$name] != "");
    }

    public function existPost($name)
    {
        return (isset($this->posts[$name]) && $this->posts[$name] != "");
    }

    // Renvoie la valeur du paramètre demandé
    // Lève une exception si le paramètre est introuvable

    public function get($name = "gets")
    {
        if ($this->existGet($name)) {
            return $this->gets[$name];
        } else {
            throw new Exception("Paramètre '$name' absent de la requête");
        }
    }

    public function post($name)
    {
        if ($this->existPost($name)) {
            return $this->posts[$name];
        } else {
            throw new Exception("Paramètre '$name' absent de la requête");
        }
    }

    public function viewExist($view)
    {
        $fileView = dirname(__FILE__) . "/../../application/views/" . $view . ".php";
        if (file_exists($fileView)) {
            return true;
        } else {
            return false;
        }
    }

    public function postsLength()
    {
        return sizeof($this->posts) - 1;
    }

    public function getsLength()
    {
        if (empty($this->gets['gets'])) {
            return 0;
        }
        return sizeof($this->gets['gets']);
    }
}
