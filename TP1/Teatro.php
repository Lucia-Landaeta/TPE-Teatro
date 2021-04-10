<?php
class Teatro
{
    private $nombre;
    private $direccion;
    private $colFunciones;

    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        /**
         * @var string $nombre
         * @var string $direccion
         * @var array $colFunciones
         */
        $this->nombre = "";
        $this->direccion = "";
        $this->colFunciones = [
            ["nombre" => "", "precio" => 0],
            ["nombre" => "", "precio" => 0],
            ["nombre" => "", "precio" => 0],
            ["nombre" => "", "precio" => 0]
        ];
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


    //Modofican los atributos de clase

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
     * @param string $funcion
     * @param float $precio
     */
    public function cargarFuncion($pos, $funcion, $precio)
    {
        /**
         * @var array $funciones
         */
        $funciones = $this->getColFunciones();
        $funciones[$pos]["nombre"] = $funcion;
        $funciones[$pos]["precio"] = round($precio, 2);

        $this->setColFunciones($funciones);
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
     * Func. modifica la direccion del teatro
     */
    public function cambiarDireccionTeatro($direc)
    {
        $this->setDireccion($direc);
    }

    /**
     * Func. cambia el nombre de una funcion 
     * @param string $nuevoNombre
     * @param string $nomFuncion
     * @return boolean
     */
    public function cambiarNombreFuncion($nomFuncion, $nuevoNombre)
    {
        /**
         * @var boolean $existe
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();

        $pos = $this->localizarFuncion($nomFuncion);
        if ($pos != -1) { //si la funcionn existe
            $funciones[$pos]["nombre"] = $nuevoNombre;
            $this->setColFunciones($funciones);
            $exito = true;
        }
        return $exito;
    }


    /**
     * Func. cambia el precio de una funcion 
     * @param string $nomFuncion
     * @param string $nuevoPrecio
     * @return boolean
     */
    public function cambiarPrecioFuncion($nomFuncion, $nuevoPrecio)
    {
        /**
         * @var boolean $exito
         * @var int $pos
         * @var array $funciones
         */
        $exito = false;
        $funciones = $this->getColFunciones();

        $pos = $this->localizarFuncion($nomFuncion);
        if ($pos != -1) { //si la funcionn existe
            $funciones[$pos]["precio"] = round($nuevoPrecio, 2);
            $this->setColFunciones($funciones);
            $exito = true;
        }

        return $exito;
    }

    /**
     *Localiza la funcion recibida por parametro y retorna su posicion. Si no la encuentra retorna -1
     * @param string $nombre
     * @return int
     */
    public function localizarFuncion($nombre)
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
            if (strtolower($funciones[$i]["nombre"]) == strtolower(($nombre))) {
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
            $mensaje = $mensaje . "*" . $this->getColFunciones()[$i]["nombre"] . "\n" .
                "  Precio: $" . $this->getColFunciones()[$i]["precio"] . "\n" .
                "------------" . "\n";
        }
        return $mensaje;
    }
}
