<?php
//ESCRIBIMOS UN FICHERO:
$fichero = fopen("fichero.txt", "w");

for($i = 0; $i < 10; $i++){
    if($i == 9){
        $linea = fputs($fichero, "Línea ".$i+1);
    } else{
        $linea = fputs($fichero, "Línea ".$i+1 ."\n");
    }
}
fclose($fichero);


//Leemos el fichero creado:
$fichero = fopen("fichero.txt", "r");

while(!feof($fichero)){
    $linea = fgets($fichero);
    echo "<p>$linea</p>";
}
?>