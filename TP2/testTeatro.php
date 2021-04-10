<?php
include "Teatro.php";
//PROGRAMA PRINCIPAL
$t = new Teatro();
opcion($t);

/**
 * Funcion que llama al menu, y redirecciona segun la opcion recibida
 * @param object $t
 */
function opcion($t)
/**
 * @var int $opcion
 */
{
    do {
        $opcion = menu();
        switch ($opcion) {
            case 1:
                cargaTeatro($t);
                break;
            case 2:
                cargaFuncion($t);
                break;
            case 3:
                cargaAutomatica($t);
                break; //solo para facilitar el testeo
            case 4:
                modificarNombreTeatro($t);
                break;
            case 5:
                modificarDireccionTeatro($t);
                break;
            case 6:
                cambiarNombreFuncion($t);
                break;
            case 7:
                cambiarPrecioFuncion($t);
                break;
            case 8:
                mostrarInformacion($t);
                break;
        }
    } while ($opcion != 9);
}

/**
 * Funcion que muestra un menu, permitiendo elegir una de las opciones
 * @return int
 */
function menu()
{
    /**
     * @var int $opcion
     * @var boolean $esValido
     */
    $esValido = false;
    echo "Seleccione una opcion:" . "\n";
    echo "-----------------------------------" . "\n";
    echo " 1. Cargar Teatro (manual)" . "\n" .
        " 2. Cargar Funcion (manual)" . "\n" .
        " 3. Carga Automatica" . "\n" .
        " 4. Cambiar nombre del Teatro" . "\n" .
        " 5. Cambiar direccion del Teatro" . "\n" .
        " 6. Cambiar nombre de la Funcion" . "\n" .
        " 7. Cambiar precio de la Funcion" . "\n" .
        " 8. Mostrar informacion del teatro" . "\n" .
        " 9. Salir" . "\n";
    echo "-----------------------------------" . "\n";

    do {
        $opcion = trim(fgets(STDIN));

        if ($opcion >= 1 && $opcion <= 9) {
            $esValido = true;
        } else {
            echo "Ingrese una opcion valida." . "\n";
        }
    } while (!$esValido);

    return $opcion;
}

/**
 * Funcion que carga los datos solicitados del teatro
 * @param object $t
 */
function cargaTeatro($t)
{
    /**
     * @var string $nombre
     * @var string $direccion
     */
    echo "Ingrese nombre del teatro:" . "\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese direccion del teatro:" . "\n";
    $direccion = trim(fgets(STDIN));
    $t->cargarTeatro($nombre, $direccion);
}

/**
 * Func. Carga una funcion y muestra si la operacion tuvo exito
 * @param object $t
 */
function cargaFuncion($t)
{
    /**
     * @var boolean $exito
     */

    $exito = cargaDatosFuncion($t);

    if ($exito) {
        echo "* La funcion se cargo correctamente *" . "\n";
    } else {
        echo "* El horario de la funcion es invalido *" . "\n";
    }
}

/**
 * Func. pide y carga los datos de una funcion a la coleccion del Teatro
 * @param object $t
 */
function cargaDatosFuncion($t)
{
    /**
     * @var int $i
     * @var string $nombreF
     * @var int $hsInicio
     * @var int $mintInicio
     * @var int $hsDuracion
     * @var int $mintDuracion
     * @var float $precioF
     * @var int $inicio
     * @var int $duracion
     * @var boolean $exito
     */

    $i = count($t->getColFunciones());

    echo "Ingrese nombre de la funcion" . "\n";
    $nombreF = trim(fgets(STDIN));
    echo "Horario de la funcion: " . "\n";
    echo "Hora: " . "\n";
    $hsInicio = trim(fgets(STDIN));
    echo "Minutos: " . "\n";
    $mintInicio = trim(fgets(STDIN));
    echo "Duracion de la funcion: " . "\n";
    echo "Hora: " . "\n";
    $hsDuracion = trim(fgets(STDIN));
    echo "Minutos: " . "\n";
    $mintDuracion = trim(fgets(STDIN));
    echo "Ingrese precio de la funcion" . "\n";
    $precioF = trim(fgets(STDIN));

    $inicio = pasarASegundos($hsInicio, $mintInicio);
    $duracion = pasarASegundos($hsDuracion, $mintDuracion);

    $exito = $t->cargarFuncion($i, $nombreF, $inicio, $duracion, $precioF);

    return $exito;
}


/**
 * Funcion que modifica el nombre del teatro
 * @param object $t
 */
function modificarNombreTeatro($t)
{
    /**
     * @var string $nuevoNom
     */
    echo "Ingrese el nuevo nombre del teatro" . "\n";
    $nuevoNom = trim(fgets(STDIN));
    $t->cambiarNombreTeatro($nuevoNom);
    echo " * Modificacion exitosa *" . "\n";
}

/**
 * Funcion que modifica la direccion del teatro
 * @param object $t
 */
function modificarDireccionTeatro($t)
{
    /**
     * @var string $nuevaDirec
     */
    echo "Ingrese la nueva direccion del teatro" . "\n";
    $nuevaDirec = trim(fgets(STDIN));
    $t->cambiarDireccionTeatro($nuevaDirec);
    echo " * Modificacion exitosa *" . "\n";
}

/**
 * Func. cambia el nombre de una funcion y muestra si la operacion tuvo exito
 * @param object $t
 */
function cambiarNombreFuncion($t)
{
    /**
     * @var boolean $exito
     */

    mostrarFunciones($t);

    $exito = cargaDatosModificacion($t, 1);

    if ($exito) {
        echo " * Modificacion exitosa *" . "\n";
    } else {
        echo " * Modificacion Fallida: la funcion a modificar no existe *" . "\n";
    }
}


/**
 * Func. que cambia el precio de una funcion y muestra si la operacion tuvo exito
 * @param object $t
 */
function cambiarPrecioFuncion($t)
{
    /**
     * @var boolean $exito
     */

    mostrarFunciones($t);

    $exito = cargaDatosModificacion($t, 2);

    if ($exito) {
        echo " * Modificacion exitosa *" . "\n";
    } else {
        echo " * Modificacion Fallida: la funcion a modificar no existe *" . "\n";
    }
}

/**
 * Func. pide y carga los datos de una funcion a modificar
 * @param object $t
 * @param int $modif
 */
function cargaDatosModificacion($t, $modif)
{
    /**
     * @var string $nomFuncion
     * @var int $hora
     * @var int $minut
     * @var int $horario
     * @var string $nuevaFuncion
     * @var boolean $exito 
     * @var float $nuevoPrecio
     * @var 
     */

    echo " ''" . "\n";
    echo "Ingrese el nombre de la funcion a modificar" . "\n";
    $nomFuncion = trim(fgets(STDIN));
    echo "Horario de la funcion a modificar:" . "\n";
    echo "Ingrese Hora" . "\n";
    $hora = trim(fgets(STDIN));
    echo "Ingrese Minutos" . "\n";
    $minut = trim(fgets(STDIN));

    $horario = pasarASegundos($hora, $minut);
    if ($modif == 1) {
        echo "\n" . "Ingrese el nuevo nombre de la función" . "\n";
        $nuevaFuncion = trim(fgets(STDIN));
        $exito = $t->cambiarNombreFuncion($nomFuncion, $horario, $nuevaFuncion);
    } else {
        echo "\n" . "Ingrese el nuevo precio de la función" . "\n";
        $nuevoPrecio = trim(fgets(STDIN));
        $exito = $t->cambiarPrecioFuncion($nomFuncion, $horario, $nuevoPrecio);
    }

    return $exito;
}

/**
 * Func. Muestra la informacion de las funciones que se pueden modificar
 * @param object $t
 */
function mostrarFunciones($t)
{
    /**
     * @var array $funciones
     * @var int $i
     */

    echo "Ingrese nombre y horario de la función a modificar entre:" . "\n";
    
    $funciones = $t->getColFunciones();
    for ($i = 0; $i < count($funciones); $i++) {
        echo "* " . $funciones[$i]->getNombre() . " - " . "Inicio: " .
            intdiv($funciones[$i]->getHorarioInicio(), 3600) . ":" .
            intdiv($funciones[$i]->getHorarioInicio() % 3600, 60) . "\n";
    }
}


/**
 * Funcion que carga un teatro con valores por defecto
 * @param object $t
 */
function cargaAutomatica($t)
{
    /**
     * @var array $funciones
     */
    $t->cargarTeatro("Arca", "Colon 1234");
    $funciones = [
        new Funcion("La divina comedia", 39600, 3600, 890.45), //Horario 11 a 12
        new Funcion("El mago Merlin y el rey Arthuro", 52200, 7200, 785), //Horario 14:30 a 16:30
        new Funcion("Hamblet", 59700, 3600, 940), //Horario 16:35 a 17:35
        new Funcion("El fantasma de la opera", 64800, 9000, 998), //Horario 18:00 a 19:30
        new Funcion("Hamblet", 72000, 3600, 970) //Horario 20:00 a 21:30
    ];

    $t->setColFunciones($funciones);
}

/**
 * Funcion que muestra la informacion de un teatro
 * @param object $t
 */
function mostrarInformacion($t)
{
    echo $t->__toString();
}

/**
 * Func. Que pasa un horario de Hs:Mint a su equivalente en segundos
 * @param int $hs
 * @param int $mint
 * @return int
 */
function pasarASegundos($hs, $mint)
{
    /**
     * @var int $segTotales
     */
    $segTotales = ($hs * 3600) + ($mint * 60);

    return $segTotales;
}