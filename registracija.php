<?php
    include 'VirtualnoVrijeme.php';
    include 'Dnevnik.php';
    $error ='';
    function error($string)
    {
        global $error;
        $error .= $string . "<br>";
    }
    
    function check($input)
    {
        global $error;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty($_POST[$input]))
            {
                error("Podatak ".$input." nije unesen");
                return false;
            }
        }
        return true;
    }
    
    function korime()
    {
        
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            
            $korime = $_POST["korime"];
            if(empty($korime)) return false;
            if(strlen($korime) < 10)
                { 
                    error("Korisnicko ime mora imati najmanje 10 znakova.");
                    return false;
                }
            return true;
        }
        return false;
    }
    
    function lozinka()
    {
        
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
          
            $lozinka = $_POST["lozinka1"];
            if(empty($lozinka)) return false;
            if(strlen($lozinka) < 8) 
            {
                error("Lozinka mora imati najmanje 8 znakova");
                return false;
            }
            return true;
        }
            
    }
    
    function isto()
    {
        global $error;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $lozinka1 = $_POST["lozinka1"];
            $lozinka2 = $_POST["lozinka2"];
            if($lozinka1 !== $lozinka2)
            {
                error("Lozinke nisu iste");
                return false;
            }
            return true;
        }
    }
    
    function dan ()
    {
        global $error;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $dan = $_POST["dan"];
            
            if($dan < 1)
            {
                error("Dan nesmije biti <1");
                return false;
            }
            return true;
        }
    }
    
    function mjesec()
    {
        $mjesec = $_POST["mjesec"];
        echo $mjesec;
    }
    
    function godina ()
    {
        global $error;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $godina = $_POST["godina"];
            if($godina < 1930 || $godina > 2015)
            {
               error("Godina mora biti izmedu 1930 i 2015");
                return false;
            }
            return true;
        }
    }
    
    function email()
    {
        global $error;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $mail = $_POST["email"];
            if(empty($mail)) return false;
            
            if(!preg_match('/^\w{2,}\.\w{2,}@\w{2,}\.\w{2,}$/',$mail))
                {
                    error("Email nije ispravan");
                    return false;
                }
            return true;
        }
    }
    
    function captcha()
    {
                if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        else {
            error("Nema odgovora od recaptcha"); 
            
        }
        $privatekey ="6LcQ5R4TAAAAAJmbKu0OCiZR_6FhyM8oZ_0btR-X";
        $resp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $resp = json_decode($resp, true);
        if($resp['success']==false){
            error("Provjera captche nije uspjela"); 
            return false;
        }
        return true;
    }
   
    
    function dbProvjera()
    {
        global $redirect;
        global $error;
        require 'baza_class.php';
        //if($error == 1) return false;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
        $db = new DataBase();
        $korime = $_POST["korime"];
        $email = $_POST["email"];
        $lozinka = $_POST["lozinka1"];
        $ime = $_POST["ime"];
        $prezime = $_POST["prez"];
        $dan = $_POST["dan"];
        $mjesec = $_POST["mjesec"];
        $godina = $_POST["godina"];
        $adresa = $_POST["adresa"];
        
        
        $aktivacijskiKod = hash("sha256",date('d.m.Y.H:i:s')."_". $korime);
        $query = "select idKorisnik from Korisnik where KorisnickoIme = '" .$korime ."'";
        $query2 = "select idKorisnik from Korisnik where Email = '" .$email."'";
        $query3 = "select idKorisnik from Korisnik where AktivacijskiKod = '".$aktivacijskiKod."'";
        $db->dbConnect();
        $result = $db->dbSelect($query);
        $result2 = $db->dbSelect($query2);
        $result3 = $db->dbSelect($query3);
        
        
        if($result->num_rows == 1)
        {
            dnevnik($query,'Registracija - korisničko ime postoji');
            error("Korisnicko ime postoji");
            return false;
        }
        
        if($result2->num_rows == 1)
        {
            dnevnik($query2,'Registracija - email postoji');
            error( "Email vec postoji ");
            return false;
        }
        
        if($result3->num_rows == 1)
        {
            dnevnik($query3,'Registracija - kod postoji');
            error( "Kod vec postoji");
            return false;
        }
        $regTime = time();
        $regTime = strtotime("+".dohvatiVrijeme()." hours",$regTime);
        $regTime = date('Y-m-d H:i:s', $regTime);
        $aktivan = 0;
        $tipKorisnika =1;
        $ymd = DateTime::createFromFormat('m-d-Y', $mjesec."-".$dan."-".$godina)->format('Y-m-d');
        $dodajKorisnika = "insert into Korisnik values "
                . "(default,'".$korime."','".$lozinka."','".$ime."'"
                . ",'".$prezime."','".$aktivan."','".$tipKorisnika."'"
                . ",'".$email."','".$aktivacijskiKod."','".$ymd."','".$regTime."','".$adresa."',0);";
        $resultInsert = $db->dbQuery($dodajKorisnika);
        $db->dbDisconnect();
        
        if($resultInsert === false)
        {
            dnevnik($dodajKorisnika,'Registracija - pogreška kod upisa u bazu' );
            error("Pogreska kod upisa u bazu");
            return false;
        }
        dnevnik($dodajKorisnika,'Registracija');
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $mailSent = mail(
                $email,
                "Link za aktivaciju",
                "Link za aktivaciju je https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x023/aktivacija.php?kod=".$aktivacijskiKod,
                $headers
                );
        if($mailSent === false)
        {
            
            error("Greska kod slanja maila");
            return false;
        }
        return true;
        }
        return false;
    }
    
    
    
  
    
    if(check("ime")&&check("prez")&&check("korime")&&check("lozinka1")&&
            check("lozinka2")&&check("dan")&&check("mjesec")&&check("godina")
                &&check("broj")&&check("email") && check("adresa")
                        &&  korime() && isto() && captcha()
                                && email() && dan() && godina() && dbProvjera()
      ){
        
    
        header('Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x023/');
        
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
        <title>Registracija</title>
        <meta name="author" content="Fran Goldner">
        <meta name="description" content="Početna stranica">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/fragoldne.css" rel="stylesheet" type="text/css" media="screen">
        <link href="./css/fragoldne_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="./css/fragoldne_mobiteli.css" rel="stylesheet" type="text/css" media="screen">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>    
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="./js/registracija.js"></script>
        
       
    </head>
     <body>
        <header>
            
            <h1 class="h1Header">Registracija</h1>
            <br/> 
            <div id="PRSwitch" class="PRSwitch">
                
            </div>
          
        </header>
         
        
       
        
        
        <div class="divContent" id="divRegistracija">
            
            <form id="form2" method="post" name="form2" action="registracija.php" novalidate="">
            
            <fieldset class="fieldsetReg">
                <label class="labelReg" for="ime">Ime: </label>
                <input class="inputReg" type="text" id="ime" name="ime" placeholder="Ime" required="required"><br>
                <div id = "divIme"></div>
                <br>
                <label class="labelReg" for="prez">Prezime: </label>
                <input class="inputReg" type="text" id="prez" name="prez" placeholder="Prezime" required="required"><br>
                <div id = "divPrez"></div>
                <br>
                <label class="labelReg" for="korime">Korisničko ime: </label>
                <input class="inputReg" type="text" id="korime" name="korime" placeholder="korisničko ime" required="required" size="10" maxlength="20"><br>
                <div id='divKorime' name='divKorime'></div>
                <br>
                <label class="labelReg" for="lozinka1">Lozinka: </label>
                <input class="inputReg" type="password" id="lozinka1" name="lozinka1" placeholder="lozinka" required="required"><br>
                <div id = "divPass"></div>
                <br>
                <label class="labelReg" for="lozinka2">Ponovi lozinku: </label>
                <input class="inputReg" type="password" id="lozinka2" name="lozinka2" placeholder="lozinka" required="required"><br>   
                <div id = "divPonovljena"></div>
                <br>
                
               
            
            </fieldset>
            <br>
                
                
            <fieldset class="fieldsetReg    ">
                    
                    <label class="labelReg" for="dan">Dan: </label>
                    <input class="inputReg" type="number" name="dan" placeholder="Dan" id="dan" required="required" min="1" max="31"  >
                    <div id = "divDan"></div>
                    <br>
                    <br>
                    <label class="labelReg" for="mjesec">Mjesec: </label>
                    <select class="inputReg" name="mjesec" id="mjesec" placeholder="Mjesec">
                    
                        
                        <option value="01">Siječanj</option>
                        <option value="02">Veljača</option>
                        <option value="03">Ožujak</option>
                        <option value="04">Travanj</option>
                        <option value="05">Svibanj</option>
                        <option value="06">Lipanj</option>
                        <option value="07">Srpanj</option>
                        <option value="08">Kolovoz</option>
                        <option value="09">Rujan</option>
                        <option value="10">Listopad</option>
                        <option value="11">Studeni</option>
                        <option value="12">Prosinac</option>
                                        
                        
                    </select>
                    <div id = "divMjesec"></div>
                    <br>
                    <br>
                    <label class="labelReg" for="godina">Godina: </label>
                    <input class="inputReg" name="godina" type="number" min="1930" id="godina" placeholder="Godina">
                    <div id = "divGodina"></div>
                    <br>
                    <br>
                </fieldset>
            
            
                <br>
                
                <fieldset class="fieldsetReg">
                    <label class="labelReg" for="adresa">Adresa</label>
                    <input class="inputReg" type="text" name="adresa" id="adresa" placeholder="Adresa">
                    <div id = "divAdresa"></div>
                    <br>
                    
                   
                    <br>
                    <label class="labelReg" for="broj">Poštanski broj</label>
                    <input class="inputReg" type="text" name="broj" id="broj" placeholder="XXXXX">
                    <div id = "divPostanski"></div>
                    <br>
                    <br>
                    <label class="labelReg" for="grad">Grad:</label>
                    <input class="inputReg" type="text" name="grad" id="grad" placeholder="Grad">
                    <div id = "divGrad"></div>
                    <br>
                    <br>
                    
                </fieldset>
                
                
                <br>
                <label class="labelReg" for="email">Email adresa: </label>
                <input class="inputReg" type="email" id="email" name="email" placeholder="ime.prezime@posluzitelj.xxx" required="required">
                <div id = "divEmail"></div>
                <br>
                <br>
                
                <label class="labelReg" for="robot">Nisam robot:</label>
                <div class="g-recaptcha" data-sitekey="6LcQ5R4TAAAAALEupQ_c48HXVx5lbbVlrs79TZRM" id="recaptcha"></div>
                
                <div id="divRobot"></div>
                 
                    
                  
                <br>
                
                
                
                <input class="inputReg"  type="submit" value="Registriraj se">
                    
                </div>
            
            </form>
    <?php global $error; echo $error;}?>
           
            
            <br>
        </div>
        
       
        <footer>
            
        </footer>
 
    </body>
</html>

    
    
