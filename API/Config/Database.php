<?php
class Database {
    private $host = "localhost:3306"; 
    private $user = "root";
    private $password = "";
    private $dbname = "student_grade_api";
    public $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}