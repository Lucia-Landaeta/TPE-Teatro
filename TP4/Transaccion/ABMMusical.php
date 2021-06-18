<?php
class ABMMusical{
    /** Constructor de la clase */
    public function __construct(){}

    /**
     * Crea una nueva funcion
     * @param array  
     * @return boolean 
     */
    public function altaFuncion($datos){
        /**
         * @var object $musical
         * @var boolean $exito
         */
        $musical=new Musical();
        $exito=false;
        $musical->cargar($datos);
        $this->darCosto($musical);
        
        if($musical->insertar()){
            $exito=true;
        }
        return $exito;
    }

    /**
     * Recupera una funcion de la BD
     * @param int $idFuncion
     * @return object
     */
    public function recuperarMusical($idFuncion){
        /**
         * @var object $musical
         * @var boolean $exito
         */
        $musical=new Musical();
        $exito=$musical->buscar($idFuncion);
        if(!$exito){
            $musical=null;
        }
        return $musical;
    }


    /**
     * Elimina un musical
     * @param object 
     * @return boolean 
     */
    public function bajaMusical($idMus){
        /**
         * @var object $musical
         * @var boolean $exito
         */
        $musical=new Musical();
        $musical->Buscar($idMus);
        $exito=$musical->eliminar();

        return $exito;
    }

     /**
     * Calcula el costo de un Musical
     */
    public function darCosto($objMusical){
        /**
         * @var float $costo
         * @var object $objMusical
         */

        $costo = $objMusical->getPrecio();
        $costo = $costo + (($costo * 12) / 100);

        $objMusical->setCostoSala($costo);
    }

    /**
     * Retorna un string con la informacion de los musicales 
     * @return string
     */
    public function mostrarMusicales(){
        /**
         * @var object $objFuncion, funcion
         * @var string $strFuncion
         */
        $objFuncion=new Musical();
        $colFuncion=$objFuncion->listar();
        $strFuncion="";
        foreach($colFuncion as $funcion){
            $strFuncion.=$funcion."*--------------------------------*\n";
        }
        return $strFuncion;
    }
}
