<?php

namespace App\Controller;

class indexController{

  public function __construct() {
    
  }

  public function index() {
    // /**layout manager**/
    // $this->useLayout();

    // $this->layout->setTitle("Ch'tis Gamers - Eilco");
    // $this->layout->addStyle("materializeCG");
    // $this->layout->addStyle("index/main");
    // $this->layout->addStyle("components/hr");
    // $this->layout->addScript("jquery-3.1.1");
    // $this->layout->addScript("materialize");
    // $this->layout->addScript("index/main");

    // /** get data form database **/
    // $loader = new Loader();
    // $loader->model('user');
    // $loader->model('config');
    // $loader->model('maincontent');
    // $loader->model('sliders');

    // $members = new User_Model();

    // $query = "SELECT * FROM users WHERE us_member=:member AND us_site=:site AND us_role!='Secrétaire' ORDER BY RAND()";
    // $query = $members->execQuery($query, array('member' => 1, 'site' => "Calais"));

    // $data["members"]["calais"] = $query->fetchall();

    // $query = "SELECT * FROM users WHERE us_member=:member AND us_site=:site ORDER BY RAND()";
    // $query = $members->execQuery($query, array('member' => 1, 'site' => "Longuenesse"));

    // $data["members"]["longuenesse"] = $query->fetchall();

    // $config_layout = (new Config_Model())->get("layout_id");

    // $data["main"] = (new Maincontent_Model($config_layout))->get();

    // $data["sliders"] = (new Sliders_Model())->get_multi();

    // $this->layout->render("index/index", $data);

    return ["reponce" => "test"];
  }
}
