<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámen2 DWESE Curso 22-23</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .enlace {
            text-decoration: underline;
            background: none;
            border: 0;
            color: blue;
            cursor: pointer;
        }

        #mensaje {
            font-size: 20px;
            color: blue;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <?php
    //CONEXIÓN
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_exam_colegio");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . "</p>");
    }

    //CONSULTA Y SELECT
    try {
        $consulta = "SELECT * FROM alumnos";
        $resultado = mysqli_query($conexion, $consulta);

        //Si obtenemos tuplas, montamos el select:
        if (mysqli_num_rows($resultado) > 0) {
            echo "<form action='index.php' method='post'>";
            echo "<label for='alumno'>Seleccione un Alumno: </label>";
            echo "<select id='alumno'>";
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                $id_usuario = $tupla["cod_alu"];
                if (isset($_POST["btnListar"])) {
                    //SELECTED:
                    echo "<option value='" . $tupla["cod_alu"] . "' selected>" . $tupla["nombre"] . "</option>";
                } else {
                    echo "<option value='" . $tupla["cod_alu"] . "' >" . $tupla["nombre"] . "</option>";
                }
            }
            echo "</select>";
            $tupla = mysqli_fetch_assoc($resultado);
            echo "<button type='submit' name='btnListar' value='" . $id_usuario . "'>Ver Notas</button></form>";
        } else {
            //Si no hay tuplas, cerramos conexión y mostramos la información de que no hay alumnos en la BD.
            mysqli_close($conexion);
            die("<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>");
        }
    } catch (Exception $e) {
        $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }



    //LISTAR o btnAtras
    if (isset($_POST["btnListar"]) || isset($_POST["btnAtras"])) {
        if (isset($_POST["btnListar"])) {
            echo "<h2>Notas del alumno " . $_POST["btnListar"] . "</h2>";

            try {
                $consulta = "SELECT * FROM notas WHERE notas.cod_alu = " . $_POST["btnListar"];
                $resultado = mysqli_query($conexion, $consulta);
                echo "<table>";
                echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $tupla["cod_asig"] . "</td>";
                    echo "<td>" . $tupla["nota"] . "</td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='id' value='" . $tupla["cod_alu"] . "'><button type='submit' name='btnEditar' class='enlace' value='" . $_POST["btnListar"] . "'>Editar</button> - <button type='submit' name='btnBorrar' value='" . $_POST["btnListar"] . "'class='enlace'>Borrar</button></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } catch (Exception $e) {
                $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                die($mensaje);
            }
        } else {
            echo "<h2>Notas del alumno " . $_POST["id"] . "</h2>";

            try {
                $consulta = "SELECT * FROM notas WHERE notas.cod_alu = " . $_POST["id"];
                $resultado = mysqli_query($conexion, $consulta);
                echo "<table>";
                echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $tupla["cod_asig"] . "</td>";
                    echo "<td>" . $tupla["nota"] . "</td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='id' value='" . $tupla["cod_alu"] . "'><button type='submit' name='btnEditar' class='enlace' value='" . $_POST["id"] . "'>Editar</button> - <button type='submit' name='btnBorrar' value='" . $_POST["id"] . "'class='enlace'>Borrar</button></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } catch (Exception $e) {
                $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                die($mensaje);
            }
        }
    }

    //BORRAR
    if (isset($_POST["btnBorrar"])) {
        try {
            $consulta = "DELETE FROM notas WHERE cod_alu = " . $_POST["btnBorrar"];
            mysqli_query($conexion, $consulta);
            $mensaje_accion = "¡¡Asignatura descalificada con Éxito!!";
        } catch (Exception $e) {
            $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    //EDITAR
    if (isset($_POST["btnEditar"])) {
        try {
            $consulta = "SELECT * FROM notas WHERE notas.cod_alu = " . $_POST["btnEditar"];
            $resultado = mysqli_query($conexion, $consulta);

            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                echo "<form action='index.php' method='post'>";
                echo "<tr>";
                echo "<td>" . $tupla["cod_asig"] . "</td>";
                echo "<td><input type='text' name='nota' value='" . $tupla["nota"] . "'></td>";
                echo "<td><input type='hidden' name='id' value='" . $_POST["id"] . "'><button class='enlace' type='submit' name='btnCambiar'>Cambiar</button> - <button class='enlace' type='submit' name='btnAtras'>Atrás</button</form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (Exception $e) {
            $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    //MENSAJE ACCIÓN
    if (isset($mensaje_accion)) {
        echo "<p id='mensaje'>" . $mensaje_accion . "</p>";
    }

    //CIERRO CONEXIÓN Y LIBERO RESULTADO.
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>