<?php
include 'UserTypeCheck.php';



if(isset($_POST['func']))
{
    
    $func = $_POST['func'];
    if($func ==='getUserType')
    {
        session_start();
        if(isset($_SESSION['UserType']))
        {
            $userType = $_SESSION['UserType'];
            echo json_encode($userType);
        }
        else
        {
            echo json_encode('0');
        }
    }
    
}