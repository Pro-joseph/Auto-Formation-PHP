<?php

class Database
{
    private static $instance = null;
    private $pdo;

    // Private constructor: no one can call new Database() from outside
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }

    // Return the single instance (create it on first call)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    // Return the PDO connection
    public function getConnection()
    {
        return $this->pdo;
    }
}
