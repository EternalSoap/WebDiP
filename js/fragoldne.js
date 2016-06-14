var sub;
window.onload = function () {
    sub = document.getElementById("submit1");
    sub.addEventListener("click", function (event) {
        var korime = document.getElementById("korime");
        var lozinka = document.getElementById("lozinka");
        var errorDiv = document.getElementById("error");
       
        
        
        
        
        errorDiv.innerHTML = "";
        // makni sve errore kad se page loada, da se ne pokazuju oni od prije
        removeError([korime,lozinka]);
      
        if(korime!==null)
        if (korisnickoIme(korime) === false)
        {
            event.preventDefault();
            errorDiv.innerHTML += "Pogrešno korisničko ime <br>";
           
            
        }
        if(lozinka!==null)
        if(pw(lozinka) === false)
        {
            
            event.preventDefault();
            errorDiv.innerHTML += "Pogrešna lozinka<br>";
           
            
        }
      
        
        
    });
};

function isSame(object,object2)
{
    if(object.value === object2.value) return true;
    return false;
}

function jeBroj(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}


function NN(objects)
{
    for (var element in objects)
    { if (objects[element].value === null || objects[element].value === "")
        {
            return false;
        }
    }
    return true;
}

function korisnickoIme(object)
{
    var korimePatt = new RegExp("^[A-Z,a-z,0-9]{1,}$");
    if(NN([object]) === false) return false;
    return korimePatt.test(object.value);

}

function pw(object)
{
    if(NN([object]) ===false) return false;
    if(object.value.length <8) return false;
    if(object.type !=="password") return false;
    var lozinkaPatt = new RegExp("^[A-Z,a-z,0-9]{1,}$");
    return lozinkaPatt.test(object.value);
    
}


 function removeError(object)
 {
     for(var element in object)
     {
        object[element].style.backgroundColor ="white";
     }
 }

