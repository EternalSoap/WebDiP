<?php

include_once 'baza_class.php';

    
    
    //$lozinka = $_POST["lozinka"];
    
function UserTypeCheck ($korime){
 $db = new DataBase();
        $db->dbConnect();
        $query = "select * from Korisnik where KorisnickoIme ='".$korime."'";
        $result = $db->dbSelect($query);
        $db->dbDisconnect();
        if($result->num_rows!==1)
        {
            echo json_encode("-1");
            
        }
        $assocResult = [];
       
        return $result->fetch_assoc();
        
}