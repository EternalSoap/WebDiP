<?php

include 'VirtualnoVrijeme.php';

$error = '';

function error($string)
{
    global $error;
    $error.=$string.'<br>';
}
function dbCheck()
{
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $kod = $_GET["kod"];
    
    require 'baza_class.php';
    $db = new DataBase();
    $db->dbConnect();
    $query1 = "select * from Korisnik where AktivacijskiKod = '".$kod."';";
    $result =$db->dbSelect($query1);
    
    if($result->num_rows ===0)
    {
        error("Pogresan aktivacijski kod ");
        return false;
    }
        
    else 
    {
        if(get('shiftused')==1)
        {
            $pomak = get('shiftvalue');
        }
        else
        {
            $pomak = 0;
        }
        if(get('duration')!='')
        {
            $trajanje = get("duration");
        }
        else
        {
            $trajanje = 10;
        }
        
        
            $row = $result->fetch_assoc();
            $id = $row["idKorisnik"];
            $datum = $row["DatumRegistracije"];
          
            
            
                               
        
        $current = time();
        
        $datePhp = strtotime($datum);
        $shifted = $datePhp + ($trajanje*60*60);
        $current = $current+($pomak*60*60);
        
        error($shifted);
        error($current);
        
        
        if($shifted <$current)
        {
            error("Aktivacijski kod ne vrijedi");
            return false;
        }
        
            
        
        
        $query2 = "update Korisnik set Aktivan = 1 where AktivacijskiKod = '".$kod."';";
        
        $result = $db->dbQuery($query2);
        
        $db->dbDisconnect();
        return true;
    }
    }
}


if(dbCheck() === true)
{
    
    header('Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x023/index.php');
}
else
{
    global $error;
    echo $error . '<br>';
}

 ?>