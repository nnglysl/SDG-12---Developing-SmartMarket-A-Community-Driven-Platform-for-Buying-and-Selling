<?php

class Home
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function getRandomProducts()
    {
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            error_log("Database query failed: " . mysqli_error($this->conn), 3, "../logs/error.log");
            return [];
        }
    }

    public function __destruct()
    {
        if ($this->conn) {
            mysqli_close($this->conn); 
            $this->conn = null; 
        }
    } 
}

?>