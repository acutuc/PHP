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
            echo "<select id='alumno' name='alumno'>";
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                if (isset($_POST["alumno"]) && $_POST["alumno"] == $tupla["cod_alu"]) {
                    //SELECTED:
                    echo "<option value='" . $tupla["cod_alu"] . "' selected>" . $tupla["nombre"] . "</option>";
                    $nombre_alumno = $tupla["nombre"]; //atención aquí.
                } else {
                    echo "<option value='" . $tupla["cod_alu"] . "' >" . $tupla["nombre"] . "</option>";
                }
            }
            echo "</select>";
            echo "<button type='submit' name='btnListar'>Ver Notas</button></form>";
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
    if (isset($_POST["alumno"]) || isset($_POST["btnAtras"])) {
        echo "<h2>Notas del alumno " . $nombre_alumno . "</h2>";

        try {
            $consulta = "SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas,notas WHERE asignaturas.cod_asig = notas.cod_asig AND cod_alu = '" . $_POST["alumno"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $tupla["denominacion"] . "</td>";
                echo "<td>" . $tupla["nota"] . "</td>";
                echo "<td><form action='index.php' method='post'><input type='hidden' name='id' value='" . $_POST["alumno"] . "'><button type='submit' name='btnEditar' class='enlace' value='" . $tupla["cod_asig"] . "'>Editar</button> - <button type='submit' name='btnBorrar' value='" . $tupla["cod_asig"] . "'class='enlace'>Borrar</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (Exception $e) {
            $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }

        //Cuando no  hay asignaturas por calificar
        if (mysqli_num_rows($resultado) < 1) {
            echo "<p>A <strong>" . $nombre_alumno . "</strong> no le quedan más asignaturas por calificar.</p>";
        } else {
    ?>
            <form action="index.php" method="post">
                <p>
                    <label for="cod_asig">Asignaturas que le quedan por a <strong><?php echo $nombre_alumno ?></strong> aún por calificar</label>
                    <select name="cod_asig" id="cod_asig">
                        <?php
                        while ($tupla = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='" . $tupla["cod_asig"] . "'>" . $tupla["denominacion"] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="alumno" value="<?php echo $_POST["alumno"] ?>">
                    <button type="submit" name="btnCalificar">Calificar</button>
                </p>
            </form>
    <?php
        }
    }


    //BORRAR
    if (isset($_POST["btnBorrar"])) {
        try {
            $consulta = "DELETE FROM notas WHERE cod_alu = " . $_POST["alumno"]."AND cod_asig = ".$_POST["btnBorrar"];
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