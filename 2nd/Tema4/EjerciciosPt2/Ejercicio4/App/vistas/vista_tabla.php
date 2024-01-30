<?php
$url = DIR_SERV."/usuarios";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);

if(isset($obj->error)){
    die(error_page("Primer CRUD SW", "<p>".$obj->error."</p>"));
}

echo "<table>";
echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
foreach($obj->usuarios as $tupla){
    echo "<tr>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla->id_usuario."' name='btnDetalle' title='Detalles del Usuario'>".$tupla->nombre."</button></form></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='".$tupla->nombre."'><button class='enlace' type='submit' value='".$tupla->id_usuario."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla->id_usuario."' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
    echo "</tr>";
}
echo "</table>";