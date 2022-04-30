<?php
class GetDataClass
{
    protected $host = "localhost";
    protected $username = "root";
    protected $password = "root";
    protected $db = "Ice_cream";
    protected $conn;

    public function __construct()
    {
        $this->conn =  mysqli_connect($this->host, $this->username, $this->password, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

    
}
    public function qty($qty)
    {
        return  $this->conn->query($qty);
    }
}
