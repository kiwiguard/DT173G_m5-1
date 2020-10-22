<?php

class Database {
    /* Database settings */
    private $dsn = 'mysql:host=localhost;dbname=api_m5';
    private $user = 'courses_admin';
    private $pwd = 'password';

    /* Database connection */
    protected function connect() {
        try {
            $pdo = new PDO($this->dsn, $this->user, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $pdo;

        //Connection error
        } catch(PDOException $e) {
            throw $e;
            throw new PDOException('Could not connect to database');
        }
    } 
}