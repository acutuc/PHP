<?php
class Fruta
{
    //ATRIBUTOS:
    private $color;
    private $tamanio;

    //Creamos un CONSTRUCTOR:
    public function __construct($color_nuevo, $tamanio_nuevo){
        $this->color = $color_nuevo;
        $this->tamanio = $tamanio_nuevo;
        //Pasamos el método imprimir en el constructor, a petición del enunciado:
        $this->imprimir();
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