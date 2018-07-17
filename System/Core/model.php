<?php
abstract class Model
{
    private static $bdd;
    protected $table;

    protected function execQuery($sql, $params = null)
    {
        if ($params == null) {
            $result = self::getBdd()->query($sql);   // exécution directe
        } else {
            $result = self::getBdd()->prepare($sql); // requête préparée
            $result->execute($params);
        }

        return $result;
    }

    private static function getBdd()
    {
        if (self::$bdd === null) {
            // Récupération des paramètres de configuration BD

            $dsn = Config::get("dsn");

            $login = Config::get("login");

            $mdp = Config::get("mdp");

            // Création de la connexion

            self::$bdd = new PDO($dsn, $login, $mdp, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }

        return self::$bdd;
    }

    public function insert()
    {/// à modifier pour que cela soit dynamique
        $array_object = get_object_vars($this);

        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);
        $array_object = array_filter($array_object, 'strlen');
        $query = "INSERT INTO " . $this->table . "(";
        $values = " VALUES (";
        foreach ($array_object as $key => $attr) {
            $query .= ($key . ",");
            $values .= (" :" . $key . ",");
            $array_object[$key] = $attr;
        }

        $query = substr($query, 0, -1) . ")";

        $values = substr($values, 0, -1) . ")";

        $query .= $values;

        return $this->execQuery($query, $array_object);
    }

    public function get_multi($limit = null, $order = null)
    {
        $array_object = get_object_vars($this);

        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);
        $array_object = array_filter($array_object, 'strlen');

        $query = "SELECT * FROM " . $this->table;
        if (count($array_object) !== 0) {
            $query .= " WHERE ";
            foreach ($array_object as $key => $attr) {
                $query .= ($key . " = :" . $key . " ,");
                $array_object[$key] = $attr;
            }
            $query = substr($query, 0, -1);
        }
        $result = [];
        if ($order != null) {
            $query = $query . ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $query = $query . ' LIMIT ' . $limit;
        }
        $query = $this->execQuery($query, $array_object);
        while ($obj = $query->fetchObject(get_class($this))) {
            array_push($result, $obj);
        }
        return $result;
    }

    public function get($select = '*')
    {
        $array_object = get_object_vars($this);
        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);
        $array_object = array_filter($array_object, 'strlen');

        $query = "SELECT " . $select . " FROM " . $this->table;

        if (count($array_object) !== 0) {
            $query .= " WHERE ";
            foreach ($array_object as $key => $attr) {
                $query .= ($key . " = :" . $key . " ,");
                $array_object[$key] = $attr;
            }
            $query = substr($query, 0, -1);
        }
        if ($select !== '*') {
            return $this->execQuery($query, $array_object)->fetch()[0];
        }
        return $this->execQuery($query, $array_object)->fetchObject(get_class($this));
    }

    public function delete()
    {
        $array_object = get_object_vars($this);

        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);

        $array_object = array_filter($array_object, 'strlen');

        $query = "DELETE FROM " . $this->table;

        if (count($array_object !== 0)) {
            $query .= " WHERE ";

            foreach ($array_object as $key => $attr) {
                $query .= ($key . " = :" . $key . " ,");
                $array_object[$key] = $attr;
            }

            $query = substr($query, 0, -1);
        }

        return $this->execQuery($query, $array_object);
    }

    public function update($where = null)
    {
        $array_object = get_object_vars($this);

        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);

        $array_object = array_filter($array_object, 'strlen');

        $query = "UPDATE " . $this->table . " SET ";

        foreach ($array_object as $key => $attr) {
            $query .= ($key . " = :" . $key . " ,");
            $array_object[$key] = $attr;
        }

        $query = substr($query, 0, -1);

        if ($where !== null) {
            $query = $query . 'WHERE ' . $where;
        }

        return $this->execQuery($query, $array_object);
    }

    public function count($col = '*', $where = null)
    {
        $array_object = get_object_vars($this);
        $array_object = array_diff_key($array_object, ["table" => '', "bdd" => '']);
        $array_object = array_filter($array_object, 'strlen');

        $query = "SELECT COUNT ( " . $col . " ) FROM " . $this->table;
        if ($where !== null) {
            $query .= " WHERE " . $where;
        }

        return $this->execQuery($query, $array_object);
    }

    protected function config()
    {
        $loader = new Loader();
        $loader->helper("modelConfig");
    }
}
