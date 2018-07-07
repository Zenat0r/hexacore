<?php

class View {

  // Nom du fichier associé à la vue
  private $file;

  // Titre de la vue (défini dans le fichier vue)
  private $title;

  public function __construct($action) {
    $this->file = Config::get("appPath")."/views/" . $action . ".php";
  }

  public function show($data=NULL) {
    // Génération de la vue
    $view = $this->showFile($this->file, $data);

    echo $view;
  }

  public function showFile($file, $data=NULL) {
    if (file_exists($file)) {
      // Rend les éléments du tableau $data accessibles dans la vue
      if($data!==NULL)extract($data);
      // Démarrage de la temporisation de sortie
      ob_start();
      // Inclut le fichier vue
      // Son résultat est placé dans le tampon de sortie
      require $file;
      // Arrêt de la temporisation et renvoi du tampon de sortie
      return ob_get_clean();
    }
    else {
      throw new Exception("Fichier '$file' introuvable");
    }
  }
  private function clean($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
  }
}
