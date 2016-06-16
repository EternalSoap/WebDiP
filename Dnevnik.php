<?php
function dnevnik($query,$action)
{
    
    
    $server = "localhost";
    $user = "WebDiP2015x023";
    $pass = "admin_R1ry";
    $dbName = "WebDiP2015x023";
    
    
    $msqli = new mysqli($server, $user, $pass, $dbName);
    if($msqli->connect_errno)
        {
            echo "Pogreska kod spajanja na bazu " . $this->conn->errno;
        }
    
   
    $query = $msqli->real_escape_string($query);
    $regTime = date('Y-m-d H:i:s', time());
    
    $dodajZapis = "insert into Dnevnik values (default,'".$query."','".$regTime."','".$action."');";
    
    
    
    $msqli->query($dodajZapis);
    if($msqli->connect_errno)
        {
            echo 'Pogreska kod upita ' . $msqli->errno;
            $msqli->close();
            return false;
        }
        $msqli->close();
        return true;
  
}
