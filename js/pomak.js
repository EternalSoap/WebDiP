$(document).ready(function(){
    
    $.ajax({
        url:'VirtualnoVrijeme.php',
        type:'post',
        dataType:'json',
        data:{func:'get'},
        success:
                function($data)
        {
            
            $("#brojSati").text($data[1]);
            
        },
        error:
                function($exception)
        {
            console.log("Error"+$exception);
        }
        
    });
    
    
    
    $("#pohraniVV").click(function(){
        
        
        $.ajax({
            url:'VirtualnoVrijeme.php',
            type:'post',
            dataType:'json',
            data:{func:'store',
                  used:$('input[name=vv]:checked').val()},
            
            success:
                    function($data)
            {
                if($data==='1')
                {
                    $("#divSucc").append($("<p>Vremenski pomak je pohranjen</p>").attr({class :'greenP'}).fadeIn(100).fadeOut(2000));
                    setTimeout(function(){
                        
                        $("#divSucc").empty();
                        
                    },2100);
                }
            },
            error:
                    function($exception)
            {
                console.log("error "+$exception);
            }
            
            
        });
        setTimeout(function(){
            
            $.ajax({
        url:'VirtualnoVrijeme.php',
        type:'post',
        dataType:'json',
        data:{func:'get'},
        success:
                function($data)
        {
            
            $("#brojSati").text($data[1]);
            
        },
        error:
                function($exception)
        {
            console.log("Error"+$exception);
        }
        
    });
            
            
        },5000);
        
         
        
    });
    
    
});
