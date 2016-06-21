<?php

?>


<html>
    <head>
        <title>Ustanove</title>
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
        <script src="./js/crud.js"></script>
        
        
        
    </head>
    <body>
        
        
        
        
        <div class="divReplacableContent" id="divAdminContent" >
            <form name="frmKreirajUstanovu" id='frmKreirajUstanovu' action='ustanova.php' method="post">
            <fieldset id='kreiranjeUstanove'>
                
                <label>Kreiranje ustanove</label><br><br>
                <label>Naziv</label> <input type="text" name="naziv"><br>
                <label>Opis</label> <input type="text" name ="opis"><br>
                <input type="submit" value="Dodaj ustanovu">
                
                
                
            </fieldset>
            </form>
            
            <form action="ustanova.php" method='post' id='frmDodajModeratora'>
                <fieldset>
                    
                    
                    <label>Dodavanje moderatora</label>
                    <select id='selectUstanova'></select> &nbsp; <select id='selectKorisnik'></select>
                    <input type='submit' value='Dodaj moderatora'>
                    
                    
                </fieldset>
            </form>
            
            
            
            </div>
                
                
           
         
            
             
            
         
        
       
    </body>
</html>

