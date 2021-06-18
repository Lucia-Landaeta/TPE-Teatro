<?php

/**  */
class ABMObraTeatro{

    /** Constructor de la clase */
    public function __construct(){}

    /**
     * Crea una nueva funcion
     * @param array  
     * @return boolean 
     */
    public function altaFuncion($datos){
        /**
         * @var object $obraT
         * @var boolean $exito
         */
        $obraT=new ObraTeatro();
        $exito=false;
        $obraT->cargar($datos);
        $this->darCosto($obraT);
        
        if($obraT->insertar()){
            $exito=true;
        }
        return $exito;
    }

    /**
     * Recupera una funcion de la BD
     * @param int $idFuncion
     * @return object
     */
    public function recuperarObraTeatro($idFuncion){
        /**
         * @var object $obraT
         * @var boolean $exito
         */
        $obraT=new ObraTeatro();
        $exito=$obraT->buscar($idFuncion);
        if(!$exito){
            $obraT=null;
        }
        return $obraT;
    }

    /**
     * Elimina una obra de teatro
     * @param int
     * @return boolean 
     */
    public function bajaObraT($idObra){
        /**
         * @var object $obraT
         * @var boolean $exito
         */
        $obraT=new ObraTeatro();
        $obraT->Buscar($idObra);
        $exito=$obraT->eliminar();

        return $exito;
    }

     /**
     * Calcula el costo de una obra de teatro
     * @param object 
     */
    public function darCosto($objObraT){
        /** @var float $costo */
        $costo = $objObraT->getPrecio();
        $costo = $costo + (($costo * 45) / 100);

        $objObraT->setCostoSala($costo);
    }

    /**
     * Retorna un string con la informacion de las obras de teatro
     * @return string 
     */
    public function mostrarObras(){
        /**
         * @var object $objFuncion
         * @var array $colFuncion
         * @var string $strFuncion
         */
        $objFuncion=new ObraTeatro();
        $colFuncion=$objFuncion->listar();
        $strFuncion="";
        foreach($colFuncion as $funcion){
            $strFuncion.=$funcion."*--------------------------------*\n";
        }
        return $strFuncion;
    }

}