$(document).ready(function(){
    
    $.ajax({
    url:'./odjava.php',
    type:'post',
    dataType:'json',
    data:{'func':'display'},
    
    success:
            function($data)
    {
        display($data);
    },
    error:
            function($exception)
    {
        return false;
    }
});

function display($data)
{
    if($data[0] == 1)
    {
        //create logout element
        $div = $("#PRSwitch");
        
        $logout = $('<a>Odjava</a>').attr({href:'./odjava.php?func=logout',class : 'linkMain'});
       
        $div.append($logout);
        
    }
    else
    {
        $div = $("#PRSwitch");
        $login = $('<a>Prijava</a>').attr({href:'./index.php',class:'linkMain'});
        $register = $('<a>Registracija</a>').attr({href: './registracija.php',class:'linkMain'});
        
        $div.append($login);
        $div.append($register);
        
    }
}
    
    
});



