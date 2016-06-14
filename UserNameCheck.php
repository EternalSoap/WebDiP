<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'baza_class.php';
if($_SERVER["REQUEST_METHOD"]==="POST")
{
    $korime = $_POST["korime"];
    
  
    $db = new DataBase();
    $db->dbConnect();
    $query = "select idKorisnik from Korisnik where KorisnickoIme = '" .$korime ."'";
    $result = $db->dbSelect($query);
    $db->dbDisconnect();
    if($result->num_rows ==0)
        echo json_encode("0");
    else
        echo json_encode("1");
   
}


