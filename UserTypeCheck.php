<?php
include_once 'Dnevnik.php';
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
            dnevnik($query,'Provjera tipa korisnika - ne postoji');
            return -1;
            
        }
        
        dnevnik($query,'Provjera korisničkog imena - postoji');
        return $result->fetch_assoc();
        
}