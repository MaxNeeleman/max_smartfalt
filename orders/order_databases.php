<?php
    class Databases {
        private $pdo;
        
        public function __construct($host, $dbname, $user, $pass) {
            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
    
        public function getPDO() {
            return $this->pdo;
        }
    }