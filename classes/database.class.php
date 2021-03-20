<?php

class Database {
    /* Database settings */
    private $dsn = 'mysql:host=localhost;dbname=susanneni_dt173g';
    private $user = '******';
    private $pwd = '******';

    /* Development */
    // private $dsn = 'mysql:host=localhost;dbname=api_m5';
    // private $user = '******';
    // private $pwd = '******';

    /* Database connection */
    public function connect() {
        try {
            $pdo = new PDO($this->dsn, $this->user, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;

        //Connection error
        } catch(PDOException $e) {
            throw $e;
            throw new PDOException('Could not connect to database');
        }
        return $this->conn;
    } 

    public function close() {
        $this->conn = null;
    }
}