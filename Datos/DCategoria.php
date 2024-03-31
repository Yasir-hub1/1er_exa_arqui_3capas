<?php
namespace Datos;
use Datos\Conexion;

include("DConexion.php");
class DCategoria {
    /* Declarando variables */
    private $idCategoria;
    private $nombre;


    private function sql($query){
        $obj =new Conexion();
        return $obj->Consulta($query);
    }

    public function listar(){
        $query="select * from categoria";
        return $this->sql($query);
    }
}