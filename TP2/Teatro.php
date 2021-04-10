<?php
include "Funcion.php";
class Teatro
{
    //Atributos de clase
    /** 
     * @var string $nombre
     * @var string $direccion
     * @var array $colFunciones
     */

    private $nombre;
    private $direccion;
    private $colFunciones;

    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        $this->nombre = "";
        $this->direccion = "";
        $this->colFunciones = array();
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase 

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @return array
     */
    public function getColFunciones()
    {
        return $this->colFunciones;
    }


    //Modifican los atributos de clase

    /**
     * @param string $nom
     */
    public function setNombre($nom)
    {
        $this->nombre = $nom;
    }

    /**
     * @param string $direc
     */
    public function setDireccion($direc)
    {
        $this->direccion = $direc;
    }

    /**
     * @param array $cFunciones
     */
    public function setColFunciones($cFunciones)
    {
        $this->colFunciones = $cFunciones;
    }

    /**
     * Carga los valores del teatro 
     * @param string $nom
     * @param string $direc
     */
    public function cargarTeatro($nom, $direc)
    {
        $this->setNombre($nom);
        $this->setDireccion($direc);
    }

    /**
     * Carga los valores de la funcion
     * @param int $pos 
     * @param string $nombreFuncion
     * @param int $hsInicio
     * @param int $duracion
     * @param float $precio
     * @return boolean 
     */
    public function cargarFuncion($pos, $nombreFuncion, $hsInicio, $duracion, $precio)
    {
        /**
         * @var boolean $exito
         * @var array $funciones
         * @var boolean $verificacion
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $verificacion = $this->verificarDisponibilidad($hsInicio, $duracion);
        if ($verificacion) {
            $funciones[$pos] = new Funcion($nombreFuncion, $hsInicio, $duracion, $precio);
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }

    /**
     * Verifica que el horario de una funcion no se solape con los horarios de las funciones existentes en la coleccion
     * @param int $hsInicio
     * @param int $duracion
     * @return boolean 
     */
    public function verificarDisponibilidad($hsInicio, $duracion)
    {
        /**
         * @var boolean $verif 
         * @var int $finFuncion
         * @var int $i
         * @var array $funciones
         * @var int $inicio
         * @var int $final
         */
        $verif = true;
        $finFuncion = $hsInicio + $duracion;
        $i = 0;
        $funciones = $this->getColFunciones();
        while ($verif && $i < count($funciones)) {
            $inicio = $funciones[$i]->getHorarioInicio();
            $final = $inicio + $funciones[$i]->getDuracion();
            if (($hsInicio >= $inicio && $hsInicio <= $final) ||
                ($finFuncion >= $inicio && $finFuncion <= $final)
            ) {
                $verif = false;
            }
            $i++;
        }
        return $verif;
    }


    /**
     *Func. Modifica el nombre del teatro
     * @param string $nomb
     */
    public function cambiarNombreTeatro($nom)
    {
        $this->setNombre($nom);
    }

    /**
     * Func. Modifica la direccion del teatro
     */
    public function cambiarDireccionTeatro($direc)
    {
        $this->setDireccion($direc);
    }

    /**
     * Func. cambia el nombre de una funcion 
     * @param string $nuevoNombre
     * @param int $horario
     * @param string $nomFuncion
     * @return boolean
     */
    public function cambiarNombreFuncion($nomFuncion, $horario, $nuevoNombre)
    {
        /**
         * @var boolean $exito
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $pos = $this->localizarFuncion($nomFuncion, $horario);

        if ($pos != -1) { //si la funcionn existe
            $funciones[$pos]->cambiarNombre($nuevoNombre);
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }


    /**
     * Func. cambia el precio de una funcion 
     * @param string $nomFuncion
     * @param int $horario 
     * @param string $nuevoPrecio
     * @return boolean
     */
    public function cambiarPrecioFuncion($nomFuncion, $horario, $nuevoPrecio)
    {
        /**
         * @var boolean $exito
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $pos = $this->localizarFuncion($nomFuncion, $horario);

        if ($pos != -1) { //si la funcionn existe
            $funciones[$pos]->cambiarPrecio(round($nuevoPrecio, 2));
            $this->setColFunciones($funciones);
            $exito = true;
        }

        return $exito;
    }

    /**
     *Localiza la funcion recibida por parametro y retorna su posicion. Si no la encuentra retorna -1
     * @param string $nombre
     * @param int $horario
     * @return int
     */
    public function localizarFuncion($nombre, $horario)
    {
        /**
         * @var boolean $existe
         * @var int $i 
         * @var int $pos
         * @var array $funciones
         */
        $existe = false;
        $i = 0;
        $pos = -1;
        $funciones = $this->getColFunciones();
        while (!$existe && $i < count($funciones)) {
            if (strtolower($funciones[$i]->getNombre()) == strtolower($nombre) && $funciones[$i]->getHorarioInicio() == $horario) {
                $existe = true;
                $pos = $i;
            }
            $i++;
        }
        return $pos;
    }


    /**
     * Retorna un string con la informacion de un teatro
     * @return string 
     */
    public function __toString()
    {
        /**
         * @var string $mensaje
         */
        $mensaje = "-NOMBRE DEL TEATRO: " . $this->getNombre() . "\n" .
            "-DIRECCION: " . $this->getDireccion() . "\n" . "-FUNCIONES:" . "\n" . "\n";
        for ($i = 0; $i < count($this->getColFunciones()); $i++) {
            $mensaje = $mensaje . "*" . $this->getColFunciones()[$i]->__toString() .
                "------------" . "\n";
        }
        return $mensaje;
    }
}
