<?php
session_name("Examen4_SW_23_24");
session_start();
require "../src/funciones_ctes.php";
require "../src/seguridad.php";
//PRIMER SELECT
$url = DIR_SERV . "/alumnos";
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj->error . "</p>"));
}
if (isset($obj->no_auth)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

//BORRAR
if (isset($_POST["btnBorrar"])) {
    $url = DIR_SERV . "/quitarNota/" . $_POST["alumno"];
    $datos["cod_asig"] = $_POST["cod_asig"];
    $respuesta = consumir_servicios_REST($url, "DELETE", $datos);
    $obj3 = json_decode($respuesta);

    if (!$obj3) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }
    if (isset($obj3->error)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj3->error . "</p>"));
    }
    if (isset($obj3->no_auth)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
}

//EDITAR
if (isset($_POST["btnEditar"])) {
}

//LISTAR BORRANDO
if (isset($_POST["btnVerNotas"]) || isset($_POST["btnBorrar"])) {
    $url = DIR_SERV . "/notasAlumno/" . $_POST["alumno"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);

    if (!$obj2) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }
    if (isset($obj2->error)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj2->error . "</p>"));
    }
    if (isset($obj2->no_auth)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
}

//LISTAR EDITANDO
if (isset($_POST["btnVerNotas"]) || isset($_POST["btnEditar"])) {
    $url = DIR_SERV . "/notasAlumno/" . $_POST["alumno"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);

    if (!$obj2) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }
    if (isset($obj2->error)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj2->error . "</p>"));
    }
    if (isset($obj2->no_auth)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }

        .enlinea {
            display: inline;
        }

        .mensaje {
            color: blue;
            size: 1rem;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <form method="post" action="../index.php">
        Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
        <button name="btnSalir" class='enlace'>Salir</button>
    </form>
    <?php
    if (!isset($obj->alumnos)) {
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD.</p>";
    } else {
        echo "<p>";
        echo "<form method='post' action='index.php'>";
        echo "<label for='alumno'>Seleccione un alumno: </label>";
        echo "<select name='alumno' id='alumno'>";
        foreach ($obj->alumnos as $tupla) {
            if (isset($_POST["alumno"]) && $_POST["alumno"] == $tupla->cod_usu) {
                echo "<option value='" . $tupla->cod_usu . "' selected>" . $tupla->nombre . "</option>";
                $nombre_alumno = $tupla->nombre;
            } else {
                echo "<option value='" . $tupla->cod_usu . "'>" . $tupla->nombre . "</option>";
            }
        }
        echo "</select> ";
        echo "<button name='btnVerNotas'>Ver Notas</button>";
        echo "</form>";
        echo "</p>";
    }

    if (isset($_POST["btnVerNotas"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"])) {

        echo "<h2>Notas del alumno " . $nombre_alumno . "</h2>";
        echo "<table>";

        echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
        foreach ($obj2->notas as $tupla) {
            if (isset($_POST["btnEditar"])) {
                //editando
                echo "<tr>";

                echo "<td>" . $tupla->denominacion . "</td>";
                if (isset($_POST["btnEditar"]) && $_POST["btnEditar"] == $tupla->denominacion) {
                    echo "<td><input type='text' name='nuevaNota' value='".$tupla->nota."'/></td>";
                } else {
                    echo "<td>" . $tupla->nota . "</td>";
                }

                echo "<td>";
                echo "<form method='post' action='index.php' class='enlinea'>
            <input type='hidden' name='nota' value='" . $tupla->nota . "'/>
            <input type='hidden' name='cod_asig' value='" . $tupla->cod_asig . "'/>
            <input type='hidden' name='alumno' value='" . $_POST["alumno"] . "'/>
            <button name='btnEditar' class='enlace' value='" . $tupla->denominacion . "'>Editar</button></form> - 
            <form method='post' action='index.php' class='enlinea'>
            <input type='hidden' name='nota' value='" . $tupla->nota . "'/>
            <input type='hidden' name='cod_asig' value='" . $tupla->cod_asig . "'/>
            <input type='hidden' name='alumno' value='" . $_POST["alumno"] . "'/>
            <button name='btnBorrar' class='enlace'>Borrar</button></form>";
                echo "</td>";
                echo "</tr>";
            } else {
                echo "<tr>";

                echo "<td>" . $tupla->denominacion . "</td>";
                echo "<td>" . $tupla->nota . "</td>";
                echo "<td>";
                echo "<form method='post' action='index.php' class='enlinea'>
            <input type='hidden' name='nota' value='" . $tupla->nota . "'/>
            <input type='hidden' name='cod_asig' value='" . $tupla->cod_asig . "'/>
            <input type='hidden' name='alumno' value='" . $_POST["alumno"] . "'/>
            <button name='btnEditar' class='enlace'>Editar</button></form> - 
            <form method='post' action='index.php' class='enlinea'>
            <input type='hidden' name='nota' value='" . $tupla->nota . "'/>
            <input type='hidden' name='cod_asig' value='" . $tupla->cod_asig . "'/>
            <input type='hidden' name='alumno' value='" . $_POST["alumno"] . "'/>
            <button name='btnBorrar' class='enlace'>Borrar</button></form>";
                echo "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";

        if (isset($obj3->mensaje)) {
            echo "<p class='mensaje'>¡¡ " . $obj3->mensaje . " !!</p>";
        }
    }
    ?>
</body>

</html>