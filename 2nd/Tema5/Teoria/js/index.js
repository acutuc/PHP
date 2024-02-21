const DIR_SERV = "http://localhost/PHP/Tema5/Intro/servicios_rest";

$(document).ready(function(){
    obtener_productos();
 });


function obtener_productos()
{

    $.ajax({
        url:"http://localhost/PHP/Tema5/Actividad1y2_SW/Ejercicio1/servicios_rest_ejer1/productos",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#respuesta').html(data.mensaje_error);
        }
        else
        {
            var html_output="<table><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th></tr>";
            $.each(data.productos, function(key, tupla){
                html_output+="<tr>";
                html_output+="<td>"+tupla["cod"]+"</td>";
                html_output+="<td>"+tupla["nombre_corto"]+"</td>";
                html_output+="<td>"+tupla["PVP"]+"</td>";
                html_output+="</tr>";
            });
            html_output+="</table>";
            $('#productos').html(html_output);
        }
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
}

function llamada_get()
{
    $.ajax({
        url:DIR_SERV+"/saludo",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        $('#respuesta').html(data.mensaje);
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
    
}

function llamada_post()
{
    $.ajax({
        url:DIR_SERV+"/saludo",
        type:"POST",
        dataType:"json",
        data:{datos1:"Pedro", datos2:"María José"}
    })
    .done(function(data){
        $('#respuesta').html(data.mensaje);
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
    
}

function llamada_delete()
{
    $.ajax({
        url:encodeURI(DIR_SERV+"/borrar_saludo/5"),
        type:"DELETE",
        dataType:"json"
    })
    .done(function(data){
        $('#respuesta').html(data.mensaje);
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
    
}

function llamada_put1()
{
    $.ajax({
        url:encodeURI(DIR_SERV+"/modificar_saludo/5/José María"),
        type:"PUT",
        dataType:"json"
    })
    .done(function(data){
        $('#respuesta').html(data.mensaje);
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
    
}

function llamada_put2()
{
    $.ajax({
        url:encodeURI(DIR_SERV+"/modificar_saludo/5"),
        type:"PUT",
        dataType:"json",
        data:{saludo_nuevo:"Cristina"}
    })
    .done(function(data){
        $('#respuesta').html(data.mensaje);
    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });
    
}

function error_ajax_jquery( jqXHR, textStatus) 
{
    var respuesta;
    if (jqXHR.status === 0) {
  
      respuesta='Not connect: Verify Network.';
  
    } else if (jqXHR.status == 404) {
  
      respuesta='Requested page not found [404]';
  
    } else if (jqXHR.status == 500) {
  
      respuesta='Internal Server Error [500].';
  
    } else if (textStatus === 'parsererror') {
  
      respuesta='Requested JSON parse failed.';
  
    } else if (textStatus === 'timeout') {
  
      respuesta='Time out error.';
  
    } else if (textStatus === 'abort') {
  
      respuesta='Ajax request aborted.';
  
    } else {
  
      respuesta='Uncaught Error: ' + jqXHR.responseText;
  
    }
    return respuesta;
}