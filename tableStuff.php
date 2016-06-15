<?php

header('Content-type: text/html; charset=utf-8');
include 'baza_class.php';
include 'fileStuff.php';

//order je ime stupca po kojem se sortira, sort je 0(asc) ili 1(desc)
function getTableData($query,$numItems,$order,$sort,$search,$first)
{
    $db = new DataBase();
    $db->dbConnect();
    $query.=" order by ".$order . " ".($sort==1?'desc':'asc').";";
    
    
    
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
    $db->dbDisconnect();
    
    $num = $result->num_rows/$numItems;
    echo ($num > intval($num))?intval($num)+1:intval($num);
    
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
}



