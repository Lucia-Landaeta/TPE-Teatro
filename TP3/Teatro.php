<?php
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


    //METODOS DE LA CLASE

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
     * @param string $fecha
     * @return boolean 
     */
    public function cargarFuncion($pos, $nombreFuncion, $hsInicio, $duracion, $precio, $fecha)
    {
        /**
         * @var boolean $exito
         * @var array $funciones
         * @var boolean $verificacion
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $verificacion = $this->verificarDisponibilidad($hsInicio, $duracion, $fecha);
        if ($verificacion) {
            $funciones[$pos] = new ObraTeatro($nombreFuncion, $hsInicio, $duracion, $precio, $fecha);
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }

    /**
     * Carga los valores de un Musical
     * @param int $pos 
     * @param string $nombreFuncion
     * @param int $hsInicio
     * @param int $duracion
     * @param float $precio
     * @param string $fecha
     * @param string $directorMusc
     * @var int $persEscena
     * @return boolean 
     */
    public function cargarMusical($pos, $nombreFuncion, $hsInicio, $duracion, $precio, $fecha, $directorMusc, $persEscena)
    {
        /**
         * @var boolean $exito
         * @var array $funciones
         * @var boolean $verificacion
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $verificacion = $this->verificarDisponibilidad($hsInicio, $duracion, $fecha);
        if ($verificacion) {
            $funciones[$pos] = new Musical($nombreFuncion, $hsInicio, $duracion, $precio, $fecha, $directorMusc, $persEscena);
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }

    /**
     * Carga los valores de una funcion de Cine
     * @param int $pos 
     * @param string $nombreFuncion
     * @param int $hsInicio
     * @param int $duracion
     * @param float $precio
     * @param string $fecha
     * @param string $generoPeli
     * @param string $paisOrigenPeli
     * @return boolean 
     */
    public function cargarCine($pos, $nombreFuncion, $hsInicio, $duracion, $precio, $fecha, $generoPeli, $paisOrigenPeli)
    {
        /**
         * @var boolean $exito
         * @var array $funciones
         * @var boolean $verificacion
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $verificacion = $this->verificarDisponibilidad($hsInicio, $duracion, $fecha);
        if ($verificacion) {
            $funciones[$pos] = new Cine($nombreFuncion, $hsInicio, $duracion, $precio, $fecha, $generoPeli, $paisOrigenPeli);
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }


    /**
     * Verifica que el horario de una funcion no se solape en una determinada fecha con los horarios de las funciones existentes en la coleccion
     * @param int $hsInicio
     * @param int $duracion
     * @param string $fecha
     * @return boolean 
     */
    public function verificarDisponibilidad($hsInicio, $duracion, $fecha)
    {
        /**
         * @var boolean $verif 
         * @var int $finFuncion
         * @var int $i
         * @var array $funciones
         * @var int $inicio
         * @var int $final
         * @var string $fechaFunc
         */
        $verif = true;
        $finFuncion = $hsInicio + $duracion;
        $i = 0;
        $funciones = $this->getColFunciones();
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
     *Func. Modifica el nombre del teatro
     * @param string $nomb
     */
    public function cambiarNombreTeatro($nom)
    {
        $this->setNombre($nom);
    }

    /**
     * Func. Modifica la direccion del teatro
     * @param string $direc
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
     * @param string $fecha
     * @return boolean
     */
    public function cambiarNombreFuncion($nomFuncion, $fecha, $horario, $nuevoNombre)
    {
        /**
         * @var boolean $exito
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $pos = $this->localizarFuncion($nomFuncion, $fecha, $horario);

        if ($pos != -1) {   //si la funcionn existe
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
     * @param string $fecha
     * @return boolean
     */
    public function cambiarPrecioFuncion($nomFuncion, $fecha, $horario, $nuevoPrecio)
    {
        /**
         * @var boolean $exito
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();
        $pos = $this->localizarFuncion($nomFuncion, $fecha, $horario);

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
    public function localizarFuncion($nombre, $fecha, $horario)
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
            if (
                strtolower($funciones[$i]->getNombre()) == strtolower($nombre) &&
                $funciones[$i]->getFecha() == $fecha &&
                $funciones[$i]->getHorarioInicio() == $horario
            ) {
                $existe = true;
                $pos = $i;
            }
            $i++;
        }
        return $pos;
    }

    /**
     * Retorna el costo de usar el teatro(el costo se obtiene sumamdo los precios de cada tipo de actividad programada con sus respetivos incrementos)
     * @param int $mes
     * @return float
     */
    public function darCostoTeatro($mes)
    {
        /**
         * @var float $costo
         * @var int $mesFuncion
         * @var int $fechaEntero
         * @var object $funcion 
         */
        $costo = 0;
        foreach ($this->getColFunciones() as $funcion) {
            $fechaEntero = strtotime($funcion->getfecha());
            $mesFuncion = date('m', $fechaEntero);

            if ($mesFuncion == $mes) {
                $costo = $costo + $funcion->darCosto();
            }
        }
        return $costo;
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
