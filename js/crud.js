function dynamicSelector ($element,table,column)
{
    
    var query = 'select * from '+table;
    
    $.ajax({
        url:'./tableStuff.php',
        type:'post',
        dataType:'json',
        data:{func:'genericSelect',query:query},
        success:
                function(data)
        {
                
                $.each(data,function(i,row){
                    
                    $element.append($('<option value="'+row['id'+table]+'">'+row[column]+'</option>'));
                    
                });
                    
        },
        error:
                function(){}
        
    });
}


function zapisi($form,table,func)
{
    var values = {};
    $.each($form.serializeArray(),function(i,field){
        
        if(field.value==='' || field.value ===null) return;
        values[field.name] = field.value;
        });
        $.ajax({
            url:'./tableStuff.php',
            type:'post',
            dataType:'json',
            
            data:{
                func:func,
                table:table,
                data: values
            },
            success:function(data)
            {
                if(data === '1')
                {
                    $($form).append($("<p>Uspješno dodano</p>").attr({class :'greenP'}).fadeIn(100).fadeOut(2000));
                    
                }
            },
            error:function(exception){}
            
            
            
        });
        
    
}



$(document).ready(function(){
    
    dynamicSelector($('#selectUstanova'),'Ustanova','Naziv');
    dynamicSelector($('#selectKorisnik'),'Korisnik','KorisnickoIme');
    
    $('#frmKreirajUstanovu').submit(function(event){
        event.preventDefault();
        
        zapisi($('#frmKreirajUstanovu'),'Ustanova','insert');
        
        
    });
    
    
    
    $('#frmDodajModeratora').submit(function(event){
        
        event.preventDefault();
        var query = "insert into Korisnik_has_Ustanova values("+$('#selectKorisnik').val()+","+$('#selectUstanova').val()+");";
        
       
         $.ajax({
            url:'./tableStuff.php',
            type:'post',
            dataType:'json',
            data:{query:query,
                    func : 'genericInsert'},
              success:function(data)
              {
                  
                    $($('#frmDodajModeratora')).append($("<p>Uspješno dodano</p>").attr({class :'greenP'}).fadeIn(100).fadeOut(2000));
                    
                
              },
              error:function(exception)
              {
                  console.log('exception' + exception);
              }
              
        });
        
        
        $.ajax({
            url:'./tableStuff.php',
            type:'post',
            dataType:'json',
            data:{id:$('#selectKorisnik').val(),
                  data:'2',
                  table:'Korisnik',
                  column:'TipKorisnika_idTipKorisnika',
                    func : 'update'},
              success:function(data)
              {
                  
                    $($('#frmDodajModeratora')).append($("<p>Uspješno dodano</p>").attr({class :'greenP'}).fadeIn(100).fadeOut(2000));
                    
                
              },
              error:function(exception)
              {
                  console.log('exception' + exception);
              }
              
        });
        
        
    });
    
});