<?php
class Fruta
{
    //ATRIBUTOS:
    private $color;
    private $tamanio;
    private static $n_frutas = 0;

    //Creamos un CONSTRUCTOR:
    public function __construct($color_nuevo, $tamanio_nuevo){
        $this->color = $color_nuevo;
        $this->tamanio = $tamanio_nuevo;
        //Para acceder a un atributo static utilizamos self::
        self::$n_frutas++;
    }

    //Creamos un DESTRUCT:
    public function __destruct()
    {
        self::$n_frutas--;
    }

    //Método estático:
    public static function cuantaFruta(){
        return self::$n_frutas;
    }

    //Creamos un método public que imprima:
    public function imprimir(){
        echo "<p><strong>Color: </strong>".$this->color."</p>";
        echo "<p><strong>Tamaño: </strong>".$this->tamanio."</p>";
    }

    //SETTERS:
    public function set_color($color_nuevo)
    {
        $this->color = $color_nuevo;
    }

    public function set_tamanio($tamanio_nuevo){
        $this->tamanio = $tamanio_nuevo;
    }

    //GETTERS:
    public function get_color()
    {
        return $this->color;
    }

    public function get_tamanio(){
        return $this->tamanio;
    }

    
}
?>