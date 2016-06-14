<?php

function display()
{
    if(isLoggedIn())
    {
        return "1";
    }
    else
    {
        return "0";
    }
}


function isLoggedIn()
{
    session_start();
    if(isset($_SESSION['UserType']) == false)
        return false;
    if($_SESSION['UserType'] == '')
        return false;
    return true;
}


if(isset($_POST["func"]))
{
    $func = $_POST["func"];
    if($func === "display")
    {
        echo json_encode(display());
    }
}

if(isset($_GET["func"]))
{
    $func = $_GET["func"];
    if($func = 'logout')
    {
        session_start();
        $_SESSION['UserType']='';
        
        session_unset();
        session_destroy();
        header('Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x023/glavna.php');
        exit();
    }
}
?>
