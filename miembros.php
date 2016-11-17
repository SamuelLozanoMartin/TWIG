<?php
class miembros{
    private $id;
    private $nombre;
    private $apellidos;
    private $fecha;

    public function __construct($id,$nombre,$apellidos,$fecha){
        $this->id=$id;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->fecha=$fecha;


    }

    function setId($id){
      $this->id = $id;
    }

    function getId(){
      return $this->id;
    }
    function setNombre($nombre) { 
      $this->nombre = $nombre; 
    }
    function getNombre() { 
      return $this->nombre; 
    }
    function setApellidos($apellidos) {
       $this->apellidos = $apellidos; 
    }
    function getApellidos() { 
      return $this->apellidos; 
    }
    function setFecha($fecha) { 
      $this->fecha = $fecha; 
    }
    function getFecha() { 
      return $this->fecha; 
    }


}
?>