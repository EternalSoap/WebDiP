<?php

?>
<html>
    <head>
        <title>Admin Panel</title>
        <meta name="author" content="Fran Goldner">
        <meta name="description" content="Početna stranica">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/fragoldne.css" rel="stylesheet" type="text/css" media="screen">
        <link href="fragoldne_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="fragoldne_mobiteli.css" rel="stylesheet" type="text/css" media="screen">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>    
        <script type="text/javascript" src="./js/pomak.js"></script>
        <script type="text/javascript" src="./js/odjava.js"></script>
    </head>
    <body>
        <header>
            
            <h1 class="h1Header">Admin Panel</h1>
            <br/> 
            <div id="PRSwitch" class="PRSwitch">
                
            </div>
           
        </header>
       
        
        
        
        <div class="divContent" >
            
            <form id="form1" method="post" name="form1" action="AdminPanel.php" novalidate="">
               
                <fieldset>
                    <label>Postavi virtualno vrijeme</label>
                    <br>
                    <a href="http://barka.foi.hr/WebDiP/pomak_vremena/vrijeme.html" target="_blank">Postavi pomak vremena</a><br>
                    <label>Broj sati</label><label id="brojSati" name="brojSati"></label><br><br>
                     <input type="radio" name="vv" value="1" checked="checked"> Ukljuceno<br>
                     <input type="radio" name="vv" value="0"> Iskljuceno<br>
                     <input  type="button" value="Pohrani virtualno vrijeme" id="pohraniVV" name="pohraniVV">
                     <div id="divSucc" name="divSucc"></div>
                    
                </fieldset>
                
            </form>
            
             
                </div>
         
        
        <footer>
             
        </footer> 
    </body>
</html>
