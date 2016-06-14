$(document).ready(function() {
    
   
$("#korime").focusout( function (){
    
      $.ajax({
            url:"./UserNameCheck.php",
            type:"POST",
            dataType:"json",
            data:{"korime":$("#korime").val()},
            success:
                    function(data){
                        if(data==='0')
                        {
                        return false;
                        }
                        else
                        {
                            return true;
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
    
    
    $ime = $("#ime");
    $prezime = $("#prez");
    $korime = $("#korime");
    $pass = $("#lozinka1");
    $pPass = $("#loznika2");
    $dan = $("#dan");
    $mjesec = $("#mjesec");
    $godina = $("#godina");
    $email = $("#email");
    $robot = $("#robot");
    $adresa = $("#adresa");
    $broj = $("#broj");
    $drzava = $("#drzava");
    $captcha = $("captcha");
   
    $korimePatt = /^[A-Z,a-z,0-9]{1,}$/;
    $passPatt = /^[A-Z,a-z,0-9]{1,}$/;
    $emailPatt = /^\w{2,}\.\w{2,}@\w{2,}\.\w{2,}$/;
    $lista = $(":input");
    
    
    
    $lista.each(function(){$(this).removeClass("error")});
    
    
    if(uneseno($ime) ===false)
    {
        $("#divIme").text("Ime nije uneseno");
    }
    if(uneseno($prezime) === false)
    {
        $("#divPrez").text("Prezime nije uneseno");
    }
    if(uneseno($korime) === false || $korimePatt.test($korime.val()) ===false)
    {
        $("#divKorime").text("Pogresno korisnicko ime");
    }
    
    if(uneseno($pass) ===false || $passPatt.test($pass.val())===false)
    {
        $("#divPass").text("Pogresna lozinka");
    }
    
    if(isSame($pass,$pPass) ===false)
    {
        $("#divPonovljena").text("Loznike nisu iste");
    }
    
   if(uneseno($dan) ===false || $dan.val()<1 )
   {
       $("#divDan").text("Pogresno unesen dan");
   }
   if(uneseno($mjesec) ===false)
   {
       $("#divMjesec").text("Pogresno unesen mjesec");
   }
   if(uneseno($godina) ===false || $godina.val() > 2015 || $godina.val() < 1930)
   {
       $("#divGodina").text("Pogresno unesena godina");
   }
   
   if(uneseno($email) ===false || $emailPatt.test($email.val()) === false)
   {
       $("#divEmail").text("Pogresno upisan email");
   }
  
  var captcha = captcha.getResponse();
    if(captcha === "") {
        $("#divRobot").text("Roboti se ne mogu registrirati");
    }
      
    event.preventDefault();
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
    if(object.val() === object2.val())
    {
        object.addClass("error");
        object2.addClass("error");
        return false;
    }
}
function korisnikPostoji(object)
{
    
}