<?php
class Fruta
{
    //var $color;   Sería PUBLIC
    //ENCAPSULAMOS LOS ATRIBUTOS:
    private $color;
    private $tamanio;

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