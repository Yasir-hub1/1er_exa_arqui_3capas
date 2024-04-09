<?php

namespace Datos;


use DB\Conexion;
use PDO;
use PDOException;

class DInvitado
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new Conexion;
    }


    public function Dregistrar($nombre, $correo, $telefono, $estado, $codigo, $id_evento)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "INSERT INTO invitado (nombre, correo, telefono, estado, codigo, id_evento) VALUES (?, ?, ?, ?, ?,?)";
            $params = [$nombre, $correo, $telefono, $estado, $codigo, $id_evento]; // Crea un array con los parámetros
            $stmt = $this->conexion->consultarBD($query, $params);
            // $stmt->execute();
            $stmt->closeCursor();
            return "Invitado Registrado";
        } else {
            $this->conexion->close();
            return "Hubo un error al Registrar el Invitado";
        }
    }



    public function DlistaInvitados($id_evento)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                // Preparar la consulta SQL
                $query = "SELECT  * FROM invitado  WHERE id_evento = :id";
                $stmt = $conexion->prepare($query);

                // Vincular el parámetro ID
                $stmt->bindParam(':id', $id_evento, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();
                // Obtener todos los resultados como un array
                $invitados = $stmt->fetchAll(PDO::FETCH_ASSOC);


                return $invitados;
            } catch (PDOException $e) {
                // Manejar errores de la consulta SQL
                return "Error al ejecutar la consulta: " . $e->getMessage();
            }
        } else {
            $this->conexion->close();
            return "Hubo un error al obtener invitados";
        }
    }


    public function DEliminarInvitado($id_invitado)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                // Preparar la consulta SQL
                $query = "DELETE FROM invitado WHERE id = :id";
                $stmt = $conexion->prepare($query);

                // Vincular el parámetro ID
                $stmt->bindParam(':id', $id_invitado, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();
                $this->conexion->close();
                return;
            } catch (PDOException $e) {
                // Manejar errores de la consulta SQL
                return "Error al ejecutar la consulta: " . $e->getMessage();
            }
        } else {
            $this->conexion->close();
            return "Hubo un error al cerrar la conexión";
        }
    }


    public function DObtenerInvitadoPorId($id_invitado)
    {
        
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                $query = "SELECT * FROM invitado WHERE id = :id";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id', $id_invitado, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();
                $this->conexion->close();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Manejar errores de la consulta SQL
                return "Error al ejecutar la consulta: " . $e->getMessage();
            }
        } else {
            $this->conexion->close();
            return "Hubo un error al consultar";
        }
    }


   /*  public function DActualizarInvitado($id_evento,$id_invitado,$nombre,$correo,$telefono){
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                $query = "UPDATE invitado SET id_evento = ?, nombre = ?, correo = ?, telefono = ? WHERE id = ?";
                $params = [$id_evento,$nombre,$correo,$telefono,$id_invitado];
                $stmt = $conexion->prepare($query); // Preparar la consulta
                $stmt->execute($params); // Ejecutar la consulta con los parámetros
                $stmt->closeCursor();
                return "Invitado actualizado";
            } catch (\PDOException $e) {
                return "Error al actualizar al Invitado: " . $e->getMessage();
            }
        } else {
            return "Hubo un error al conectar con la base de datos";
        }
    } */

    public function DActualizarInvitado($id_invitado, $nombre, $correo, $telefono){
      
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                $query = "UPDATE invitado SET nombre = ?, correo = ?, telefono = ? WHERE id = ?";
               
                // Cambiar el orden de los parámetros para que coincida con la consulta SQL
                $params = [$nombre, $correo, $telefono, $id_invitado];
                $stmt = $conexion->prepare($query); // Preparar la consulta
                $stmt->execute($params); // Ejecutar la consulta con los parámetros
               
                $stmt->closeCursor();
                return "Invitado actualizado";
            } catch (\PDOException $e) {
                return "Error al actualizar al Invitado: " . $e->getMessage();
            }
        } else {
            return "Hubo un error al conectar con la base de datos";
        }
    }


    public function DActualizarEstadoDeConfirmacion($id_invitado, $estadoEvento) {
       
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                $query = "UPDATE invitado SET estado = ? WHERE id = ?";
                $params = [$estadoEvento, $id_invitado];
                $stmt = $conexion->prepare($query); // Preparar la consulta
                $stmt->execute($params); // Ejecutar la consulta con los parámetros
                $stmt->closeCursor();
                return "Estado del invitado actualizado";
            } catch (\PDOException $e) {
                return "Error al actualizar el estado del evento: " . $e->getMessage();
            }
        } else {
            return "Hubo un error al conectar con la base de datos";
        }
    }
    
}
