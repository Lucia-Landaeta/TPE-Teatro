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
                cargaTeatroAuto($t);
                break; //solo para facilitar el testeo
            case 3:
                modificarNombreTeatro($t);
                break; 
            case 4:
                modificarDireccionTeatro($t);
                break;
            case 5:
                cambiarNombreFuncion($t);
                break;
            case 6:
                cambiarPrecioFuncion($t);
                break;
            case 7:
                mostrarInformacion($t);
                break;
        }
    } while ($opcion != 8);
}

/**
 * Funcion que muestra un menu y permitiendo elegir una de las opciones
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
    echo" 1. Cargar Teatro (manual)" . "\n" .
        " 2. Carga automatica del Teatro" . "\n" .
        " 3. Cambiar nombre del teatro" . "\n" .
        " 4. Cambiar direccion del teatro" . "\n" .
        " 5. Cambiar nombre de la funcion" . "\n" .
        " 6. Cambiar precio de la funcion" . "\n" .
        " 7. Mostrar informacion del teatro" . "\n" .
        " 8. Salir" . "\n";
    echo "-----------------------------------" . "\n";

    do {
        $opcion = trim(fgets(STDIN));

        if ($opcion >= 1 && $opcion <= 8) {
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
     * @var string $nombreF
     * @var float $precioF
     * @var int $i
     */
    echo "Ingrese nombre del teatro:" . "\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese direccion del teatro:" . "\n";
    $direccion = trim(fgets(STDIN));
    $t->cargarTeatro($nombre, $direccion);

    echo "Cargar las cuatro funciones" . "\n";

    for ($i = 0; $i < 4; $i++) {
        echo "Funcion " . ($i + 1) . "\n";
        echo "Ingrese nombre de la funcion" . "\n";
        $nombreF = trim(fgets(STDIN));
        echo "Ingrese precio de la funcion" . "\n";
        $precioF = trim(fgets(STDIN));
        $t->cargarFuncion($i, $nombreF, $precioF);
    }
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
    echo" * Modificacion exitosa *"."\n";
}

/**
 * Funcion que modifica la direccion del teatro
 * @param object $t
 */
function modificarDireccionTeatro($t)
{
    /**
     * @var $nuevaDirec
     */
    echo "Ingrese la nueva direccion del teatro" . "\n";
    $nuevaDirec = trim(fgets(STDIN));
    $t->cambiarDireccionTeatro($nuevaDirec);
    echo" * Modificacion exitosa *"."\n";
}

/**
 * @param object $t
 */
function cambiarNombreFuncion($t)
{
    /**
     * Funcion de cambia el nombre de la funcion
     * @var int $i
     * @var boolean $exito
     * @var string $viejaFuncion
     * @var string $nuevaFuncion
     */
    echo "Ingrese nombre de la función a modificar entre:" . "\n";
    echo "'' ";
    for ($i = 0; $i < 4; $i++) {
        echo $t->getColFunciones()[$i]["nombre"] . " - ";
    }
    echo " ''" . "\n";
    $viejaFuncion = trim(fgets(STDIN));
    echo "\n" . "Ingrese el nuevo nombre de la función" . "\n";
    $nuevaFuncion = trim(fgets(STDIN));
    $exito=$t->cambiarNombreFuncion($viejaFuncion, $nuevaFuncion);
    if($exito){
        echo " * Modificacion exitosa *"."\n"; 
     }else{
         echo " * Modificacion Fallida: la funcion a modificar no existe *"."\n";
     }
}

/**
 * Funcion que cambia el precio de una funcion
 * @param object $t
 */
function cambiarPrecioFuncion($t)
{
    /**
     * @var int $i
     * @var boolean $exito
     * @var string $nomFuncion
     * @var float $nuevoPrecio
     */
    echo "Ingrese nombre de la función a modificar entre:" . "\n";
    echo "'' ";
    for ($i = 0; $i < 4; $i++) {
        echo $t->getColFunciones()[$i]["nombre"] . " -";
    }
    echo " ''" . "\n";
    $nomFuncion = trim(fgets(STDIN));
    echo "\n" . "Ingrese el nuevo precio de la función" . "\n";
    $nuevoPrecio = trim(fgets(STDIN));
    $exito=$t->cambiarPrecioFuncion($nomFuncion, $nuevoPrecio);
    if($exito){
       echo " * Modificacion exitosa *"."\n"; 
    }else{
        echo " * Modificacion Fallida: la funcion a modificar no existe *"."\n";
    }
}

/**
 * Funcion que carga un teatro con valores por defecto
 * @param object $t
 */
function cargaTeatroAuto($t)
{
    /**
     * @var array $funciones
     */
    $t->cargarTeatro("Arca", "Colon 1234");
    $funciones = [
        ["nombre" => "La divina comedia", "precio" => 530],
        ["nombre" => "El mago Merlin y el rey Arthuro", "precio" => 670],
        ["nombre" => "Hamblet", "precio" => 590],
        ["nombre" => "El fantasma de la opera", "precio" => 720]
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

