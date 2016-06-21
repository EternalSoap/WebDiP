
$array = {};

function rePage(event){
    var sort = 0;
    var order = '1';
    $.each($array,function(key,value)
    {
        if(value === 1)
        {
            order = key;
            sort = value;
        }
    });
    
    
    
    
    var numItems = $("#noItems").val();
    
    
    
    var search = '';
    var first = event.data.page * numItems;
    
    getData(window.query,numItems,order,sort,search,first,generateTable);
    getNumRows(window.table,numItems,generatePaging);
    
}

function generatePaging($data)
{
    var numOfPages = $data;
    
    $('#menuThings').empty();
    
    for(var i=0;i<numOfPages; i++)
    {
        
        $('#menuThings').append('&nbsp;').append($('<a>'+(i+1)+'</a>').attr({class : 'link'}).on('click',{page:i},rePage)).append('&nbsp;');
    }
    
}



function reSort(event)
{
     if(typeof event != 'undefined'){
     
     var header = event.data.header;
     
     if($array[header] ===0)
     {
         $array[header] = 1;
     }
     else
     {
         $array[header] = 0;
     }
 }
 else
 {
     header = 1;
 }
     
     
     
     
    var query = 'select * from Korisnik';
    var numItems = $("#noItems").val();
    
    var order = header;
    var sort = (header ===1)?1:$array[header];
    var search = $("#search").val();
    var first = 0;
     
    getData(window.query,numItems,order,sort,search,first,generateTable);
    getNumRows(window.table,numItems,generatePaging);
    
}



function generateTable($data)
{
    $span = $("#tableThings");
    $table = $("<table></table>").attr({border : "1"});
    $row = $("<tr></tr>");
    $data = $.parseJSON($data);
    
    
    if(typeof $data[0] !='undefined')
    {
    $.each($data[0],function(header){
        
        
        
        
        $header = $("<th>"+header+"</th>").attr({name:'0'});  
        //sve cu vas pobjedit
        $header.on('click',{header : header},reSort);
        //won
        $row.append($header);
       
        
    });
    
    
    
    $table.append($row);
    
    $.each($data,function(nekibroj,$jsons){
        //ne znam zasto je tu nekibroj
        $row = $('<tr></tr>');
        $.each($jsons,function(header,values){
            //headere imam vec
            $td = $('<td>'+values+'</td>');
            $row.append($td);
            
        });
        $table.append($row);
        
    });
        
    }    
                
    
    $span.empty();
    $span.append($table);
}


function getData(query,numItems,order,sort,search,first,$callback)
{
    
    
    
    $.ajax({
        url:'../tableStuff.php',
        type: 'post',
        datatype: 'json',
        data:{func:'getTableData',
             query:query,
              numItems:numItems,
               order:order,
                sort:sort,
                search:search,
                first:first},
        success:
                function($data)
        {
            
            $callback($data);
            
            
          
          
        }  
        ,error:
                function($exception){
                    console.log($exception);
                }
          
    }
            
            
            );
    
}

function getNumRows(table,numItems,$callback)
{
    $.ajax({
        url:'../tableStuff.php',
        type: 'post',
        datatype:'json',
        data:{func:'getNumRows',
            table:table,
            numItems:numItems},
        success: function($data){
            
            $callback($data);
            
        },
        error:function($exception){console.log($exception);}
        
        
    });
}



$(document).ready(function(){
     
     
    window.query = 'select * from Korisnik';
    window.table = 'Korisnik';
    
    var numItems = $("#noItems").val();
    
    var order = '1';
    var sort = 0;
    var search = '';
    var first = 0;
    
    
    
    $.ajax({
        url:'../tableStuff.php',
        type: 'post',
        datatype: 'json',
        data:{func:'getTableData',
             query:window.query,
              numItems:numItems,
               order:order,
                sort:sort,
                search:search,
                first:first},
        success:
                function($data)
        {
            $data = $.parseJSON($data);
            
            $.each($data[0],function(header){
        
        
        $array[header] = 0;
     
    });         
        }  
        ,error:
                function($exception){
                    console.log($exception);
                }
          
    });
    
     
    
    
    getData(window.query,numItems,order,sort,search,first,generateTable);
    getNumRows(window.table,numItems,generatePaging);
    
});