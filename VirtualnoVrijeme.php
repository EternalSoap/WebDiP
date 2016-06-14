<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'fileStuff.php';

function dohvatiVrijeme()
{
    $json = file_get_contents("http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=json");
    $result = json_decode($json, true);
    $pomak = $result["WebDiP"]["vrijeme"]["pomak"]["brojSati"];
    
    return $pomak;
}

function get($value)
{
    return getConfig($value);
}

if(isset($_POST['func']))
{
    $function = $_POST['func'];
    if($function === 'store')
    {
        $time = dohvatiVrijeme();
        $used = $_POST['used'];
        
        $result1 = setConfig("shiftvalue", $time);
        $result2 = setConfig("shiftused",$used);
        
        if($result1===1 and $result2===1)
        {
            echo json_encode("1");
        }
        else
        {
            echo json_encode("0");
        }
        
    }
    if($function ==='get')
    {
        $used = getConfig('shiftused');
        $time = getConfig('shiftvalue');
        $return = [$used,$time];
        echo json_encode($return);
    }
   
}

