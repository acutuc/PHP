<?php
class Menu
{
    //Atributos:
    private $enlace = array();
    private $nombre = array();

    //Cargamos los datos:
    public function cargar($enl, $tit)
    {
        $this->enlace[] = $enl;
        $this->nombre[] = $tit;
    }

    //Método que muestra el menú vertical:
    public function vertical()
    {
        echo "<p>";

        for ($i = 0; $i < count($this->enlace); $i++) {
            echo "<a href='" . $this->enlace[$i] . "'>" . $this->nombre[$i] . "</a>";
            echo "<br>";
        }

        echo "</p>";
    }

    public function horizontal(){
        echo "<p>";

        for ($i = 0; $i < count($this->enlace); $i++) {
            echo "<a href='" . $this->enlace[$i] . "'>" . $this->nombre[$i] . "</a>";
            echo "&nbsp";
        }

        echo "</p>";
    }

    //GETTERS:
    public function get_enlace()
    {
        return $this->enlace;
    }

    public function get_nombre()
    {
        return $this->nombre;
    }

    //SETTERS:
    public function set_enlace($nuevo_enlace)
    {
        $this->enlace = $nuevo_enlace;
    }

    public function set_nombre($nuevo_nombre)
    {
        $this->nombre = $nuevo_nombre;
    }
}
?>