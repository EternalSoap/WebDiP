function setCookie(name,value,expiresDays)
{
    var date = new Date()
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

function checkCookie()
{
    
    var user = getCookie("korime");
    alert(user);
    var div = document.getElementById("PRSwitch");
    var pr = document.createElement("p");
    if(user !="")
    {
        var text = document.createTextNode("testing");
        pr.appendChild(text);
        pr.onclick = logout();
        
        div.appendChild(pr);
        
              
        
    }
    else
    {
       var text = document.createTextNode("Testing2");
       pr.appendChild(text);
       pr.onclick = login();
       div.appendChild(pr);
    }
}

document.onload = checkCookie();