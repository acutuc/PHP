const DIR_SERV = "http://localhost/PHP/Tema5/Intro/servicios_rest";

llamada_get = () =>{
    $.ajax({
        url:DIR_SERV+"/saludo",
        type:"GET",
        dataType:"json"
    }) // <--- Aquí pasamos un JSON
    .done(function(data){ // Si tiene éxito:
        $("#respuesta").html(data.mensaje) // Accede al índice del json
    })
    .fail(function(a, b){ // Si falla:
        $("respuesta").html(error_ajax_jquery(a, b));
    })
}