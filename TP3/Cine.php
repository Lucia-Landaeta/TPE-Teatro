<?php
class Cine extends Funcion
{

    //Atributos de clase
    /**
     * @var string $genero
     * @var string $paisOrigen
     */
    private $genero;
    private $paisOrigen;

    /**
     * Constructor de la clase
     * @param string $nombrePelicula
     * @param int $hsInicioPeli
     * @param int $duracionPeli
     * @param float $precioPeli
     * @param date $fecha
     * @param string $generoPeli
     * @param string $paisOrigenPeli
     */
    public function __construct($nombrePelicula, $hsInicioPeli, $duracionPeli, $precioPeli, $fecha, $generoPeli, $paisOrigenPeli)
    {
        parent::__construct($nombrePelicula, $hsInicioPeli, $duracionPeli, $precioPeli, $fecha);

        $this->genero = $generoPeli;
        $this->paisOrigen = $paisOrigenPeli;
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase

    /**
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }
    /**
     * @return string
     */
    public function getPaisOrigen()
    {
        return $this->paisOrigen;
    }

    //Modifican los atributos de clase

    /**
     * @param string $generoPeli
     */
    public function setGenero($generoPeli)
    {
        $this->genero = $generoPeli;
    }

    /**
     * @param string $paisOrigenPeli
     */
    public function setPaisOrigen($paisOrigenPeli)
    {
        $this->paisOrigen = $paisOrigenPeli;
    }

    //METODOS DE LA CLASE

    /**
     * Retorna el costo de la funcion de Cine
     * @return $float
     */
    public function darCosto()
    {
        /**
         * @var float $costo
         */
        $costo = parent::darCosto();

        $costo = $costo + (($costo * 65) / 100);

        return $costo;
    }

    /**
     * Retorna un string con la informacion de la funcion de Cine
     * @return string
     */
    public function __toString()
    {
        return "Pelicula"."\n".parent::__toString() . "Genero: " . $this->getGenero() . "\n" .
            "Pais de origen: " . $this->getPaisOrigen() . "\n";
    }
}
