<?php


class DataBase
{
    
    private $server = "localhost";
    private $user = "WebDiP2015x023";
    private $pass = "admin_R1ry";
    private $dbName = "WebDiP2015x023";
    
    private $conn = null;
    
    
    function dbConnect()
    {
        $this->conn = new mysqli($this->server, $this->user, $this->pass, $this->dbName);
        if($this->conn->connect_errno)
        {
            echo "Pogreska kod spajanja na bazu " . $this->conn->errno;
        }
        
        return $this->conn;
    }
    
    function dbSelect($query)
    {
        $result = $this->conn->query($query);
       
        if($this->conn->connect_errno)
        {
            echo "Pogreska kod upita " . $this->conn->errno;
        }
        return $result;
    }
    
    function dbQuery($query)
    {
        $this->conn->query($query);
       
        if($this->conn->connect_errno)
        {
            echo 'Pogreska kod upita ' . $this->conn->errno;
            return false;
        }
        
        return true;
    }
    
    function dbDisconnect()
    {
        $this->conn->close();
    }
    
}



