<?php 

class User_Model extends Model{

    public function __construct($member=null){
        if($member!=null) $this->us_member = $member;
    }

    protected $table = 'users';

    public $us_id;
    public $us_firstname;
    public $us_lastname;
    public $us_password;
    public $us_email;
    public $us_member;
    public $us_role;
    public $us_actif;
    public $us_lostPassword;
    public $us_site;
    public $us_member_img;
    public $us_token;

    public $us_pseudo;
    public $us_exp;

    public function config(){
        parrent::config();
        
        $config = new stdClass();
        $config->id = configClass("Identifiant", "number", true);
        $config->firstname = configClass("Prénom", "text");
        $config->lastname = configClass("Nom de famille", "text");
        $config->password = configClass("Mot de passe", "text", true);
        $config->email = configClass("Adresse mail", "email");
        $config->member = configClass("Est membre", "number");
        $config->role = configClass("Role dans l'association", "text");
        $config->actif = configClass("Est actif", "number");
        $config->lostPassword = configClass("Mot de passe perdu", "number");
        $config->site = configClass("Campus", "text");
        $config->member_img = configClass("Emplacement de l'image de membre", "text");
        $config->token = configClass("Token de l'utilisateur", "text");

        $config->pseudo = configClass("Pseudo du joueur", "text");
        $config->exp = configClass("Experience du joueur", "exp");
        
        return $config;
    }

    public function execQuery($sql, $params = null){
        return parent::execQuery($sql, $params);
    }
    /**
     * Active le compte d'un utilisateur
     * @param  string $token token relatif et unique a l'utilsateur a activer
     * @return void        
     */
    public function activate($token=null){
        if(empty($this->us_token) && empty($token)) throw new Exception("Error no token given");
        if($token != null) $this->us_token = $token;

        $this->us_actif  = 1;
        $this->update("us_token=:us_token");
    }
    /**
     * Verifie si l'email existe
     * @param  string $mail mail de l'utilisateur a vériier
     * @return int       nombre d'utilisateur trouvé 1 ou 0
     */
    public function verifyMail($mail=null){
        if(empty($this->us_email) && empty($mail)) throw new Exception("Error no email given");
        if($mail != null) $this->us_email = $mail;

        $query = "SELECT COUNT(*) FROM users WHERE us_email=:mail";
        $query = $this->execQuery($query, array("mail" => $this->us_email));

        return $query->fetchColumn();
    }
    /**
     * Verifie si le vompte et actif
     * @param  string $mail mail de l'utilisateur a vérifier
     * @return int       nombre d'utilisateur trouvé 1 ou 0
     */
    public function verifyActive($mail=null){
        if(empty($this->us_email) && empty($mail)) throw new Exception("Error no email given");
        if($mail != null) $this->us_email = $mail;
        
        $query = "SELECT COUNT(*) FROM users WHERE us_email=:mail AND us_actif=:actif";
        $query = $this->execQuery($query, array("mail" => $this->us_email, "actif" => 1));

        return $query->fetchColumn();
    }
    /**
     * modify le mot de passe d'un utilisateur
     * @param  string $pass mot de passe non hashé
     * @return void
     */
    /**
     * modify le mot de passe d'un utilisateur
     * @param  String $pass mot de pass non hashé
     * @param  string $mail email de l'utilisateur
     * @return void
     */
    public function changePassword($pass=null, $mail=null){
        if(empty($this->us_password) && empty($pass)) throw new Exception("Error no password given");
        if(empty($this->us_email) && empty($mail)) throw new Exception("Error no email given");
        if($pass != null) $this->us_password = password_hash($pass, PASSWORD_DEFAULT);
        if($mail != null) $this->us_email = $mail;

        $this->update("us_email=:us_email");
    }
    /**
     * Verify si le compte d'un ustilisateur a perdu son mot de passe
     * @param  string $mail mail de l'utilisateur
     * @return int       retourn 0 si l'utilisateur n'a pas perdu son mot de pass 1 sinon
     */
    public function verifyLost($mail=null){
        if(empty($this->us_email) && empty($mail)) throw new Exception("Error no email given");
        if($mail != null) $this->us_email = $mail;
        
        $query = "SELECT COUNT(*) FROM users WHERE us_email=:mail AND us_lostPassword=:lostPassword";
        $query = $this->execQuery($query, array("mail" => $this->us_email, "lostPassword" => 1));

        return $query->fetchColumn();
    }
    public function setPseudo($pseudo, $mail=null){
        if(empty($pseudo)) throw new Exception("Pseudo manqant");
        else if(empty($this->us_email) && empty($mail)) throw new Exception("Error no email given");
        if($mail != null) $this->us_email = $mail;

        $query = "UPDATE users SET us_pseudo=:pseudo WHERE us_email=:mail";
        $query = $this->execQuery($query, array("mail" => $this->us_email, "pseudo" => $pseudo));

        return $query->rowCount();
    }
} 