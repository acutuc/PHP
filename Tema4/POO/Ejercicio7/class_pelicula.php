<?php
class Pelicula
{
    //Atributos
    private $titulo;
    private $anio;
    private $director;
    private $alquilada;
    private $precio;
    private $fecha_devolucion;

    //GETTERS:
    public function get_titulo(){
        return $this->titulo;
    }

    public function get_anio(){
        return $this->anio;
    }

    public function get_director(){
        return $this->director;
    }

    public function get_alquilada(){
        return $this->alquilada;
    }

    public function get_precio(){
        return $this->precio;
    }

    public function get_fecha_devolucion(){
        return $this->fecha_devolucion;
    }

    //SETTERS:
    public function set_titulo($nuevo_titulo){
        $this->titulo = $nuevo_titulo;
    }

    public function set_anio($nuevo_anio){
        $this->anio = $nuevo_anio;
    }

    public function set_director($nuevo_director){
        $this->director = $nuevo_director;
    }

    public function set_alquilada($nuevo_alquilada){
        $this->alquilada = $nuevo_alquilada;
    }

    public function set_precio($nuevo_precio){
        $this->precio = $nuevo_precio;
    }

    public function set_fecha_devolucion($nuevo_fecha_devolucion){
        $this->fecha_devolucion = $nuevo_fecha_devolucion;
    }
}
?>