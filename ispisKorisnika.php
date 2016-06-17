<?php

header('Content-type: text/html; charset=utf-8');
include 'baza_class.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $broj = $_POST["broj"];
    
}
?>

<html>
    <head>
        <title>Ispis Korisnika</title>
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
        
        <script type="text/javascript" src="./js/ispisKorisnika.js"></script>
        
    </head>
    <body>
        <header>
            
            <h1 class="h1Header">Ispis Korisnika</h1>
            <br/> 
            
        </header>
       
        <nav id = 'nav'>
            
        </nav>
        
        
        <div class="divContent" id="divIspis">
            
            
                <p><label class="labelReg" for="search">Pretraži: </label>
                <input class="inputReg" type="text" id="search" name="search" placeholder="Pretraživanje" >                             
                <label class="labelReg" for="noItems">Broj podataka: </label>
                    <select class="inputReg" name="noItems" id="noItems" placeholder="Broj podataka">
                    
                        
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        
                                        
                        
                    </select>
                <input type="button" id ="refresh" name="refresh" onclick="reSort()" value="Osvježi">
                <span id="tableThings"></span>
                <span id="menuThings"></span>
            </div>
                
                
                
  
           
            
            
             
                </div>
         
        
        <footer>
             
        </footer> 
    </body>
</html>
