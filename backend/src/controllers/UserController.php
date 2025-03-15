<?php
require __DIR__ . '/../entities/Users.php';

class UserController {
    private $action;
    private const VERIFY_CREDENTIALS = 1;

    public function __construct($action) {
        $this->action = $action;
        $this->handleAction();
    }

    private function handleAction() {
        switch ($this->action) {
            case self::VERIFY_CREDENTIALS:
                $this->verifyCredentials();
                break;

            default:
                echo json_encode(["error" => "Acción no válida"]);
                break;
        }
    }

    private function verifyCredentials(){
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($email) || empty($password)) {
            echo json_encode(["error" => "lack of data", "success"=> false]);
            return;
        }
        $select = "persons.email, users.id";
        $where = "JOIN persons ON users.id_person = persons.id where persons.email = :email";
        $params = [':email' => $email];

        $users = new Users;
        $response = $users->getUsers($select, $where, $params, true);

        if (empty($response)) {
            echo json_encode(["error" => "Not found", "success"=> false]);
            return;
        }
        
        if (!password_verify($password, $response->getPassword())) {
            echo json_encode(["error" => "Incorrect password","success"=> false]);
            return;
        }
        date_default_timezone_set('America/Bogota');
        $timeSession = date('Y-m-d H:i:s');
        $timePlusOneHour = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($timeSession)));
        $response->setLastLogin($timeSession);
        $response->update();

        echo json_encode([
            "success" => true,
            "message" => "Verified credentials",
            "data" => [
                "id"    => $response->getIdUser(),
                "time"  => $timePlusOneHour,
                "email" => $email
            ]
        ]);
    }
}
