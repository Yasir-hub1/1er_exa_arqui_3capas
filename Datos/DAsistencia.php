<?php

namespace Datos;

use DB\Conexion;

class DAsistencia
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new Conexion;
    }


    public function DconfirmarAsistencia($id_invitado,$id_evento,$fecha){
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "INSERT INTO asistencia (id_invitado, id_evento, fecha) VALUES (?, ?, ?)";
            $params = [$id_invitado,$id_evento,$fecha]; // Crea un array con los parámetros
            $stmt = $this->conexion->consultarBD($query, $params);
            // $stmt->execute();
            $stmt->closeCursor();
            return "Asistencia Registrada";
        } else {
            $this->conexion->close();
            return "Hubo un error al Registrar Asistencia";
        }
    }
}
