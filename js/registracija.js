$(document).ready(function() {
    window.error = 0;
   
$("#korime").focusout( function (){
    
      $.ajax({
            url:"./UserNameCheck.php",
            type:"POST",
            dataType:"json",
            data:{"korime":$("#korime").val()},
            success:
                    function(data){
                        if(data!=='0')
                        {
                        $("#divKorime").text("Korisnicko ime postoji");
                        $("#korime").addClass("error");
                        }
                        else
                        {
                            $("#divKorime").text("");
                        }
                       
                        
                        }
        });
 
    
    
});


$(":input").focusin(function() {
    
    $(this).addClass("selected");
    
});

$(":input").focusout(function(){
    
    $(this).removeClass("selected");
    $(this).removeClass("error");
    
});

$("#form2").submit(function(event){
    
    window.error = 0;
    $ime = $("#ime");
    $prezime = $("#prez");
    $korime = $("#korime");
    $pass = $("#lozinka1");
    $pPass = $("#lozinka2");
    $dan = $("#dan");
    $mjesec = $("#mjesec");
    $godina = $("#godina");
    $email = $("#email");
    $robot = $("#robot");
    $adresa = $("#adresa");
    $broj = $("#broj");
    $grad = $("#grad");
    
    
    
    
    
    $korimePatt = /^[A-Z,a-z,0-9,_]{1,}$/;
    $passPatt = /^[A-Z,a-z,0-9,_]{1,}$/;
    $emailPatt = /^\w{2,}\.\w{2,}@\w{2,}\.\w{2,}$/;
    $lista = $(":input");
    
    
    
    $lista.each(function(){$(this).removeClass("error")});
    
    
    if(uneseno($ime) ===false)
    {
        $("#divIme").text("Ime nije uneseno");
        window.error = 1;
    }
    else
    {
        $("#divIme").text("");
    }
   
    if(uneseno($prezime) === false)
    {
        $("#divPrez").text("Prezime nije uneseno");
        window.error = 1;
    }
    else
    {
        $("#divPrez").text("");
    }
    if(uneseno($korime) === false || $korimePatt.test($korime.val()) ===false)
    {
        $("#divKorime").text("Pogresno korisnicko ime");
    }
    else
    {
        $("#divKorime").text("")
    }
    
    if(uneseno($pass) ===false || $passPatt.test($pass.val())===false)
    {
        $("#divPass").text("Pogresna lozinka");
        window.error = 1;
    }
    else
    {
        $("#divPass").text("");
    }
    
    if(uneseno($pPass) ===false)
    {
        $("#divPonovljena").text("Ponovno unesite lozinku");
        window.error = 1;
    }
    else
    {
        $("#divPonovljena").text("");
    }
    
    if(isSame($pass,$pPass) ===false)
    {
        $("#divPonovljena").text("Loznike nisu iste");
        window.error = 1;
    }
    else
    {
        $("#divPonovljena").text("");
    }
    
    
      
   if(uneseno($dan) ===false || $dan.val()<1 )
   {
       $("#divDan").text("Pogresno unesen dan");
       window.error = 1;
   }
   else
   {
       $("#divDan").text("");
   }
   if(uneseno($mjesec) ===false)
   {
       $("#divMjesec").text("Pogresno unesen mjesec");
       window.error = 1;
   }
   else
   {
       $("#divMjesec").text("");
   }
   
   
   if(uneseno($godina) ===false || $godina.val() > 2015 || $godina.val() < 1930)
   {
       $("#divGodina").text("Pogresno unesena godina");
       window.error = 1;
   }
   else
   {
       $("#divGodina").text("");
   }
   
   if(uneseno($email) ===false || $emailPatt.test($email.val()) === false)
   {
       $("#divEmail").text("Pogresno upisan email");
       window.error = 1;
   }
   else
   {
       $("#divEmail").text("");
   }
   
   if(uneseno($adresa)===false)
   {
       $("#divAdresa").text("Unesite adresu");
       window.error = 1;
   }
   else
   {
       $("#divAdresa").text("");
   }
   
   if(uneseno($grad)===false)
   {
       $("#divGrad").text("Unesite grad");
       window.error = 1;
   }
   else
   {
       $("#divGrad").text("");
   }
   
   if(uneseno($broj))
   {
       $("#divBroj").text("Unesite poštanski broj");
       window.error = 1;
   }
   else
   {
       $("#divBroj").text("");
   }
  
    if(grecaptcha.getResponse() === "")
    {
      $("#divRobot").text("Roboti se ne mogu registrirati");
      window.error =1;
      
    }
    else
    {
       $("#divRobot").text("");
    }
     if(window.error === 1)
     {
         grecaptcha.reset();
         return false;
     }
     else
     {
         return true;
     }
});

});

function uneseno(object)
{
    if(object.val() === "" || object.val() === null)
    
    {
        object.addClass("error");
        return false;
    }
    
}

function isSame(object,object2)
{
    if(object.val() !== object2.val())
    {
        object.addClass("error");
        object2.addClass("error");
        return false;
    }
}
