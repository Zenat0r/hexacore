<?php

abstract class Controller
{
    // Action à réaliser
    private $action;

    //Erreur detercté (utilisé pour motrez la vue error dans les constructeurs)
    private $error = false;

    // Requête entrante
    protected $query;

    // Session variable
    protected $session;

    // Data variable,
    protected $data = [];

    // Instance de layout
    protected $layout;

    public function __construct()
    {
        $this->session = new Session(31557600);
        $this->session->start();
    }

    // Définit la requête entrante
    public function setQuery(Query $query)
    {
        $this->query = $query;
    }

    // Exécute l'action à réaliser
    public function execAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            if (!$this->error) {
                $this->{$this->action}();
            }
        } else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    // Méthode abstraite correspondant à l'action par défaut
    // Oblige les classes dérivées à implémenter cette action par défaut
    abstract public function index();

    // Génère la vue associée au contrôleur courant
    protected function showView($nameView, $dataView = [])
    {
        // Instanciation et génération de la vue
        $view = new View($nameView);
        $view->show($dataView);
    }

    // Layouts
    protected function useLayout($layout = "default")
    {
        $this->layout = new Layout($layout);
    }

    /**error views**/
    public function showError($errorCode, $msg = null)
    {
        switch ($errorCode) {
      case 404:
        $data = [
            "error" => "404",
            "message" => "La page que vous cherchez est introuvable"
        ];
        break;

       case 401:
        $data = [
            "error" => "401",
            "message" => "Utilisateur non authentifié"
        ];
        break;

      case 403:
        $data = [
            "error" => "403",
            "message" => "Accès refusé"
        ];
        break;

      case 500:
        $data = [
            "error" => "500",
            "message" => "Erreur serveur"
        ];
        break;

      case 503:
        $data = [
            "error" => "503",
            "message" => "Erreur serveur"
        ];
        break;
    }
        if ($msg = null) {
            $data['message'] = $msg;
        }
        $this->error = true;
        $view = new View("error");
        $view->show($data);

        /**error showed stop the rest of the programme**/
        exit;
    }
}
