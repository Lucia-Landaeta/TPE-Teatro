<?php
class ABMCine{
    /** Constructor de la clase */
    public function __construct(){}

    /**
     * Crea una nueva funcion de cine y la inserta en la BD
     * @param array  
     * @return boolean 
     */
    public function altaFuncion($datos){
        /**
         * @var object $cine
         * @var boolean $exito
         */
        $cine = new Cine();
        $exito = false;
        $cine->cargar($datos);
        $this->darCosto($cine);

        if ($cine->insertar()) {
            $exito = true;
        }
        return $exito;
    }

    /**
     * Recupera una funcion de cine de la BD
     * @param int
     * @return object
     */
    public function recuperarCine($idCine){
        /**
         * @var object $cine
         * @var boolean $exito
         */
        $cine = new Cine();
        $exito = $cine->buscar($idCine);
        if (!$exito) {
            $cine = null;
        }
        return $cine;
    }


    /**
     * Elimina un funcion de cine
     * @param object 
     * @return boolean 
     */
    public function bajaCine($idCine){
        /**
         * @var object $cine
         * @var boolean $exito
         */
        $cine = new Cine();
        $cine->Buscar($idCine);
        $exito = $cine->eliminar();

        return $exito;
    }

    /**
     * Calcula el costo de una funcion de cine
     * @param object 
     * @return $float
     */
    public function darCosto($objCine){
        /**
         * @var float $costo
         * @var object $objCine
         */

        $costo = $objCine->getPrecio();
        $costo = $costo + (($costo * 12) / 100);

        $objCine->setCostoSala($costo);
    }

    /**
     * Retorna un string con la informacion del la funciones
     * @return string
     */
    public function mostrarCines(){
        /**
         * @var object $objFuncion, $funcion
         * @var array $colFuncion
         * @var string $strFuncion
         */
        $objFuncion = new Cine();
        $colFuncion = $objFuncion->listar();
        $strFuncion = "";
        foreach ($colFuncion as $funcion) {
            $strFuncion .= $funcion . "*--------------------------------*\n";
        }
        return $strFuncion;
    }
}
