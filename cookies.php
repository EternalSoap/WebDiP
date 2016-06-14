<?php

//vrijeme u danima
function set($name, $value, $time)
{
    
    $Legittime = time() + $time*60*60*24;
    setCookie($name, $value, $Legittime);
    
}

function remove($name)
{
    setCookie($name, 'rip', 1);
}

function check($name)
{
    if($_COOKIE["$name"] == '') return false;
}