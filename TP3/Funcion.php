<?php
class Funcion
{
    //Atributos de clase
    /** 
     * @var string $nombre
     * @var int $horarioInicio
     * @var int $duracion
     * @var float $precio
     * @var string $fecha
     */

    private $nombre;
    private $horarioInicio;
    private $duracion;
    private $precio;
    private $fecha;

    /**
     * Constructor de la clase
     * @param string $nombreFunc
     * @param int $hsInicioFunc
     * @param int $duracionFunc
     * @param float $precioFunc
     * @param string $fechaFun
     */
    public function __construct($nombreFunc, $hsInicioFunc, $duracionFunc, $precioFunc, $fechaFun)
    {
        $this->nombre = $nombreFunc;
        $this->horarioInicio = $hsInicioFunc;
        $this->duracion = $duracionFunc;
        $this->precio = $precioFunc;
        $this->fecha = $fechaFun;
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase 

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getHorarioInicio()
    {
        return $this->horarioInicio;
    }

    /**
     * @return int
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    //Modifican los atributos de clase

    /**
     * @param string $nom
     */
    public function setNombre($nom)
    {
        $this->nombre = $nom;
    }

    /**
     * @param int $hs
     */
    public function setHorarioInicio($hs)
    {
        $this->horarioInicio = $hs;
    }

    /**
     * @param int $durac
     */
    public function setDuracion($durac)
    {
        $this->duracion = $durac;
    }

    /**
     * @param float $prec
     */
    public function setPrecio($prec)
    {
        $this->precio = $prec;
    }

    /**
     * @param string $fech
     */
    public function setFecha($fech)
    {
        $this->fecha = $fech;
    }

    //METODOS DE LA CLASE

    /**
     * Modifica el nombre de la funcion
     * @param string $nuevoNombre
     */
    public function cambiarNombre($nuevoNombre)
    {
        $this->setNombre($nuevoNombre);
    }

    /**
     * Modifica el precio de la funcion
     * @param float $nuevoPrecio
     */
    public function cambiarPrecio($nuevoPrecio)
    {
        $this->setPrecio($nuevoPrecio);
    }

    /**
     * Retorna el costo de la funcion
     * @return $float
     */
    public function darCosto()
    {
        /**
         * @var float $costo
         */

        $costo = $this->getPrecio();

        return $costo;
    }

    /**
     * Retorna un string con la informacion de una funcion
     * @return string
     */
    public function __toString()
    {
        /**
         * @var int $inicioHs
         * @var int $inicioMint
         * @var int $duracionMint
         */
        $inicioHs = intdiv($this->getHorarioInicio(), 3600);
        $inicioMint = intdiv(($this->getHorarioInicio() % 3600), 60);
        $duracionMint = intdiv($this->getDuracion(), 60);

        return "Nombre: " . $this->getNombre() . "\n" .
            "Fecha: " . $this->getFecha() . "\n" .
            "Horario de inicio: " . $inicioHs . ":" . $inicioMint . "\n" .
            "Duracion de funcion: " . $duracionMint . " minutos" . "\n" .
            "Precio: " . $this->getPrecio() . "\n";
    }
}
