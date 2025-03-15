<?php
require_once __DIR__ . '/../config/Connect.php';

class Users {
    private $id;
    private $username;
    private $password;
    private $idPerson;
    private $lastLogin;
    private $createdAt;

    private $conn;

    public function __construct($username = "", $password = "", $idPerson = 0, $lastLogin = null) {
        $this->conn = Connect::getInstance();
        $this->username = $username;
        $this->password = $password;
        $this->idPerson = $idPerson;
        $this->lastLogin = $lastLogin;
    }

    public function getIdUser() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getIdPerson() {
        return $this->idPerson;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function setIdPerson($idPerson) {
        $this->idPerson = $idPerson;
    }

    public function setLastLogin($lastLogin) {
        $this->lastLogin = $lastLogin;
    }

    public function insert() {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, idPerson, lastLogin)
                                      VALUES (:username, :password, :idPerson, :lastLogin)");
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':idPerson', $this->idPerson, PDO::PARAM_INT);
        $stmt->bindParam(':lastLogin', $this->lastLogin, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id) {
        $stmt = $this->conn->prepare("UPDATE users
                                      SET username = :username, password = :password, idPerson = :idPerson, lastLogin = :lastLogin
                                      WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':idPerson', $this->idPerson, PDO::PARAM_INT);
        $stmt->bindParam(':lastLogin', $this->lastLogin, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUsers($where = "") {
        $sql = "SELECT * FROM users $where";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
