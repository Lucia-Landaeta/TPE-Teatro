<?php
class ABMFuncion{

    /** Constructor de la clase */
    public function __construct(){}

    /**
     * Crea una nueva funcion
     * @param array  
     * @return boolean 
     */
    public function altaFuncion($datos){
        /**
         * @var object $funcion
         * @var boolean $exito
         */
        $funcion=new Funcion();
        $exito=false;
        $funcion->cargar($datos);
        $this->darCosto($funcion);
        
        if($funcion->insertar()){
            $exito=true;
        }
        return $exito;
    }

    /**
     * Recupera una funcion de la BD
     * @param int $idFuncion
     * @return object
     */
    public function recuperarFuncion($idFuncion){
        /**
         * @var object $funcion
         * @var boolean $exito
         */
        $funcion=new Funcion();
        $exito=$funcion->buscar($idFuncion);
        if(!$exito){
            $funcion=null;
        }
        return $funcion;
    }

    /**
     * Cambia el nombre de una funcion 
     * @param object $objFuncion
     * @param string $nombre
     * @return boolean 
     */
    public function cambiarNombre($objFuncion,$nombre){
        /**
         * @var object $objFuncion
         * @var boolean $exito
         */
        $objFuncion->setNombre($nombre);
        $exito=$objFuncion->modificar();

        return $exito;
    }

    /**
     * Cabia el precio de una funcion
     * @param object $objFuncion
     * @param float $precio
     * @return boolean 
     */
    public function cambiarPrecio($objFuncion,$precio){
        /**
         * @var object $objFuncion
         * @var boolean $exito
         */
        $objFuncion->setPrecio($precio);
        $exito=$objFuncion->modificar();

        return $exito;
    }

    /**
     * Elimina una funcion
     * @param object 
     * @return boolean 
     */
    public function bajaFuncion($objFuncion){
        /** @var boolean $exito */
        $exito=$objFuncion->eliminar();

        return $exito;
    }

     /**
     * Calcula el costo de la funcion
     * @return $float
     */
    public function darCosto($objFuncion){
        /** @var float $costo */
        $costo = $objFuncion->getPrecio();

        return $costo;
    }

    /**
     * Retorna un string con la informacion de las funciones cargadas
     * @return string $strFuncion
     */
    public function mostrarFunciones(){
        /**
         * @var object $objFuncion, $funcion
         * @var array $colFuncion
         * @var string $strFuncion
         */
        $objFuncion=new Funcion();
        $colFuncion=$objFuncion->listar();
        $strFuncion="Funciones: \n";
        foreach($colFuncion as $funcion){
            $strFuncion.="ID: ".$funcion->getIdFuncion()." "."Nombre: ".$funcion->getNombre()." "
            ."Precio $".$funcion->getPrecio()." idTeatro: ".$funcion->getObjTeatro()->getIdTeatro()."\n";
        }
        return $strFuncion;
    }

    

}