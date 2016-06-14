<?php
$parameter;
$value;
function replace_a_line($data) {
    global $parameter;
    global $value;
   if (stristr($data, $parameter)) {
     return $parameter.":".$value."\n";
   }
   return $data;
}



function getConfig($parameter)
{
    $file = fopen('appconfig','r') or die ("Pogreška kod otvaranja datoteke");
    $return= '';
    while(!feof($file))
    {
        $row = fgets($file);
        if(strpos($row,'//')===false)
        {
            $row = explode(":",$row);
            
            if(strpos($row[0],$parameter)!==false)
                    $return = $row[1];
        }
    }
    fclose($file);
    return $return;
}


function setConfig($par,$val)
{
    global $parameter;
    global $value;
    $parameter = $par;
    $value = $val;
    $data = file('appconfig'); // reads an array of lines
    $data = array_map('replace_a_line',$data);
    file_put_contents('appconfig', implode('', $data));
    return 1;
}

if(isset($_POST["parameter"]))
{
    $parameter = $_POST["parameter"];
    echo getConfig($parameter);
}

