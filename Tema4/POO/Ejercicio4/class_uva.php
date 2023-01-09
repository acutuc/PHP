<?php
//require_once hace que no tengamos error en index.php al llamar dos veces a "class_fruta.php".
require_once "class_fruta.php";

//Herencia funciona como Java, con extends:
class Uva extends Fruta
{
    //Atributos:
    private $tieneSemilla;

    //Método (getter):
    public function tieneSemilla(){
        return $this->tieneSemilla;
    }

    //CONSTRUCTOR:
    public function __construct($color_nuevo, $tamanio_nuevo, $tiene)
    {
        $this->tieneSemilla = $tiene;
        //parent es el "super" de Java:
        parent::__construct($color_nuevo, $tamanio_nuevo, $tiene);
    }

    //Método imprimir:
    public function imprimir(){
        parent::imprimir();
        if($this->tieneSemilla){
            echo "<p>Tiene semilla</p>";
        }else{
            echo "<p>No tiene semilla</p>";
        }
    }
}
?>