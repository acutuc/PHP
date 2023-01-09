<?php
class Empleado
{
    //Atributos:
    private $nombre;
    private $sueldo;

    //Constructor:
    public function __construct($nuevo_nombre, $nuevo_sueldo){
        $this->nombre = $nuevo_nombre;
        $this->sueldo = $nuevo_sueldo;
    }

    //Método que imprima el nombre y un mensaje si debe o no pagar impuestos:
    public function imprimir(){
        echo "<p><strong>Nombre: </strong>".$this->nombre."</p>";
        if($this->sueldo > 3000){
            echo "<p>El empleado <strong>DEBE</strong> pagar impuestos</p>";
        }else{
            echo "<p>El empleado <strong>NO</strong> debe pagar impuestos</p>";
        }
    }

    //GETTERS:
    public function get_nombre(){
        return $this->nombre;
    }

    public function get_sueldo(){
        return $this->sueldo;
    }

    //SETTERS:
    public function set_nombre($nuevo_nombre){
        $this->nombre = $nuevo_nombre;
    }

    public function set_sueldo($nuevo_sueldo){
        $this->sueldo = $nuevo_sueldo;
    }
}
?>