<?php

class Connect {
    private static $instance = null;
    private $conx;
    private $env;

    private function __construct() {
        // Cargar variables de entorno desde .env
        $this->env = parse_ini_file(__DIR__ . "/../../.env");

        try {
            $dsn = "{$this->env['DB_DRIVER']}:host={$this->env['DB_HOST']};port={$this->env['DB_PORT']};dbname={$this->env['DB_NAME']}";
            $this->conx = new PDO($dsn, $this->env['DB_USER'], $this->env['DB_PASSWORD']);
            $this->conx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectarse a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Connect();
        }
        return self::$instance->conx;
    }

    public function __get($name) {
        return $this->env[$name] ?? null;
    }
}
