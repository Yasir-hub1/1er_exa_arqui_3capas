<?php

namespace Datos;

use Conexion;

include("DB/Conexion.php");
class DCategoria
{
    private $conexion;
    /* Declarando variables */
    private $idCategoria;
    private $nombre;

    public function __construct()
    {
        $this->conexion = new Conexion;
    }

    public function listar()
    {
        $obj = $this->conexion->connect();
        if ($obj) {
            $query = "select * from categoria";
            $resultado = $this->conexion->Consulta($query);
            $this->conexion->close();
            return $resultado;
        } else {
            $this->conexion->close();
            echo "Error de conexion de DB en DCategoria";
        }
    }
}
