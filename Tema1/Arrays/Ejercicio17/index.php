<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 17</title>
</head>
<body>
    <h1>Ejercicio 17</h1>
    
    <?php
        $familias = array("Los Simpson"=>array("Padre"=>"Homer", "Madre"=>"Marge", "Hijos"=>array("Bart", "Lisa", "Maggie")), "Los Griffin"=>array("Padre"=>"Peter", "Madre"=>"Lois", "Hijos"=>array("Chris", "Meg", "Stewie")));

        echo "<ul>";
        foreach($familias as $nombre_familia => $familia){
            echo "<li>";
                echo $nombre_familia;
                echo "<ul>";
                foreach($familia as $parentesco => $nombre){
                    echo "<li>";
                    if($parentesco == "Hijos"){
                        echo $parentesco.": ";
                        echo "<ol>";
                        for($i = 0; $i<count($nombre); $i++){
                            echo "<li>";
                            echo $nombre[$i];
                            echo "</li>";
                        }
                        echo "</ol>";
                    }else {
                        echo $parentesco.": ".$nombre;
                    }
                        
                    echo "</li>";
                }
                echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
    ?>
</body>
</html>