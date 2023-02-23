const DIR_SERV = "http://localhost/Proyectos/Curso22_23/Servicios_Web/Ejercicio1/servicios_rest_ejer1";

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
            } else {
                var html_output = "<table class='centrado'>";
                html_output += "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><button class='enlace' onclick='montar_form_crear();'>Producto+</button></th></tr>";
                $.each(data.productos, function (key, tupla) {
                    html_output += "<tr>";
                    html_output += "<td><button onclick='listar(\"" + tupla["cod"] + "\")' class='enlace'>" + tupla["cod"] + "</button></td>";
                    html_output += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_output += "<td>" + tupla["PVP"] + "</td>";
                    html_output += "<td><button onclick='confirmar_borrar(\"" + tupla["cod"] + "\")' class='enlace'>Borrar</button> - Editar</td>";
                    html_output += "</tr>";
                });
                html_output += "</table>";
                $('#productos').html(html_output);
            }
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
            $('#productos').html("");
        });
}


function confirmar_borrar(cod) {
    output = "<p class='centrado'>Se dispone usted a borrar el producto: " + cod + "</p>";
    output += "<p class='centrado'>¿Estás Seguro?</p>";
    output += "<p class='centrado'><button onclick='volver();'>Volver</button> <button onclick='borrar(\"" + cod + "\")'>Continuar</button></p>";
    $('#respuesta').html(output);
}

function comprobar_nuevo() {
    $('#error_cod').html("");
    $('#error_nombre_corto').html("");

    var cod = $('#cod').val();
    var nombre_corto = $('#nombre_corto').val();
    $.ajax({
        url: encodeURI(DIR_SERV + "/repetido_insert/producto/cod/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            var output;
            if (data.repetido) {
                $('#error_cod').html("Código repetido");
                $.ajax({
                    url: encodeURI(DIR_SERV + "/repetido_insert/producto/nombre_corto/" + nombre_corto),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data) {
                        if (data.repetido) {
                            $('#error_nombre_corto').html("Nombre Corto repetido");
                        }
                    })
                    .fail(function (a, b) {
                        $('#respuesta').html(error_ajax_jquery(a, b));
                        $('#productos').html("");
                    });
            } else if (!data.repetido) {
                $.ajax({
                    url: encodeURI(DIR_SERV + "/repetido_insert/producto/nombre_corto/" + nombre_corto),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data) {
                        if (data.repetido) {
                            $('#error_nombre_corto').html("Nombre Corto repetido");
                        } else if (!data.repetido) {
                            //llamada al sercivio insertar
                            var nombre = $('#nombre').val();
                            var descripcion = $('#descripcion').val();
                            var PVP = $('#PVP').val();
                            var familia = $('#familia').val();
                            $.ajax({
                                url: DIR_SERV + "/producto/insertar",
                                type: "POST",
                                dataType: "json",
                                data: { "cod": cod, "nombre": nombre, "nombre_corto": nombre_corto, "descripcion": descripcion, "PVP": PVP, "familia": familia }
                            })
                                .done(function (data) {
                                    if (data.mensaje) {
                                        output = "<p class='mensaje'>El producto con cod: <strong>" + cod + "</strong> se ha insertado con éxito<p>";
                                        obtener_productos();
                                    } else {
                                        output = data.mensaje_error;
                                    }
                                    $('#respuesta').html(output);
                                })
                                .fail(function (a, b) {
                                    $('#respuesta').html(error_ajax_jquery(a, b));
                                    $('#productos').html("");
                                });
                        } else {
                            output = data.mensaje_error;
                        }
                        $('#respuesta').html(output);
                    })
                    .fail(function (a, b) {
                        $('#respuesta').html(error_ajax_jquery(a, b));
                        $('#productos').html("");
                    });
            } else {
                output = data.mensaje_error
            }

            $('#respuesta').html(output);
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
            $('#productos').html("");
        });
}

function montar_form_crear() {
    var html_output = "<h2>Creando un producto</h2>";
    $.ajax({
        url: DIR_SERV + "/familias",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                html_output = data.mensaje_error;
            }
            else {
                html_output += "<form onsubmit='event.preventDefault();comprobar_nuevo();'>";
                html_output += "<p><label for='cod'>Código: </label><input type='text' id='cod' required/><span id='error_cod'></span></p>";
                html_output += "<p><label for='nombre'>Nombre: </label><input type='text' id='nombre'/></p>";
                html_output += "<p><label for='nombre_corto'>Nombre Corto: </label><input type='text' id='nombre_corto' required/><span id='error_nombre_corto'></span></p>";
                html_output += "<p><label for='descripcion'>Descripción: </label><textarea id='descripcion' required></textarea></p>";
                html_output += "<p><label for='PVP'>PVP: </label><input type='number' id='PVP' min='0.01' step='0.01' required/></p>";
                html_output += "<p><label for='familia'>Seleccione una familia: </label>";
                html_output += "<select id='familia'>";
                $.each(data.familias, function (key, tupla) {
                    html_output += "<option value='" + tupla["cod"] + "'>" + tupla["nombre"] + "</option>"
                });
                html_output += "</select>";
                html_output += "</p>";
                html_output += "<p><button onclick='volver();event.preventDefault();'>Volver</button> <button>Continuar</button></p>";
                html_output += "</form>";
            }
            $('#respuesta').html(html_output);

        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
            $('#productos').html("");
        });
}

function borrar(cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/borrar/" + cod),
        type: "DELETE",
        dataType: "json"
    })
        .done(function (data) {
            var output;
            if (data.mensaje_error) {
                output = data.mensaje_error;
            } else {
                output = "<p class='centrado mensaje'>El producto con cod: <strong>" + cod + "</strong> ha sido borrado con éxito</p>";
                obtener_productos();
            }
            $('#respuesta').html(output);
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
            $('#productos').html("");
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
            }
            else if (data.producto) {
                $.ajax({
                    url: encodeURI(DIR_SERV + "/familia/" + data.producto["familia"]),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data2) {
                        if (data2.mensaje_error) {
                            output = data2.mensaje_error;
                        }
                        else {
                            output = "<h2>Información del producto: " + cod + "</h2>"
                            output += "<p><strong>Nombre: </strong>"
                            if (data.producto["nombre"])
                                output += data.producto["nombre"];
                            output += "</p>";
                            output += "<p><strong>Nombre corto: </strong>" + data.producto["nombre_corto"] + "</p>";
                            output += "<p><strong>Descripción: </strong>" + data.producto["descripcion"] + "</p>";
                            output += "<p><strong>PVP: </strong>" + data.producto["PVP"] + "€</p>";
                            output += "<p><strong>Familia: </strong>" + data2.familia["nombre"] + "</p>";
                            output += "<p><button onclick='volver();'>Volver</button></p>";
                        }
                        $('#respuesta').html(output);

                    })
                    .fail(function (a, b) {
                        $('#respuesta').html(error_ajax_jquery(a, b));
                        $('#productos').html("");
                    });
            } else {
                output = "<p>El producto con cod: <strong>" + cod + "</strong> ya no se encuentra en la BD</p>";
                obtener_productos();
            }
            $('#respuesta').html(output);
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b));
            $('#productos').html("");
        });
}

function volver() {
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