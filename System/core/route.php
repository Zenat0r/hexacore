<?php

class Route {

  // Route une requête entrante : exécute l'action associée
  public function routeQuery() {
    try {
      $query = new Query($_GET, $_POST);

      $controller = $this->createController($query);
      $action = $this->createAction($query);

      $controller->execAction($action);
    }
    catch (Exception $e) {
      $this->manageError($e);
    }
  }

  // Crée le contrôleur approprié en fonction de la requête reçue
  private function createController(Query $query) {
    $controller = Config::get("defaultController");// Contrôleur par défaut
    if ($query->existGet('controller')) {
      $controller = $query->get('controller');
      // Première lettre en majuscule
      $controller = strtolower($controller);
    }
    // Création du nom du fichier du contrôleur
    $fileController = Config::get("appPath")."/controllers/" . $controller . ".php";
    if (file_exists($fileController)) {
      // Instanciation du contrôleur adapté à la requête
      require($fileController);
      $controller = new $controller();
      $controller->setquery($query);
      return $controller;
    }
    else
      throw new Exception("Fichier '$fileController' introuvable");
  }

  // Détermine l'action à exécuter en fonction de la requête reçue
  private function createAction(Query $query) {
    $action = Config::get("defaultAction");  // Action par défaut
    if ($query->existGet('action')) {
      $action = $query->get('action');
    }
    return $action;
  }

  // Gère une erreur d'exécution (exception)
  private function manageError(Exception $exception) {
    $view = new View('error');
    $view->show(array('error' => "404", 'message' => $exception->getMessage()));
  }
}
