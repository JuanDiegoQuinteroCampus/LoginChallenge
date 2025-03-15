<?php
require_once __DIR__ . '/../config/Connect.php';

class Users {
    private $id;
    private $username;
    private $password;
    private $idPerson;
    private $lastLogin;

    private $conn;
    private $isCompleteLoaded = false;

    public function __construct($username = "", $password = "", $idPerson = 0, $lastLogin = null) {
        $this->conn = Connect::getInstance();
        $this->username = $username;
        $this->password = $password;
        $this->idPerson = $idPerson;
        $this->lastLogin = $lastLogin;
    }

    /**
     * Método mágico __get para implementar lazy loading de propiedades.
     *
     * Este método se llama automáticamente cuando se intenta acceder a una propiedad inaccesible o inexistente.
     * Si los datos completos del usuario aún no han sido cargados, se invoca el método loadCompleteUser() para recuperar
     * la información completa de la base de datos.
     *
     * @param string $name El nombre de la propiedad a acceder.
     * @return mixed El valor de la propiedad si existe, o null si no.
     */
    public function __get($name) {
        if (!$this->isCompleteLoaded && in_array($name, ['password', 'username', 'idPerson', 'lastLogin'])) {
            $this->loadCompleteUser();
            $this->isCompleteLoaded = true;
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function loadCompleteUser() {
        if ($this->id !== null) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                $this->loadUser($data); // Actualiza todas las propiedades
            }
        }
    }

    public static function findById($id) {
        $conn = Connect::getInstance();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) return null;
        
        $user = new self();
        $user->loadUser($data);
        return $user;
    }

    public function getUsers($select = "*", $where = "", $params = [], $single = false) {
        $sql = "SELECT $select FROM users $where";
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
    
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($single && !empty($result)) {
            $this->loadUser($result[0]);
            return $this;
        }
    
        return $result;
    }

    public function getIdUser() {
        return $this->__get('id');
    }
    
    public function getUsername() {
        return $this->__get('username');
    }
    
    public function getPassword() {
        return $this->__get('password');
    }
    
    public function getIdPerson() {
        return $this->__get('idPerson');
    }
    
    public function getLastLogin() {
        return $this->__get('lastLogin');
    }
    public function setUsername($username) { $this->username = $username; }
    public function setPassword($password) { $this->password = password_hash($password, PASSWORD_BCRYPT); }
    public function setIdPerson($idPerson) { $this->idPerson = $idPerson; }
    public function setLastLogin($lastLogin) { $this->lastLogin = $lastLogin; }

    public function insert() {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, id_person, last_login)
                                      VALUES (:username, :password, :id_person, :last_login)");
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':id_person', $this->idPerson, PDO::PARAM_INT);
        $stmt->bindParam(':last_login', $this->lastLogin, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update() {
        $fields = [];
        $params = [':id' => $this->id];
        
        if (!empty($this->username)) {
            $fields[] = "username = :username";
            $params[':username'] = $this->username;
        }
        if (!empty($this->password)) {
            $fields[] = "password = :password";
            $params[':password'] = $this->password;
        }
        if (!empty($this->idPerson)) {
            $fields[] = "id_person = :id_person";
            $params[':id_person'] = $this->idPerson;
        }
        if (!empty($this->lastLogin)) {
            $fields[] = "last_login = :last_login";
            $params[':last_login'] = $this->lastLogin;
        }
        
        if (empty($fields)) return false;
        
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        return $stmt->execute();
    }

    public function delete() {
        if (!$this->id) return false;
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function loadUser($data) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->idPerson = $data['id_person'] ?? null;
        $this->lastLogin = $data['last_login'] ?? null;
    }
}
