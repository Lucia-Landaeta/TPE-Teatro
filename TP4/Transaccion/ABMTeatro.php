<?php
class ABMTeatro{

    /** Constructor de la clase */
    public function __construct(){ }

    /**
     * Crea un nuevo teatro
     * @param string $nombre, $direccion
     * @return boolean 
     */
    public function altaTeatro($nombre,$direccion){
        /**
         * @var object $teatro
         * @var boolean $exito
         */
        $teatro=new Teatro();
        $teatro->cargarTeatro($nombre,$direccion);
        $exito=false;
        if($teatro->insertar()){
            $exito=true;
        }
        return $exito;
    }

    /**
     * Recupera un Teatro de la BD
     * @param int
     * @return object 
     */
    public function recuperarTeatro($id){
        /**
         * @var object $teatro
         * @var boolean $exito
         */
        $teatro=new Teatro();
        $exito=$teatro->buscar($id);
        $teatro->getColFunciones();
        if(!$exito){
            $teatro=null;
        }
        return $teatro;
    }

    /**
     * Elimina un teatro 
     * @param object
     * @return boolean 
     */
    public function bajaTeatro($objTeatro){
        /** @var boolean $exito */
        $exito=$objTeatro->eliminar();

        return $exito;
    }

    /**
     * Func. Modifica el nombre de un teatro
     * @param object $objTeatro
     * @param string $nombre
     * @return boolean $exito
     */
    public function modificarNombre($objTeatro,$nombre){
        /** @var boolean $exito */
        $objTeatro->setNombre($nombre);
        $exito=$objTeatro->modificar();

        return $exito;
    }

    /**
     * Func. Modifica la direccion de un teatro
     * @param object $objTeatro
     * @param string $direccion
     * @return boolean 
     */
    public function modificarDireccion($objTeatro,$direccion){
        /** @var boolean $exito */
        $objTeatro->setDireccion($direccion);
        $exito=$objTeatro->modificar();

        return $exito;
    }

    /**
     * Carga una nueva funcion  
     * @param array
     * @return boolean
     */
    public function cargarFuncion($datos){
        /**
         * @var boolean $exito, $verificacion
         * @var string $tipo
         * @var object $abm
         */
        $exito = false;
        $tipo=strtolower($datos["tipo"]);

        $verificacion = $this->verificarDisponibilidad($datos["hsInicio"], $datos["duracion"], $datos["fecha"],$datos["teatro"]);
        if ($verificacion) {
            if($tipo=="cine"){
                $abm= new ABMCine();
            }else if($tipo=="musical"){
                $abm=new ABMMusical();
            }else{
                $abm=new ABMObraTeatro();
            }
            $exito=$abm->altaFuncion($datos);
        }
        return $exito;
    }
  
    /**
     * Verifica que el horario de una funcion no se solape en una determinada fecha con los horarios de las funciones existentes en la coleccion
     * @param int $hsInicio
     * @param int $duracion
     * @param string $fecha
     * @param object $objTeatro
     * @return boolean 
     */
    private function verificarDisponibilidad($hsInicio,$duracion,$fecha,$objTeatro){
        /**
         * @var boolean $verif
         * @var int $finFuncion, $i, $inicio, $final
         * @var array $funcion
         */
        $verif = true;
        $finFuncion = $hsInicio + $duracion;
        $i = 0;
        $funciones = $objTeatro->getColFunciones();
        while ($verif && $i < count($funciones)) {
            $inicio = $funciones[$i]->getHorarioInicio();
            $final = $inicio + $funciones[$i]->getDuracion();
            $fechaFunc = $funciones[$i]->getFecha();

            if ($fechaFunc == $fecha) {
                if (($hsInicio >= $inicio && $hsInicio <= $final) ||
                    ($finFuncion >= $inicio && $finFuncion <= $final)
                ) {
                    $verif = false;
                }
            }
            $i++;
        }
        return $verif;
    }

    /**
     * Retorna el costo de usar el teatro(el costo se obtiene sumamdo los precios de cada tipo de actividad programada con sus respetivos incrementos)
     * @param int $mes
     * @param object $objTeatro
     * @return float
     */
    public function darCostoTeatro($mes,$objTeatro){
        /**
         * @var float $costo
         * @var int $fechaEntero, $mesFuncion
         */
        $costo = 0;
        foreach ($objTeatro->getColFunciones() as $funcion) {
            $fechaEntero = strtotime($funcion->getfecha());
            $mesFuncion = date('m', $fechaEntero);

            if ($mesFuncion == $mes) {
                $costo += $funcion->getCostoSala();
            }
        }
        return $costo;
    }

    /**
     * Retorna un strin con la informacion de los teatros cargados
     * @return string
     */
    public function mostrarTeatros(){
        /**
         * @var object $objTeatro
         * @var array $colTeatro
         * @var string $strTeatros
         */
        $objTeatro=new Teatro();
        $colTeatro=$objTeatro->listar();
        $strTeatros="Teatros: \n";
        foreach($colTeatro as $teatro){
            $strTeatros.="* \n".$teatro;
        }
        return $strTeatros;
    }


}



?>