const DIR_SERV = "http://localhost/PHP/Tema5/Actividad1y2_SW/Ejercicio1/servicios_rest_ejer1/";

$(document).ready(function () {
    obtener_productos();
});

function obtener_productos() {
    $.ajax({
        url: DIR_SERV + "/productos",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#respuesta').html(data.mensaje_error);
            }
            else {
                var html_output = "<table class='centrado'><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th><th><button class='enlace'>Productos+</button></th></tr>";
                $.each(data.productos, function (key, tupla) {
                    html_output += "<tr>";
                    html_output += "<td><button class='enlace' onclick='listar(\"" + tupla["cod"] + "\")'>" + tupla["cod"] + "</button></td>";
                    html_output += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_output += "<td>" + tupla["PVP"] + "</td>";
                    html_output += "<td><button class='enlace' onclick='confirmar_borrar(\"" + tupla["cod"] + "\")'>Borrar</button> - <button class='enlace'>Editar</button></td>";
                    html_output += "</tr>";
                });
                html_output += "</table>";
                $('#productos').html(html_output);
            }
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
        });
}

function confirmar_borrar(cod) {
    output = "<p class='centrado'>Se dispone ustes a borrar el producto: " + cod + "</p>";
    output += "<p class='centrado'>¿Estás seguro?</p>";
    output += "<p class='centrado'><button onclick='volver()'>Volver</button> <button onclick='borrar(\"" + cod + "\")'>Continuar</button></p>";
    $('#respuesta').html(output);
}

function borar(cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/borrar/" + cod),
        type: "DELETE",
        dataType: "json"
    })
        .done(function (data) {
            var output;
            if (data.mensaje_error) {
                output = data.mensaje_error;
            }
            else {
                output = "<p class='centrado'>El producto con cod: <strong>" + cod + "</strong> ha sido borrado con éxito</p>";
                obtener_productos();
            }
            $('#respuesta').html(output);
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
        });
}

function listar(cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            var output;
            if (data.mensaje_error) {
                output = data.mensaje_error;
                $('#respuesta').html(output);
            } else if (data.producto) {

                $.ajax({
                    url: encodeURI(DIR_SERV + "/familia/" + data.producto["familia"]),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data2) {
                        if (data2.mensaje_error) {
                            output = data2.mensaje_error
                        }
                        else {
                            output = "<h2>Información del producto: " + cod + "</h2>";
                            output += "<p><strong>Nombre: </strong>"
                            if (data.producto["nombre"]) {
                                output += data.producto["nombre"];
                            }
                            output += "<p><strong>Nombre corto: </strong>" + data.producto["nombre_corto"] + "</p>";
                            output += "<p><strong>Descripción: </strong>" + data.producto["descripcion"] + "</p>";
                            output += "<p><strong>PVP: </strong>" + data.producto["PVP"] + "€</p>";
                            output += "<p><strong>Familia: </strong>" + data.producto["familia"] + "</p>";
                            output += "<p><strong>Familia: </strong>" + data2.familia["nombre"] + "</p>";
                            output += "<p><button onclick='volver()'>Volver</button></p>";
                        }
                        $('#respuesta').html(output);
                    })
                    .fail(function (a, b) {
                        $('#respuesta').html(error_ajax_jquery(a, b));
                    });
            } else {
                output = "<p>El producto con cod <strong>" + cod + "</strong> ya no se encuentra en la BBDD.</p>";
                obtener_productos();
            }
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
        });
}

volver = () => {
    $('#respuesta').html("");
}

function error_ajax_jquery(jqXHR, textStatus) {
    var respuesta;
    if (jqXHR.status === 0) {
        respuesta = 'Not connect: Verify Network.';
    } else if (jqXHR.status == 404) {
        respuesta = 'Requested page not found [404]';
    } else if (jqXHR.status == 500) {
        respuesta = 'Internal Server Error [500].';
    } else if (textStatus === 'parsererror') {
        respuesta = 'Requested JSON parse failed.';
    } else if (textStatus === 'timeout') {
        respuesta = 'Time out error.';
    } else if (textStatus === 'abort') {
        respuesta = 'Ajax request aborted.';
    } else {
        respuesta = 'Uncaught Error: ' + jqXHR.responseText;
    }
    return respuesta;
}