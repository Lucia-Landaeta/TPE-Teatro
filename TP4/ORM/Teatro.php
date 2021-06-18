<?php
class Teatro{
    //Atributos de clase
    /** 
     * @var string $idTeatro
     * @var string $nombre
     * @var string $direccion
     * @var array $colFunciones
     * @var string $mensajeoperacion
     */

    private $idTeatro;
    private $nombre;
    private $direccion;
    private $colFunciones;
    private $mensajeoperacion;

    /** Constructor de la clase  */
    public function __construct(){
        $this->idTeatro=0;
        $this->nombre = "";
        $this->direccion = "";
        $this->colFunciones = array();
    }

    /**
     * Carga los valores del teatro 
     * @param string $nom
     * @param string $direc
     */
    public function cargarTeatro($nom, $direc){
        $this->setNombre($nom);
        $this->setDireccion($direc);
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase 
    /** @return int */
    public function getIdTeatro(){
        return $this->idTeatro;
    }
    /** @return string */
    public function getNombre(){
        return $this->nombre;
    }
    /** @return string */
    public function getDireccion(){
        return $this->direccion;
    }
    /** @return array */
    public function getColFunciones(){
        /**
         * @var object $nuevoCine, $nuevaObra, $nuevoMusical
         * @var string $consicion
         * @var array $colCine, $colMusical, $colObra, $colFunciones
         */
        if(count($this->colFunciones)==0){
            $nuevoCine=new Cine();
            $nuevoMusical=new Musical();
            $nuevaObra=new ObraTeatro();
            
            $condicion="idTeatro='".$this->getIdTeatro()."'";
            $colCine=$nuevoCine->listar($condicion);
            $colMusical=$nuevoMusical->listar($condicion);
            $colObra=$nuevaObra->listar($condicion);
            $colFunciones=array_merge($colCine,$colMusical,$colObra);
            $this->setColFunciones($colFunciones);
        }
        return $this->colFunciones;
    }
    /** @return string */
    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    //Modifican los atributos de clase
    /** @param int $idT */
    public function setIdTeatro($idT){
        $this->idTeatro=$idT;
    }
    /** @param string $nom */
    public function setNombre($nom){
        $this->nombre = $nom;
    }
    /** @param string $direc*/
    public function setDireccion($direc){
        $this->direccion = $direc;
    }
    /** @param array $cFunciones*/
    public function setColFunciones($cFunciones){
        $this->colFunciones = $cFunciones;
    }
    /** @param string $menaje */
    public function setMensajeOperacion($menaje){
        $this->mensajeoperacion = $menaje;
    }

    /**
     * Retorna un string con la informacion de un teatro
     * @return string 
     */
    public function __toString(){
        /**
         * @var string $mensaje
         */
        $mensaje = "-ID: ".$this->getIdTeatro()."\n".
        "-NOMBRE DEL TEATRO: " . $this->getNombre() . "\n" .
        "-DIRECCION: " . $this->getDireccion() . "\n" ;
        //     "-FUNCIONES:" . "\n" . "\n";
        // for ($i = 0; $i < count($this->getColFunciones()); $i++) {
        //     $mensaje = $mensaje . "*" . $this->getColFunciones()[$i]->__toString() .
        //         "------------" . "\n";
        // }
        return $mensaje;
    }

    /**
     * Inserta un teatro en la BD
     * @return boolean 
     */
    public function insertar(){
        /**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consultaInsertar
		 */
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO teatro(nombre, direccion) VALUES (" . "'" . $this->getNombre() . "'" . ",'" . $this->getDireccion() . "')";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /**
     * Realiza una modificacion de un registro de la BD
     * @return boolean 
     */
    public function modificar(){
        /**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consultaModifica
		 */
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE teatro SET idTeatro=".$this->getIdTeatro(). ",nombre=" . "'" . $this->getNombre() . "'" . ",direccion=" . "'" . $this->getDireccion() . "'" . " WHERE idTeatro=" . "'" . $this->getIdTeatro() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /**
     * Elimina un registro de la BD
     * @return boolean 
     */
    public function eliminar(){
        /**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consultaBorra
		 */
        $base = new BaseDatos();
        $resp = true;
        $i = 0;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM teatro WHERE idTeatro=" . "'" . $this->getIdTeatro() . "'";
            while ($resp && $i < count($this->getColFunciones())) {
                $resp = $this->getColFunciones()[$i]->eliminar();
                $i++;
            }
            if ($base->Ejecutar($consultaBorra)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /**
	 * Recupera los datos de un teatro por su nombre
	 * @param string
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */	
    public function Buscar($idT){
        /**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consulTeatro
		 */
        $base = new BaseDatos();
        $consultaTeatro = "Select * from teatro where idTeatro=" . "'" . $idT . "'";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaTeatro)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdTeatro($row2['idTeatro']);
                    $this->setNombre($row2['nombre']);
                    $this->setDireccion($row2['direccion']);                    
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /**
     * Retorna un string con la info de los teatros cargados
     * @param string 
     * @return string 
     */
    public function listar($condicion = ""){
        /**
		 * @var object $base
		 * @var array $arregloTeatro
		 * @var string $consultaInsertar
		 */
        $arregloTeatro = null;
        $base = new BaseDatos();
        $consultaTeatro = "Select * from teatro ";
        if ($condicion != "") {
            $consultaTeatro = $consultaTeatro . ' where ' . $condicion;
        }
        $consultaTeatro .= " order by idTeatro ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaTeatro)) {
                $arregloTeatro = array();
                while ($row2 = $base->Registro()) {
                    $idT=$row2['idTeatro'];
                    $nombre = $row2['nombre'];
                    $direccion = $row2['direccion'];

                    $teatro = new Teatro();
                    $teatro->cargarTeatro($nombre, $direccion);
                    $teatro->setIdTeatro($idT);
                    array_push($arregloTeatro,$teatro);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloTeatro;
    }
}
