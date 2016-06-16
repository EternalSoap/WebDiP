<?php
require 'baza_class.php';
include 'Dnevnik.php';
if($_SERVER["REQUEST_METHOD"]==="POST")
{
    $korime = $_POST["korime"];
    
  
    $db = new DataBase();
    $db->dbConnect();
    $query = "select idKorisnik from Korisnik where KorisnickoIme = '" .$korime ."'";
    $result = $db->dbSelect($query);
    $db->dbDisconnect();
    if($result->num_rows ==0)
    {
        dnevnik($query,'Provjera korisničkog imena - ne postoji');
        echo json_encode("0");
    }
    else
    {
        dnevnik($query,'Provjera korisničkog imena - postoji');
        echo json_encode("1");
    }
}


