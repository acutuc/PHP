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
    public function get_titulo()
    {
        return $this->titulo;
    }

    public function get_anio()
    {
        return $this->anio;
    }

    public function get_director()
    {
        return $this->director;
    }

    public function get_alquilada()
    {
        return $this->alquilada;
    }

    public function get_precio()
    {
        return $this->precio;
    }

    public function get_fecha_devolucion()
    {
        return $this->fecha_devolucion;
    }

    //SETTERS:
    public function set_titulo($nuevo_titulo)
    {
        $this->titulo = $nuevo_titulo;
    }

    public function set_anio($nuevo_anio)
    {
        $this->anio = $nuevo_anio;
    }

    public function set_director($nuevo_director)
    {
        $this->director = $nuevo_director;
    }

    public function set_alquilada($nuevo_alquilada)
    {
        $this->alquilada = $nuevo_alquilada;
    }

    public function set_precio($nuevo_precio)
    {
        $this->precio = $nuevo_precio;
    }

    public function set_fecha_devolucion($nuevo_fecha_devolucion)
    {
        $this->fecha_devolucion = $nuevo_fecha_devolucion;
    }

    public function __construct($nuevo_titulo, $nuevo_anio, $nuevo_director, $nuevo_alquilada, $nuevo_precio, $nuevo_fecha_devolucion)
    {
        $this->titulo = $nuevo_titulo;
        $this->anio = $nuevo_anio;
        $this->director = $nuevo_director;
        $this->alquilada = $nuevo_alquilada;
        $this->precio = $nuevo_precio;
        $this->fecha_devolucion = $nuevo_fecha_devolucion;
    }

    public function imprimir()
    {
        echo "<div>";

        if ($this->get_alquilada()) {
            echo "<h2>DATOS DE LA PELÍCULA</h2>";
            echo "<p><strong>Nombre: </strong>" . $this->get_titulo() . ".</p>";
            echo "<p><strong>Año y director: </strong>" . $this->get_anio() . ". " . $this->get_director() . ".</p>";
            echo "<p><strong>Precio: </strong>" . $this->get_precio() . "€.</p>";

            $this->set_alquilada("Si");

            echo "<p><strong>Alquilada (Si/No): </strong>" . $this->get_alquilada() . "</p>";
            echo "<p><strong>Fecha prevista de devolución (aaaa-mm-dd): </strong>" . $this->get_fecha_devolucion() . "</p>";

            $fecha_actual = new DateTime();
            $fecha_devolucion = new DateTime($this->get_fecha_devolucion());
            $intervalo = $fecha_actual->diff($fecha_devolucion);

            echo "<p><strong>Recargo por devolución retrasada (1,2€ por día de retraso): </strong>" . $intervalo->days * 1.2 . "€</p>";
        }else{
            echo "<h2>DATOS DE LA PELÍCULA</h2>";
            echo "<p><strong>Nombre: </strong>" . $this->get_titulo() . ".</p>";
            echo "<p><strong>Año y director: </strong>" . $this->get_anio() . ". " . $this->get_director() . ".</p>";
            echo "<p><strong>Precio: </strong>" . $this->get_precio() . "€.</p>";

            $this->set_alquilada("No");

            echo "<p><strong>Alquilada (Si/No): </strong>" . $this->get_alquilada() . "</p>";
        }



        echo "</div>";
    }
}
?>