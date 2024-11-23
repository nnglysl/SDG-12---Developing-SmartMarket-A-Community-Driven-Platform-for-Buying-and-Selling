<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'smartmarket';
    private $conn;

    // Constructor to create a connection
    public function __construct()
    {
        $this->connect();
    }

    // Method to create a connection
    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname, 3307);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to get the connection
    public function getConnection()
    {
        return $this->conn;
    }

    // Method to close the connection
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>