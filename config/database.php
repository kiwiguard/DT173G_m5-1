<?php

class Database {
    /* Database settings */
    private $host = 'localhost';
    private $db_name = 'courses';
    private $username = 'courses_admin';
    private $password = 'password';
    private $conn;

    /* Database connection */
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysqli:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Connection error
        } catch(PDOException $e) {
            echo "Connection error " . $e->getMessage();
        }
        return $this->conn;
    }
    public function close() {
        $this->conn = null;
    }
    
}