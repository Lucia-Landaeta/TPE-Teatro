<?php
class Musical extends Funcion
{
    //Atributos de clase
    /**
     * @var string $director
     * @var int $personasEnEscena
     */
    private $director;
    private $personasEnEscena;

    /**
     * Constructor de la clase
     * @param string $nombreMusc
     * @param int $hsInicioMusc
     * @param int $duracionMusc
     * @param float $precioMusc
     * @param date $fecha
     * @param string $directorMusc
     * @param int $persEscena
     */
    public function __construct($nombreMusc, $hsInicioMusc, $duracionMusc, $precioMusc, $fecha, $directorMusc, $persEscena)
    {
        parent::__construct($nombreMusc, $hsInicioMusc, $duracionMusc, $precioMusc, $fecha);

        $this->director = $directorMusc;
        $this->personasEnEscena = $persEscena;
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase 

    /**
     * @return string
     */
    public function getDirector()
    {
        return $this->director;
    }
    /**
     * @return int
     */
    public function getPersonasEnEscena()
    {
        return $this->personasEnEscena;
    }

    //Modifican los atributos de clase

    /**
     * @param string $directorMusc
     */
    public function setDirector($directorMusc)
    {
        $this->director = $directorMusc;
    }

    /**
     * @param int $persEscena
     */
    public function setPersonasEnEscena($persEscena)
    {
        $this->personasEnEscena = $persEscena;
    }


    //METODOS DE LA CLASE
    /**
     * Retorna el costo del Musical
     * @return $float
     */
    public function darCosto()
    {
        /**
         * @var float $costo
         */
        $costo = parent::darCosto();

        $costo = $costo + (($costo * 12) / 100);

        return $costo;
    }

    /**
     * Retorna un string con la informacion del Musical
     * @return string
     */
    public function __toString()
    {
        return "Musical:"."\n".parent::__toString() . "Director: " . $this->getDirector() . "\n" .
            "Personas en escena: " . $this->getPersonasEnEscena() . "\n";
    }
}
