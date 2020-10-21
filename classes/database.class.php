<?php

class Database {
    /* Database settings */
    private $host = 'localhost';
    private $dbname = 'api_m5';
    private $user = 'courses_admin';
    private $pwd = 'password';
    private $conn;

    /* Database connection */
    public function connect() {
        try {
            $this->conn = new PDO('mysqli:host=' . $this->host . ';dbname=' . $this->user, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Connection error
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }  
}