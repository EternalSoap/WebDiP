<?php

$error = '';
require 'baza_class.php';
include 'Dnevnik.php';

function error($string)
    {
        global $error;
        $error .= $string . "<br>";
    }

function dbCheck($korime)
{
    
    $db = new DataBase();
    
    
            $db->dbConnect();
            $query1 = "select * from Korisnik where KorisnickoIme='".$korime."'";
            $result =$db->dbSelect($query1);
            $db->dbDisconnect();
            
            if($result->num_rows !=1)
            {
                dnevnik($query1,'Resetiranje lozinke - korisnik ne postoji');
                error("Korisnik ne postoji ");
                return false;
            }
            dnevnik($query,'Resetiranje lozinke - korisnik postoji');
            $row = $result->fetch_assoc();
            return $row;
            
                     
            
}
        
        


function newPassword($len=10)
{
    $znakovi = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    $newPass='';
    
    for($i=0;$i<$len;$i++)
    {
        $newPass.=$znakovi[rand(0,strlen($znakovi)-1)];
    }
    return $newPass;   
}

function dbInsert($newPass,$korime)
{
    
    
        $query = "update Korisnik set Lozinka = '".$newPass."' where KorisnickoIme = '".$korime."'";
        $db = new DataBase();
        $db->dbConnect();
        $result = $db->dbQuery($query);
        if($result ===false)
        {
            dnevnik($query,'Resetiranje lozinke - pogreška');
            error("Pogreška kod pristupanja bazi");
            return false;
        }
        dnevnik($query,'Resetiranje lozinke - uspjeh');
        return true;
        
        
    
}

if(isset($_POST['korime']))
{
    $korime = $_POST['korime'];
    
    $user = dbCheck($korime);
    
    $email = $user["Email"];
    $headers = '';
   
    
    $newPass = newPassword();
    if($newPass !== false)
    {
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $mailSent = mail(
                $email,
                "Nova Lozinka",
                "Zatražili ste novu lozinku, ona glasi ".$newPass,
                $headers
                );
        dbInsert($newPass,$korime);
        
         
    }
    error("Lozinka promjenjena");
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<html>
    <head>
        <title>Resetiranje lozinke</title>
        <meta name="author" content="Fran Goldner">
        <meta name="description" content="Početna stranica">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/fragoldne.css" rel="stylesheet" type="text/css" media="screen">
        <link href="./css/fragoldne_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="./css/fragoldne_mobiteli.css" rel="stylesheet" type="text/css" media="screen">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>    
        <script type="text/javascript" src="./js/prijava.js"></script>
    </head>
    <body>
        <header>
            
            <h1 class="h1Header">Resetiranje lozinke</h1>
            <br/> 
            <div id="PRSwitch" class="PRSwitch">
                
            </div>
           
        </header>
       
        <nav id = 'nav'>
            
        </nav>
        
        
        <div class="divContent" id="divReset">
            
            <form id="form1" method="post" name="form1" action="reset.php" novalidate="">
                <p><label class="labelReg" for="korime">Korisničko ime: </label>
                <input class="inputReg" type="text" id="korime" name="korime" placeholder="korisničko ime" autofocus="autofocus" required="required"><br>                              
                <div class="errorDiv" id="errorDiv" name="error">
                
                
            </div>
                
                <input class="inputReg" id="submit1" type="submit" value="Resetiraj lozinku "><br>
                
               
           
            </form>
            
             
                </div>
         
        
        <footer>
             
        </footer> 
    </body>
</html>
