<?php

namespace Datos;

use DB\Conexion;
use PDO;
use PDOException;


class DEvento
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new Conexion;
    }

    public function Dregistrar($nombre, $fecha, $ubicacion, $estado, $descripcion)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "INSERT INTO evento (nombre, fecha, ubicacion,estado,descripcion) VALUES (?, ?, ?, ?, ?)";
            $params = [$nombre, $fecha, $ubicacion, $estado, $descripcion]; // Crea un array con los parámetros
            $stmt = $this->conexion->consultarBD($query, $params);
            // $stmt->execute();
            $stmt->closeCursor();
            return "Evento Registrado";
        } else {
            $this->conexion->close();
            return "Hubo un error al Registrar el Evento";
        }
    }


    public function DobtenerEventoDisponible()
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "SELECT * FROM evento WHERE estado='Disponible' ORDER BY id DESC LIMIT 1";
            $stmt = $this->conexion->consultarBD($query);

            // Verificar si hay resultados
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retornar el primer resultado como arreglo asociativo
            } else {
                $stmt->closeCursor(); // Cerrar el cursor en caso de que no haya resultados
                return null;
            }
        } else {
            $this->conexion->close();
            return "Hubo un error al obtener el Evento";
        }
    }

    public function DCerrarEvento($id_evento)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                // Preparar la consulta SQL
                $query = "UPDATE evento SET estado = 'Cerrado' WHERE id = :id";
                $stmt = $conexion->prepare($query);

                // Vincular el parámetro ID
                $stmt->bindParam(':id', $id_evento, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();

                // Verificar si se ejecutó correctamente
                if ($stmt->rowCount() > 0) {
                    // Retorna true o algún indicador de éxito si es necesario
                    return true;
                } else {
                    // Retorna false o algún indicador de fallo si es necesario
                    return false;
                }
            } catch (PDOException $e) {
                // Manejar errores de la consulta SQL
                return "Error al ejecutar la consulta: " . $e->getMessage();
            }
        } else {
            $this->conexion->close();
            return "Hubo un error al cerrar el Evento";
        }
    }


    public function Deditar($id_evento, $nombre, $fecha, $ubicacion, $estado, $descripcion)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                $query = "UPDATE evento SET nombre = ?, fecha = ?, ubicacion = ?, estado = ?, descripcion = ? WHERE id = ?";
                $params = [$nombre, $fecha, $ubicacion, $estado, $descripcion, $id_evento];
                $stmt = $conexion->prepare($query); // Preparar la consulta
                $stmt->execute($params); // Ejecutar la consulta con los parámetros
                $stmt->closeCursor();
                return "Evento actualizado";
            } catch (\PDOException $e) {
                return "Error al actualizar el evento: " . $e->getMessage();
            }
        } else {
            return "Hubo un error al conectar con la base de datos";
        }
    }


    public function DlistarEventos()
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "SELECT * FROM evento ORDER BY id";
            $resultado = $this->conexion->consultarBD($query);
            $this->conexion->close();
            return $resultado;
        } else {
            $this->conexion->close();
            return "Hubo un error al obtener los Evento";
        }
    }

    public function DeliminarEvento($id_evento)
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            try {
                // Preparar la consulta SQL
                $query = "DELETE FROM evento WHERE id = :id";
                $stmt = $conexion->prepare($query);

                // Vincular el parámetro ID
                $stmt->bindParam(':id', $id_evento, PDO::PARAM_INT);

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


    public function DObtenerUltimoEvento()
    {
        $conexion = $this->conexion->connect();
        if ($conexion) {
            $query = "SELECT id, estado FROM evento ORDER BY id DESC LIMIT 1";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conexion->close();
            return $resultado;
        } else {
            $this->conexion->close();
            return "Hubo un error al obtener el último ID de evento";
        }
    }


   
    
    
}
