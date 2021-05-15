<?php
class ObraTeatro extends Funcion
{

    /**
     * Constructor de la clase
     * @param string $nombreObra
     * @param int $hsInicioObra
     * @param int $duracionObra
     * @param float $precioObra
     * @param date $fecha
     */
    public function __construct($nombreObra, $hsInicioObra, $duracionObra, $precioObra, $fecha)
    {
        parent::__construct($nombreObra, $hsInicioObra, $duracionObra, $precioObra, $fecha);
    }


    //METODOS DE LA CLASE
    /**
     * Retorna el costo de la obra de teatro
     * @return $float
     */
    public function darCosto()
    {
        /**
         * @var float $costo
         */
        $costo = parent::darCosto();

        $costo = $costo + (($costo * 45) / 100);

        return $costo;
    }

    /**
     * Retorna un string con la informacion de la obra de teatro
     * @return string
     */
    public function __toString()
    {
        return "Obra de teatro"."\n".parent::__toString();
    }
}
