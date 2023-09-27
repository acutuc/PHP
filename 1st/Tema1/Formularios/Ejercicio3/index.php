<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 3</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 3</h1>
        <p>
            Realizar un formulario que permita pedir una cantidad de cuadernos, cuyo precio variará según la cantidad pedida, teniendo en cuenta que si pide:
        </p>
        <table border=2px solid black>
            <tr>
                <td>Cantidad</td>
                <td>Precio unitario</td>
            </tr>
            <tr>
                <td>menos de 10</td>
                <td>2 €</td>
            </tr>
            <tr>
                <td>entre 10 y 30</td>
                <td>1.5 €</td>
            </tr>
            <tr>
                <td>mas de 30</td>
                <td>1 €</td>
            </tr>
        </table>
        <p>
            El precio total del pedido se mostrará en una página PHP mediante el método POST.<br>
            Usaremos una estructura condicional if para realizar el ejercicio.
        </p>
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <label for="cantidad">Cantidad de cuadernos a pedir: </label>
            <select id="cantidad" name="cantidad">
                <?php
                    $arr = [];
                    for($i = 1; $i < 51; $i++){
                        $arr[$i] = $i;
                        echo "<option value='$i'>".$i."</option>";
                    }
                ?>
            </select><br/>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
        <?php
        $precios = array(2, 1.5, 1);
        if (isset($_POST["btnEnviar"]) && $_POST["cantidad"] < 10){
            echo "<h1>Respuestas</h1>";
            echo "<span><strong>Precio total del pedido: </strong>".$_POST["cantidad"] * $precios[0]."€</span>";
        }else if(isset($_POST["btnEnviar"]) && $_POST["cantidad"] >= 10 && $_POST["cantidad"] <= 30){
            echo "<h1>Respuestas</h1>";
            echo "<span><strong>Precio total del pedido: </strong>".$_POST["cantidad"] * $precios[1]."€</span>";
        }else if(isset($_POST["btnEnviar"]) && $_POST["cantidad"] > 30){
            echo "<h1>Respuestas</h1>";
            echo "<span><strong>Precio total del pedido: </strong>".$_POST["cantidad"] * $precios[2]."€</span>";
        }
        ?>
    </body>
</html>