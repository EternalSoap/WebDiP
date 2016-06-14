
function refresh()
{
     $broj = $("#noItems").val();
     
     getData(1,$broj);
}



function getData($pocetak,$broj)
{
    
    $table = '';
    
    $.ajax({
        url:'./tableStuff.php',
        type: 'post',
        datatype: 'json',
        data:{func:'getTableData',
             query:'select * from Korisnik',
              numItems:'10',
               order:'KorisnickoIme',
                sort:'0',
                search:'',
                first:'0'},
        success:
                function($data)
        {
            
            $data = parseJSON($data);
            
            
          
          
        }  
        ,error:
                function($exception){
                    alert($exception);
                }
          
    }
            
            
            );
    
}


$(document).ready(function(){
    
    refresh();
    
});