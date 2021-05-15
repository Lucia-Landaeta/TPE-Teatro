<?php
include_once "Teatro.php";
include_once "Funcion.php";
include_once "Musical.php";
include_once "Cine.php";
include_once "ObraTeatro.php";

//PROGRAMA PRINCIPAL
$t = new Teatro();
opcion($t);

/**---------- */

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
                cargaAutomatica($t);    //solo para facilitar el testeo
                break;
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
                darCostoDelTeatro($t);
                break;
            case 9:
                mostrarInformacion($t);
                break;
        }
    } while ($opcion != 10);
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
        " 8. Dar costo del uso del teatro" . "\n" .
        " 9. Mostrar informacion del teatro" . "\n" .
        " 10. Salir" . "\n";
    echo "-----------------------------------" . "\n";

    do {
        $opcion = trim(fgets(STDIN));

        if ($opcion >= 1 && $opcion <= 10) {
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
        echo "* La funcion se cargo correctamente *" . "\n" . "\n";
    } else {
        echo "* La fecha y horario de la funcion es invalido *" . "\n" . "\n";
    }
}

/**
 * Func. pide y carga los datos de una funcion a la coleccion del Teatro
 * @param object $t
 */
function cargaDatosFuncion($t)
{
    /**
     * @var int $i, $hsInicio, $mintInicio, $hsDuracion, $mintDuracion, $inicio, $duracion, $dia, $mes, $anio, $persEscena
     * @var string $nombreF, $tipoFuncion, $director, $genero, $origen
     * @var string $fecha
     * @var boolean $exito
     */

    $i = count($t->getColFunciones());

    echo "Ingrese el tipo de funcion a cargar: Musical, Cine, Obra." . "\n";
    $tipoFuncion = trim(fgets(STDIN));

    echo "Ingrese nombre de la funcion" . "\n";
    $nombreF = trim(fgets(STDIN));
    echo "Fecha de la funcion (numérica)" . "\n";
    echo "Dia: " . "\n";
    $dia = trim(fgets(STDIN));
    echo "Mes: " . "\n";
    $mes = trim(fgets(STDIN));
    echo "Año: " . "\n";
    $anio = trim(fgets(STDIN));
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

    $fecha = $dia . "-" . $mes . "-" . $anio;

    if (strtolower($tipoFuncion) == "musical") {
        echo "Ingrese director del Musical" . "\n";
        $director = trim(fgets(STDIN));
        echo "Cantidad de personas en escena:" . "\n";
        $persEscena = trim(fgets(STDIN));
        $exito = $t->cargarMusical($i, $nombreF, $inicio, $duracion, $precioF, $fecha, $director, $persEscena);
    } else if (strtolower($tipoFuncion) == "cine") {
        echo "Ingrese genero de la pelicula" . "\n";
        $genero = trim(fgets(STDIN));
        echo "Ingrese pais de origen de la pelicula" . "\n";
        $origen = trim(fgets(STDIN));
        $exito = $t->cargarCine($i, $nombreF, $inicio, $duracion, $precioF, $fecha, $genero, $origen);
    } else {
        $exito = $t->cargarFuncion($i, $nombreF, $inicio, $duracion, $precioF, $fecha);
    }
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
    echo " * Modificacion exitosa *" . "\n" . "\n";
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
    echo " * Modificacion exitosa *" . "\n" . "\n";
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
        echo " * Modificacion exitosa *" . "\n" . "\n";
    } else {
        echo " * Modificacion Fallida: la funcion a modificar no existe *" . "\n" . "\n";
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
        echo " * Modificacion exitosa *" . "\n" . "\n";
    } else {
        echo " * Modificacion Fallida: la funcion a modificar no existe *" . "\n" . "\n";
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
    echo "Ingrese el Nombre de la funcion a modificar" . "\n";
    $nomFuncion = trim(fgets(STDIN));
    echo "Fecha de la funcion a modificar" . "\n";
    echo "Ingrese dia" . "\n";
    $dia = trim(fgets(STDIN));
    echo "Ingrese mes: " . "\n";
    $mes = trim(fgets(STDIN));
    echo "Ingrese año: " . "\n";
    $anio = trim(fgets(STDIN));
    echo "Horario de la funcion a modificar:" . "\n";
    echo "Ingrese Hora" . "\n";
    $hora = trim(fgets(STDIN));
    echo "Ingrese Minutos" . "\n";
    $minut = trim(fgets(STDIN));
    $fecha = $dia . "-" . $mes . "-" . $anio;;
    $horario = pasarASegundos($hora, $minut);

    if ($modif == 1) {
        echo "\n" . "Ingrese el nuevo nombre de la función" . "\n";
        $nuevaFuncion = trim(fgets(STDIN));
        $exito = $t->cambiarNombreFuncion($nomFuncion, $fecha, $horario, $nuevaFuncion);
    } else {
        echo "\n" . "Ingrese el nuevo precio de la función" . "\n";
        $nuevoPrecio = trim(fgets(STDIN));
        $exito = $t->cambiarPrecioFuncion($nomFuncion, $fecha, $horario, $nuevoPrecio);
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

    echo "Ingrese nombre, fecha y horario de la función a modificar entre:" . "\n";

    $funciones = $t->getColFunciones();
    for ($i = 0; $i < count($funciones); $i++) {
        echo "* " . $funciones[$i]->getNombre() . " - " .
            "Fecha: " . $funciones[$i]->getFecha() .  " Inicio: " .
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
        //Enero
        new ObraTeatro("La divina comedia", 39600, 3600, 890.45, "7-1-2021"), // Horario 11 a 12
        //Febrero
        new ObraTeatro("Hamblet", 72000, 5400, 930, "21-2-2021"), //Horario 20:00 a 21:30
        //Marzo
        new Musical("Los miserables", 50400, 8400, 830, "20-3-2021", "Claude-Michel Schönberg", 320), //Horario 14 a 16:20
        //Abril---
        //Mayo
        new ObraTeatro("La divina comedia", 39600, 3600, 890.45, "14-5-2021"), //Horario 11 a 12
        new Cine("El Señor de los anillos", 64800, 12600, 890.45,  "15-5-2021", "Fantasía épica", "Estados Unidos"), //Horario 18 a 21:30
        //Junio
        new ObraTeatro("El mago Merlin y el rey Arthuro", 52200, 7200, 785, "8-6-2021"), //Junio Horario 14:30 a 16:30
        new Cine("El Señor de los anillos", 63000, 12600, 890.45, "10-6-2021", "Fantasía épica", "Estados Unidos"), //Horario 17:30 a 21
        //Julio---
        //Agosto
        new Musical("Los miserables", 50400, 8400, 830, "20-8-2021", "Claude-Michel Schönberg", 320), //Horario 14 a 16:20
        new ObraTeatro("Hamblet", 72000, 5400, 970, "29-8-2021"), //Horario 20:00 a 21:30
        //Septiembre
        new ObraTeatro("Hamblet", 59700, 5400, 940, "2-9-2021"), //Horario 16:35 a 18:05
        //Octubre
        new Musical("Cats", 52200, 8100, 830, "23-10-2021", "Andrew Lloyd Webber", 407), //Horario  14:30 a 16:45
        //Noviembre
        new ObraTeatro("El mago Merlin y el rey Arthuro", 52200, 7200, 830,  "23-11-2021"), //Horario 14:30 a 16:30
        //Diciembre
        new Cine("La Liga de la Justicia de Zack Snyder", 54000, 12600, 580, "17-12-2021", "SuperHeroes", "Estados Unidos") //Horario 15 a 18:30

    ];

    $t->setColFunciones($funciones);
}

/**
 * Muestra el costo final del uso del teatro para un mes dado
 * @param object $t
 */
function darCostoDelTeatro($t)
{
    /**
     * @var int $mes
     * @var float $costoFinal
     */

    echo "Ingrese mes (1-12) del que quiere conocer el costo: " . "\n";
    $mes = trim(fgets(STDIN));
    $costoFinal = $t->darCostoTeatro($mes);

    echo "Costo del mes " . $mes . " $" . round($costoFinal, 2) . "\n" . "\n";
}

/**
 * Funcion que muestra la informacion de un teatro
 * @param object $t
 */
function mostrarInformacion($t)
{
    echo $t;
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
