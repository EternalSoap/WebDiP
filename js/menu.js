$ustanova = $('<p>Ustanove</p><br>').attr({class:'navButton'}).on('click',{func:'ustanova'},contentSwap);
$statistika = $('<p>Statistika</p><br>').attr({class:'navButton'}).on('click',{func:'statistika'},contentSwap);
$CRUD = $('<p>CRUD</p><br>').attr({class:'navButton'}).on('click',{func:'crud'},contentSwap);
$rezervacija = $('<p>Rezervacija</p><br>').attr({class:'navButton'}).on('click',{func:'rezervacija'},contentSwap);
$racuni = $('<p>Računi</p><br>').attr({class:'navButton'}).on('click',{func:'racun'},contentSwap);
$zalbe = $('<p>Žalbe</p><br>').attr({class:'navButton'}).on('click',{func:'zalba'},contentSwap);
$adminPanel = $('<p>Admin Panel</p><br>').attr({class:'navButton'}).on('click',{func:'adminpanel'},contentSwap);

array_admin = [$ustanova,$statistika,$CRUD,$rezervacija,$racuni,$zalbe,$adminPanel];
array_mod = [$ustanova,$statistika,$rezervacija,$racuni,$zalbe];
array_usr = [$ustanova,$rezervacija,$racuni,$zalbe];
array_nonusr = [$ustanova];

function contentSwap(event)
{          
    $content = $('#divGlavna');
    $content.empty();
    switch(event.data.func)
    {
        case 'ustanova':
            
            $content.load('./ustanova.php');
            
            break;
        case 'statistika' : 
            
             $content.load('./statistika.php');
            
            break;
        case 'crud' : 
            
             $content.load('./crud.php');
            
            break;
        case 'rezervacija':
            
             $content.load('./rezervacija.php');
            
            break;
        case 'racun' : 
            
             $content.load('./racun.php');
            
            break;
        case 'zalba':
            
             $content.load('./zalba.php');
            
            break;
        case 'adminpanel':
            
             $content.load('./AdminPanel.php');
            
            break;
    }
        
        
}

function generateRegistrirani()
{
    
    $nav = $('#nav');
    $nav.empty();
    $.each(array_usr,function(nekibroj,item){
        
        $nav.append(item);
        
    });
    
}

function generateNonReg()
{
    
    $nav = $('#nav');
    $nav.empty();
    $.each(array_nonusr,function(nekibroj,item){
        
        $nav.append(item);
        
    });
    
}

function generateModerator()
{
    
    $nav = $('#nav');
    $nav.empty();
    $.each(array_mod,function(nekibroj,item){
        
        $nav.append(item);
        
    });
    
}

function generateAdministrator()
{
    $nav = $('#nav');
    $nav.empty();
    $.each(array_admin,function(nekibroj,item){
        
        $nav.append(item);
        
    });
}
function generateMenu(userType)
{
    userType = $.parseJSON(userType);
    console.log(userType);
    switch(userType)
    {
        case '1':
        
            generateRegistrirani();
            break;
        
        case '2': 
        
            generateModerator();
            break;
        
        case '3':
        
            generateAdministrator();
            break;
        
        default:
            generateNonReg();
            break;
        
    }
}

function getUserType(callback)
{
    $.ajax({
        url : './menu.php',
        type : 'post',
        datatype:'json',
        data :{func:'getUserType'},
        success: function(data)
        {
            
            callback(data);
            
        },
        error: function(exception)
        {
            
            console.log("Error "+ exception);
            
        }
    });
}



$(document).ready(function(){
    
    getUserType(generateMenu);
        
});

