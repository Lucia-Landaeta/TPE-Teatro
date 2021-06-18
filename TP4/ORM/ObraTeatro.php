<?php

class ObraTeatro extends Funcion{
    /** Constructor de la clase  */
    public function __construct(){
        parent::__construct();
    }

	/** 
	 * Carga una obra de teatro
	 * @param array $datos
	 */
    public function cargar($datos){
        parent::cargar($datos); 
    }

    /**
     * Retorna un string con la informacion de la obra de teatro
     * @return string
     */
    public function __toString(){
        return "Obra de teatro"."\n".parent::__toString();
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
		    $consultaInsertar="INSERT INTO ObraTeatro(idFuncion)
				VALUES (".parent::getIdFuncion().")";
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
     * Elimina un registro de la BD
     * @return boolean 
     */
    public function eliminar(){
		/**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consultaBorra
		 */
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM obraTeatro WHERE idFuncion=".parent::getIdFuncion();
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
	 * Recupera los datos de una obra de teatro por su id
	 * @param int 
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		/**
		 * @var object $base
		 * @var boolean $resp
		 * @var string $consulta
		 */
		$base=new BaseDatos();
		$consulta="Select * from obraTeatro where idFuncion=".$id;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($id);
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
	 * Retorna un string con obras de teatros
	 * @param string 
	 * @return array
	 */
    public function listar($condicion=""){
		/**
		 * @var object $base
		 * @var array $arreglo
		 * @var string $consulta
		 */
	    $arreglo = null;
		$base=new BaseDatos();

		$consulta="SELECT * FROM obraTeatro INNER JOIN funcion ON obraTeatro.idFuncion=funcion.idFuncion ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by obraTeatro.idFuncion ";
		// echo$consulta."\n";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ObraTeatro();
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