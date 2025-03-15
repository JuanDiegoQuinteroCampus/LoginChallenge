<?php

require_once __DIR__ . '/config/Connect.php';
require_once __DIR__ . '/controllers/UserController.php';

$action = isset($_GET['action']) ? intval($_GET['action']) : 0;

new UserController($action);