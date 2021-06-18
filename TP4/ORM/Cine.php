<?php
class Cine extends Funcion{
    //Atributos de clase
    /**
     * @var string $genero
     * @var string $paisOrigen
     */
    private $genero;
    private $paisOrigen;

    /** Constructor de la clase  */
    public function __construct(){
        parent::__construct();
        $this->genero = "";
        $this->paisOrigen = "";
    }

	/**
	 * Carga una funcion de cine
	 * @param array $datos
	 */
    public function cargar($datos){
        parent::cargar($datos);
        $this->setGenero($datos["genero"]);
        $this->setPaisOrigen($datos["paisOrigen"]);
    }

    //METODOS DE ACCESO
    //Retornan el valor de los atributos de la clase
    /** @return string*/
    public function getGenero(){
        return $this->genero;
    }
    /** @return string */
    public function getPaisOrigen(){
        return $this->paisOrigen;
    }

    //Modifican los atributos de clase
    /** @param string $generoPeli  */
    public function setGenero($generoPeli){
        $this->genero = $generoPeli;
    }
    /** @param string $paisOrigenPeli */
    public function setPaisOrigen($paisOrigenPeli){
        $this->paisOrigen = $paisOrigenPeli;
    }

     /**
     * Retorna un string con la informacion de la funcion de Cine
     * @return string
     */
    public function __toString(){
        return "Pelicula"."\n".parent::__toString() . "Genero: " . $this->getGenero() . "\n" .
            "Pais de origen: " . $this->getPaisOrigen() . "\n";
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
		$base=new BaseDatos();
		$resp= false;

		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO cine(idFuncion, genero, paisOrigen)
				VALUES (".parent::getIdFuncion().",'".$this->getGenero()."','".$this->getPaisOrigen()."')";
		    if($base->Iniciar()){
		        if($base->Ejecutar($consultaInsertar)){
		            $resp=  true;
		        }	else {
		            $this->setmensajeoperacion($base->getError());
		        }
		    } else {
		        $this->setmensajeoperacion($base->getError());
		    }
		 }
		return $resp;
	}

	/**
     * Modifica un registro de la BD
     * @return boolean 
     */
    public function modificar(){
		/**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consultaModifica
		 */
	    $resp =false; 
	    $base=new BaseDatos();
	    if(parent::modificar()){
	        $consultaModifica="UPDATE cine SET genero='".$this->getGenero()."',"."paisOrigen='".$this->getPaisOrigen()."' WHERE idFuncion=". parent::getIdFuncion();
	        if($base->Iniciar()){
	            if($base->Ejecutar($consultaModifica)){
	                $resp=  true;
	            }else{
	                $this->setmensajeoperacion($base->getError());
	            }
	        }else{
	            $this->setmensajeoperacion($base->getError());
	        }
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
		 * @var string $consultaBorrar
		 */
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM cine WHERE idFuncion=".parent::getIdFuncion();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());	
				}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}

    /**
	 * Recupera los datos de una funcion de cine por su id
	 * @param int 
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		/**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consulta
		 * @var array $row2
		 */
		$base=new BaseDatos();
		$consulta="Select * from cine where idFuncion=".$id;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($id);
				    $this->setGenero($row2['genero']);
                    $this->setPaisOrigen($row2['paisOrigen']);
					$resp= true;
				}				
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }		
		 return $resp;
	}	
    
	/**
     * Retorna un array de funciones que cumplan con una determinada condicion
     * @param string 
     * @return array
     */
    public function listar($condicion=""){
		/**
		 * @var array $arreglo
		 * @var object $base
		 * @var string $consulta
		 */
	    $arreglo = null;
		$base=new BaseDatos();

		$consulta="SELECT * FROM cine INNER JOIN funcion ON cine.idFuncion=funcion.idFuncion ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by cine.idFuncion ";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Cine();
					$obj->Buscar($row2['idFuncion']);
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}



}