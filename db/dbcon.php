<?php
<<<<<<< HEAD
class Database
{
=======
class Database {
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'smartmarket';
    private $conn;

    // Constructor to create a connection
<<<<<<< HEAD
    public function __construct()
    {
=======
    public function __construct() {
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
        $this->connect();
    }

    // Method to create a connection
<<<<<<< HEAD
    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname, 3307);
=======
    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to get the connection
<<<<<<< HEAD
    public function getConnection()
    {
=======
    public function getConnection() {
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
        return $this->conn;
    }

    // Method to close the connection
<<<<<<< HEAD
    public function closeConnection()
    {
=======
    public function closeConnection() {
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>