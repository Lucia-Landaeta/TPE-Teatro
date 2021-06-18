<?php
class Funcion{
    //Atributos de clase
    /** 
     * @var string $idFuncion
     * @var string $nombre
     * @var int $horarioInicio
     * @var int $duracion
     * @var float $precio
     * @var float $costoSala
     * @var string $fecha
     * @var object $objTeatro
     * @var string $mensajeoperacion
     */

    private $idFuncion;
    private $nombre;
    private $horarioInicio;
    private $duracion;
    private $precio;
    private $costoSala;
    private $fecha;
    private $objTeatro;
    private $mensajeoperacion;

    /** Constructor de la clase */
    public function __construct(){
        $this->idFuncion = 0;
        $this->nombre = "";
        $this->horarioInicio = "";
        $this->duracion = 0;
        $this->precio = 0;
        $this->costoSala = 0;
        $this->fecha = 0;
        $this->objTeatro = null;
    }

    /** 
     * Carga una funcion 
     * @param array
     */
    public function cargar($datos){
        $this->setNombre($datos["nombre"]);
        $this->setHorarioInicio($datos["hsInicio"]);
        $this->setDuracion($datos["duracion"]);
        $this->setPrecio($datos["precio"]);
        $this->setFecha($datos["fecha"]);
        $this->setObjTeatro($datos["teatro"]);
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase 
    /** @return string */
    public function getIdFuncion()    {
        return $this->idFuncion;
    }
    /** @return string*/
    public function getNombre(){
        return $this->nombre;
    }
    /** @return int */
    public function getHorarioInicio(){
        return $this->horarioInicio;
    }
    /** @return int */
    public function getDuracion(){
        return $this->duracion;
    }
    /** @return float */
    public function getPrecio(){
        return $this->precio;
    }
    /** @return string*/
    public function getFecha(){
        return $this->fecha;
    }
    /** @return float */
    public function getCostoSala(){
        return $this->costoSala;
    }
    /** @return object */
    public function getObjTeatro(){
        return $this->objTeatro;
    }
    /** @return string  */
    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }
    //Modifican los atributos de clase
    /** @param string $idFuncion */
    public function setIdFuncion($id){
        $this->idFuncion = $id;
    }
    /** @param string $nom */
    public function setNombre($nom){
        $this->nombre = $nom;
    }
    /** @param int $hs */
    public function setHorarioInicio($hs){
        $this->horarioInicio = $hs;
    }
    /** @param int $durac */
    public function setDuracion($durac){
        $this->duracion = $durac;
    }
    /** @param float $prec */
    public function setPrecio($prec){
        $this->precio = $prec;
    }
    /** @param string $fech */
    public function setFecha($fech){
        $this->fecha = $fech;
    }
    /** @param float $costo */
    public function setCostoSala($costo){
        $this->costoSala = $costo;
    }
    /** @param object $teatro  */
    public function setObjTeatro($teatro){
        $this->objTeatro = $teatro;
    }
    /** @param string $menaje */
    public function setMensajeOperacion($menaje){
        $this->mensajeoperacion = $menaje;
    }


    /**
     * Retorna un string con la informacion de una funcion
     * @return string
     */
    public function __toString(){
        /**
         * @var int $inicioHs
         * @var int $inicioMint
         * @var int $duracionMint
         */
        $inicioHs = intdiv(intval($this->getHorarioInicio()), 3600);
        $inicioMint = intdiv((intval($this->getHorarioInicio()) % 3600), 60);
        $duracionMint = intdiv(intval($this->getDuracion()), 60);

        return "ID Funcion: " . $this->getIdFuncion() . "\n" .
            "Nombre: " . $this->getNombre() . "\n" .
            "Fecha: " . $this->getFecha() . "\n" .
            "Horario de inicio: " . $inicioHs . ":" . $inicioMint . "\n" .
            "Duracion de funcion: " . $duracionMint . " minutos" . "\n" .
            "Precio: $" . $this->getPrecio() . "\n" .
            "Costo sala: $" . $this->getCostoSala() . "\n" .
            "Teatro al que pertenece: " . $this->getObjTeatro()->getnombre() . "\n";
    }

    /**
     * Inserta una funcion en la BD
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
        $consultaInsertar = "INSERT INTO funcion(nombre, horarioInicio, duracion, precio, costoSala, fecha, idTeatro) 
				VALUES (" . "'" . $this->getNombre() . "','" . $this->getHorarioInicio() . "','" . $this->getDuracion() . "','"
            . $this->getPrecio() . "','" . $this->getCostoSala() . "','" . $this->getFecha() . "','" . $this->getObjTeatro()->getIdTeatro() . "')";

        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdFuncion($id);
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
         * @var boolean $resp
         * @var object $base
         * @var string $consultaModifica
         */
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE funcion SET nombre=" . "'" . $this->getNombre() . "',horarioInicio=" . $this->getHorarioInicio() . "
                           ,duracion=" . $this->getDuracion() . ",precio=" . $this->getPrecio() . ",costoSala=" . $this->getCostoSala() . "
                           ,fecha='" . $this->getFecha() . "',idTeatro='" . $this->getObjTeatro()->getIdTeatro() . "' WHERE idFuncion=" .  $this->getIdFuncion();
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
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM funcion WHERE idFuncion="  . $this->getIdFuncion();
            if ($this->getIdFuncion() != 0) {
                if ($base->Ejecutar($consultaBorra)) {
                    $resp =  true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    /**
     * Recupera los datos de una funcion por su id
     * @param int 
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($idF){
        /**
         * @var object $base
         * @var string $consultaPersona
         * @var boolean $resp
         */
        $base = new BaseDatos();
        $consultaPersona = "Select * from funcion where idFuncion=" . $idF;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdFuncion($idF);
                    $this->setNombre($row2['nombre']);
                    $this->setHorarioInicio($row2['horarioInicio']);
                    $this->setDuracion($row2['duracion']);
                    $this->setPrecio($row2['precio']);
                    $this->setCostoSala($row2['costoSala']);
                    $this->setFecha($row2['fecha']);

                    $idTeatro = $row2['idTeatro'];
                    $teatro = new Teatro();
                    $teatro->buscar($idTeatro);

                    $this->setObjTeatro($teatro);
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
     * Retorna un array de funciones que cumplan con una determinada condicion
     * @param string 
     * @return array
     */
    public function listar($condicion = ""){
        /**
         * @var string $consultaFuncion
         * @var object $base
         * @var array $arregloFuncion
         */
        $arregloFuncion = null;
        $base = new BaseDatos();
        $consultaFuncion = "Select * from funcion ";
        if ($condicion != "") {
            $consultaFuncion = $consultaFuncion . ' where ' . $condicion;
        }
        $consultaFuncion .= " order by idFuncion ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaFuncion)) {
                $arregloFuncion = array();
                while ($row2 = $base->Registro()) {

                    $id = $row2['idFuncion'];
                    $nombreF = $row2['nombre'];
                    $hsIni = $row2['horarioInicio'];
                    $duracionF = $row2['duracion'];
                    $precioF = $row2['precio'];
                    $costoSalaF = $row2['costoSala'];
                    $fechaF = $row2['fecha'];
                    $idTeatro = $row2['idTeatro'];

                    $objTeatro = new Teatro();
                    $objTeatro->buscar($idTeatro);

                    $func = new Funcion();
                    $datos = [
                        "nombre" => $nombreF, "hsInicio" => $hsIni, "duracion" => $duracionF, "precio" => $precioF, "costoSala" => $costoSalaF,
                        "fecha" => $fechaF, "teatro" => $objTeatro
                    ];
                    $func->cargar($datos);
                    $func->setIdFuncion($id);
                    array_push($arregloFuncion, $func);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloFuncion;
    }
}
