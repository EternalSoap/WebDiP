<?php

header('Content-type: text/html; charset=utf-8');
include 'baza_class.php';
include 'fileStuff.php';
include 'Dnevnik.php';

//order je ime stupca po kojem se sortira, sort je 0(asc) ili 1(desc)
function getTableData($query,$numItems,$order,$sort,$search,$first)
{
    $db = new DataBase();
    $db->dbConnect();
    $query.=" order by ".$order . " ".($sort==1?'desc':'asc').";";
    
    dnevnik($query,"Generiranje tablice");
    
    $result = $db->dbSelect($query);
    $numRows = $result->num_rows;
    if($numItems ==0)
    {
        $numItems = getConfig('numitems');
        if($numItems ==='')
        {
            $numItems = 10;
        }
    }
    $max = ($first + $numItems > $numRows)?$numRows:($first+$numItems);
    $returnArray = [];
    
    for($i=0;$i<$max;$i++)
    {
        
        if($i < $first)
        {
            $row = $result->fetch_assoc();
            continue;
        }
        else
        {
            $row = $result->fetch_assoc();
        }
        
        if($search !=='')
        {
            foreach($row as $val)
            {
                if(strpos(strtolower($val), strtolower($search))!==false)
                {
                    array_push($returnArray, $row);
                    break;
                }
            }
        }
        else
        {
            array_push($returnArray, $row);
        }
        
    }
    
    $db->dbDisconnect();
    
    echo json_encode($returnArray);
    
}

function getHeaders($table){
    $db = new DataBase();

    $query = 'show columns from '.$table;

    $db->dbConnect();
    $result = $db->dbSelect($query);
    $db->dbDisconnect();

    dnevnik($query,'Dohvaćanje zaglavlja');

    $result_array = [];


    while($row = mysqli_fetch_array($result))
    {
        array_push($result_array, $row[0]);
    }   

    echo json_encode($result_array);
    return $result_array;
}


function getNumRows($table,$numItems)
{
    if($numItems ==0)
    {
        $numItems = getConfig('numitems');
        if($numItems ==='')
        {
            $numItems = 10;
        }
    }
    $query = 'select * from '.$table.';';
    $db = new DataBase();
    $db->dbConnect();
    $result = $db->dbSelect($query);
    
    dnevnik($query,'Generiranje straničenja');
    
    $db->dbDisconnect();
    
    $num = $result->num_rows/$numItems;
    echo ($num > intval($num))?intval($num)+1:intval($num);
    
}

function getTables()
{
    $query = 'show tables';
    $db = new DataBase();
    $db ->dbConnect();
    $result = $db->dbSelect($query);
    $result_array = [];
    while($row = mysqli_fetch_array($result))
    {
        array_push($result_array,$row[0]);
    }
    dnevnik($query,'Dohvaćanje tablica');
    echo json_encode($result_array);
    
}


function delete($id,$table)
{   
    $query = "delete from ".$table." where id".$table." = ".$id." ;";
    $db = new DataBase();
    $db ->dbConnect();
    
    $result = $db->dbQuery($query);
    
    if($result)
    {
        $db ->dbDisconnect();
        dnevnik($query,'Brisanje uspješno');
        echo json_encode('1');
    }
    else
    {
        $db ->dbDisconnect();
        dnevnik($query,'Brisanje neuspješno');
        echo json_encode('0');
    }
}

function insert($table, $data_array)
{
    
    $query = "insert into ".$table." values (default,";
    
    $numVals = count($data_array);
    $currVal = 0;
    foreach($data_array as $data)
    {
        $currVal++;
        if($currVal == $numVals)
        {
            $query.="'".$data."'";
        }
        else
        {
            $query.="'".$data."',";
        }
        
    }
    $query.=");";
    echo $query;
    
    $db = new DataBase();
    $db ->dbConnect();
    $result = $db->dbQuery($query);
    
    if($result)
    {
        $db ->dbDisconnect();
        dnevnik($query,'Dodavanje uspješno');
        echo json_encode('1');
    }
    else
    {
        $db ->dbDisconnect();
        dnevnik($query,'Dodavanje neuspješno');
        echo json_encode('0');
    }
    
    
}

function update($id, $data,$table)
{
    $headers = getHeaders($table);
    $query = "update ".$table." set ";
    for($i=0;$i<count($headers)-1;$i++)
    {
        if($i+2 === count($headers))
        {
            $query.=$headers[$i+1]." = "."'".$data[$i]."'". " ";
        }
        else
        {
            $query.=$headers[$i+1]." = "."'".$data[$i]."'". ", ";
        }
       
        echo $headers[$i];
        echo $data[$i];
        
    }
    $query.="where id".$table." = '".$id."';";
    echo '<br>'.$query;
    $db = new DataBase();
    $db->dbConnect();
    $result = $db->dbQuery($query);
    
    if($result)
    {
        $db ->dbDisconnect();
        dnevnik($query,'Ažurianje uspješno');
        echo json_encode('1');
    }
    else
    {
        $db ->dbDisconnect();
        dnevnik($query,'Ažuriranje neuspješno');
        echo json_encode('0');
    }
    
}


function insertWeak(){}
function deleteWeak($table,$linkedTable1,$linkedTable2,$id1,$id2)
    {
        $query = "delete from $table where ".$linkedTable1."_id".$linkedTable1." = ".$id1. " and ".$linkedTable2."_id".$linkedTable2." = ".$id2.";";
        
        $db=new DataBase();
        $db->dbConnect();
        
        $result = $db->dbQuery($query);
        if($result)
    {
        $db ->dbDisconnect();
        dnevnik($query,'Brisanje uspješno');
        echo json_encode('1');
    }
    else
    {
        $db ->dbDisconnect();
        dnevnik($query,'Brisanje neuspješno');
        echo json_encode('0');
    }
        
    }

if(isset($_POST['func']))
{
    $func = $_POST['func'];
    if($func === 'getTableData')
    {
        
        getTableData($_POST['query'],$_POST['numItems'],$_POST['order'],$_POST['sort'],$_POST['search'],$_POST['first']);
        
    }
    if($func === 'getNumRows')
    {
        if(isset($_POST['table']) && isset($_POST['numItems']))
        {
            getNumRows($_POST['table'],$_POST['numItems']);
        }
    }
    if($func ==='getHeaders')
    {
        if(isset($_POST['table']))
        {
            getHeaders($_POST['table']);
        }
    }
    
    if($func==='insert')
    {
        if(isset($_POST['table']) && isset($_POST['data']))
        {
            insert($_POST['table'], $_POST['data']);
        }
    }
    if($func ==='update')
    {
        if(isset($_POST['table']) && isset($_POST['id']) && isset($_POST['data']))
        {
            update($_POST['id'], $_POST['data'], $_POST['table']);
        }
    }
    if($func ==='delete')
    {
        if(isset($_POST['table']) && isset($_POST['id']))
        {
            delete($_POST['id'],$_POST['table']);
        }
    }
    
    if($func ==='getTables')
    {
        getTables();
    }
    if($func ==='weakDelete')
    {
        if(isset($_POST['table']) && isset($_POST['linkedTable1']) && isset($_POST['linkedTable2']) && isset($_POST['id1']) && isset($_POST['id2']))
        {
            deleteWeak($_POST['table'],$_POST['linkedTable1'],$_POST['linkedTable2'],$_POST['id1'],$_POST['id2']);
        }
    }
    
}

