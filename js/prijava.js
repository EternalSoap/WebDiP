/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function (){
    window.error = 0;
    $lista = $(":input");
    $ime = $("#korime");
    $pass = $("#lozinka");
    $zapamti = $("#zapamti");
    
    var val = readCookie('korime');
    if(val !==null)
    {
        $ime.val(val);
    }
    
    $lista.each(function(){$(this).removeClass("error");});
    
    $("#form1").submit(function(event){
    
    
    if(uneseno($ime) === false)
    {
        $("#errorDiv").text("Unesite korisnicko ime");
        window.error = 1;
    }
    else
    {
        $("#errorDiv").text("");
    }
    
    if(uneseno($pass) === false)
    {
        $("#errorDiv").text("Unesite lozinku");
        window.error = 1;
    }
    else
    {
        $("#errorDiv").text("");
    }
    
    
    
    if(window.error)
    {
        return false;
    }
    else
    {
        return true;
    }
    
    
});

  
    
    });
    
    
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}





function uneseno(object)
{
    if(object.val() === "" || object.val() === null)
    
    {
        object.addClass("error");
        return false;
    }
    
}
function setCookie(name,value,expiresDays)
{
    var date = new Date();
    date.setTime(date.setTime()+(expiresDays*24*60*60*1000));
    var expires = "expires:"+date.toUTCString();
    document.cookie = name+ "="+value+"; "+expires;
}

function getCookie(name)
{
    name = name + "=";
    var cookieArray = document.cookie.split(";");
    for(var i =0;i<cookieArray.length; i++)
    {
        var cookie  = cookieArray[i];
        while(cookie.charAt(0)==' ')
        {
            cookie = cookie.substring(1);
        }
        if(cookie.indexOf(name) == 0)
        {
            return cookie.substring(name.length,cookie.length);
        }
    }
    return '';
}


