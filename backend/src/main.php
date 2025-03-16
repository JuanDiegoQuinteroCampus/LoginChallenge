<?php

require_once __DIR__ . '/config/Connect.php';
require_once __DIR__ . '/controllers/UserController.php';

header("Access-Control-Allow-Origin: *"); // Permitir todas las conexiones
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos


$action = isset($_POST['action']) ? intval($_POST['action']) : 0;

new UserController($action);