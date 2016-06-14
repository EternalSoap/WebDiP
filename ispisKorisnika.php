<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header('Content-type: text/html; charset=utf-8');
include 'baza_class.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $broj = $_POST["broj"];
    
    
    
    
    function generateTable($pocetak,$broj)
    {
        $db = new DataBase();

        $db->dbConnect();

        $query = "select * from Korisnik ";

        $result = $db->dbSelect($query);

        $db->dbDisconnect();  

        $assocResult = [];

        while($row = $result->fetch_assoc())
        {   
            array_push($assocResult, $row);
        }
        echo json_encode($assocResult);
/*   
        $arrayHeader = [];
    
        $row = reset($assocResult);
        foreach($row as $key=>$value)
        {
          array_push($arrayHeader,$key);
        }
        
        $table = "<table border='1'><tr>";
        foreach ($arrayHeader as $value)
        {
            $table .="<th>".$value."</th>";
        }
        $table .="</tr>";
        for($i=$pocetak;$i<$pocetak+$broj;$i++)
        {
            if(isset($assocResult[$i]))
            {
            $row = $assocResult[$i];
            $table.="<tr>";
            foreach ($row as $value)
            {
                $table.="<td>".$value."</td>";
            }
            $table .="</tr>";
        }
        }
        
        echo $table;
        for($i=0;$i<count($assocResult)/$broj;$i++)
        {
            echo $i+1 . " ";
        }
     */
 
    }
    //generateTable(0,$broj);
    //exit();
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
        <link href="fragoldne_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="fragoldne_mobiteli.css" rel="stylesheet" type="text/css" media="screen">
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
       
        
        
        
        <div class="divContent" id="divIspis">
            
            
                <p><label class="labelReg" for="search">Pretraži: </label>
                <input class="inputReg" type="text" id="search" name="search" placeholder="Korisničko ime" autofocus="autofocus" required="required">                             
                <label class="labelReg" for="noItems">Broj podataka: </label>
                    <select class="inputReg" name="noItems" id="noItems" placeholder="Broj podataka">
                    
                        
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        
                                        
                        
                    </select>
                <input type="button" id ="refresh" name="refresh" onclick="refresh()" value="Osvježi">
                <span id="tableThings"></span>
                <span id="menuThings"></span>
            </div>
                
                
                
  
           
            
            
             
                </div>
         
        
        <footer>
             
        </footer> 
    </body>
</html>
