<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
$error = '';

include 'UserTypeCheck.php';
include 'cookies.php';
include 'fileStuff.php';
include_once 'Dnevnik.php';

function error($string)
{
    global $error;
    $error .= $string . '<br>';
}
         
function dbCheck()
{
    include_once 'baza_class.php';
    $db = new DataBase();
    if(getConfig('numtries') == 0)
    {
        $numTries = 5;
    }
    else
    {
        $numTries = getConfig("numtries");
    }
    
     if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $korime = $_POST["korime"];
            $lozinka = $_POST["lozinka"];
            $checked = ( isset( $_POST["zapamti"]))?1:0;
            
            $db->dbConnect();
            $query1 = "select * from Korisnik where KorisnickoIme='".$korime."' and Lozinka ='".$lozinka."' and Aktivan = 1;";
            $query2 = "update Korisnik set BrojPokusaja = BrojPokusaja+1 where KorisnickoIme='".$korime."'";
            $result =$db->dbSelect($query1);
            
            
            
            
            if($result->num_rows !=1)
            {
                $resultUpdate = $db->dbQuery($query2);
                if($resultUpdate !==true)
                {
                    error("Pogreška kod pristupa bazi");
                }
                dnevnik($query1,'Neuspjela prijava');
                error("Pogresno korisnicko ime ili lozinka ");
                return false;
            }
            dnevnik($query1,'Uspješna prijava');
             
            
           
          
            $row = $result->fetch_assoc();
            $numTriesUser = $row["BrojPokusaja"];
            $id = $row['idKorisnik'];
             
             
            if( intval($numTriesUser)>intval($numTries))
            {
                error("Korisnički račun je zaključan");
                dnevnik($query2,'Zaključan korisnički račun');
                return false;
            }
            
            $db->dbDisconnect();
        $userType = UserTypeCheck($korime)["TipKorisnika_idTipKorisnika"];
        
        if($userType ==-1) 
        {
            return false;
        }
        
            if($checked ===1)
            {
                if(check('korime') ===false)
                {
                    set('korime', $korime, 1);
                }
            else
            {
                if(check('korime')===true)
                {
                    delete('korime');
                }
            }
                
            }
            session_start();
            $_SESSION['UserType'] = $userType;
            $_SESSION['UserID'] = $id;
            
            return true;
        }
}

if(dbCheck() === true)
{
    echo error;
    header('Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x023/glavna.php');
    exit();
}
else
{


?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Prijava</title>
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
            
            <h1 class="h1Header">Prijava</h1>
            <br/> 
            
            <div id="PRSwitch" class="PRSwitch">
                
            </div>
            
        </header>
       
        
        
        
        <div class="divContent" id="divPrijava">
            
            <form id="form1" method="post" name="form1" action="index.php" novalidate="">
                <p><label class="labelReg" for="korime">Korisničko ime: </label><br>
                <input class="inputReg" type="text" id="korime" name="korime" placeholder="korisničko ime" autofocus="autofocus" required="required"><br>
                <label class="labelReg"  for="lozinka">Lozinka: </label><br>
                <input class="inputReg" type="password" id="lozinka" name="lozinka" placeholder="lozinka" required="required"><br>
                <input class="inputReg" type="checkbox" id="zapamti" name="zapamti"> <label>Zapamti me</label><br>
                
<?php echo $error; } ?>
                <div class="errorDiv" id="errorDiv" name="error">
                
                
            </div>
                
                <input class="inputReg" id="submit1" type="submit" value=" Prijavi se "><br>
                
                <label class="labelReg">Novi korisnik?</label><br><a href="registracija.php">Registrirajte se</a><br>
                
                
                <label class="labelReg">Zaboravljena lozinka?</label><br><a href="reset.php">Resetiraj lozinku </a><br>
                
                <label class="labelReg">Pregled bez registracije?</label><br><a href="glavna.php">Demo </a><br>
           
            </form>
            
             
                </div>
         
        
        <footer>
             
        </footer> 
    </body>
</html>
