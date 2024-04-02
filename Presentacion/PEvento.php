<?php

namespace Presentacion;

require_once 'Negocio/NEvento.php';

use Negocio\NEvento;
use PDO;
?>

<?php
$PEvento = new NEvento;
// Verificar si se enviaron datos a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_POST["accion"]) {

        case "registrarEvento":
            // Lógica para el formulario de registro
            $nombre = $_POST["nombre"];
            $fecha = $_POST["fecha"];
            $ubicacion = $_POST["ubicacion"];
            $descripcion = $_POST["descripcion"];
            $estado = "Disponible";
            $PEvento->Nregistrar($nombre, $fecha, $ubicacion, $estado, $descripcion);
            // Redirigir al usuario después de procesar el formulario
            header("Location:  /");
            exit; // Importante: detener la ejecución del script después de la redirección
            break;
        case "editarEvento":
            // Lógica para el formulario de registro

            $id_evento = $_POST["id_evento"];
            $nombre = $_POST["nombre"];
            $fecha = $_POST["fecha"];
            $ubicacion = $_POST["ubicacion"];
            $descripcion = $_POST["descripcion"];
            $estado = "Disponible";
            $PEvento->NEditar($id_evento, $nombre, $fecha, $ubicacion, $estado, $descripcion);
            // Redirigir al usuario después de procesar el formulario
            header("Location:  /");
            exit; // Importante: detener la ejecución del script después de la redirección
            break;
        case "cerrarEvento":
            // Lógica para el formulario de cierre de evento
            $id_evento = $_POST["id_evento"];
            $PEvento->NCerrarEvento($id_evento);
            header("Location:  /");
            exit; // Importante: detener la ejecución del script después de la redirección
            break;

        case "eliminarEvento":
            // Lógica para el formulario de cierre de evento
            $id_evento = $_POST["id_evento"];
            $PEvento->NeliminarEvento($id_evento);
            header("Location:  /");
            exit; // Importante: detener la ejecución del script después de la redirección
            break;
        default:
            // Acción por defecto si no coincide ninguna de las anteriores
            break;
    }
}

$PobtenerEvento = $PEvento->NobtenerEventoDisponible();
$PlistarEventos = $PEvento->NlistarEventos();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Evento</title>
</head>

<body>
    <div style="justify-content: center;align-self: center;">
        <h1 style="text-align: center;">GESTION DE EVENTOS</h1>

    </div>
    <div style="display: flex;">
        <!-- FORMULARIO DE REGISTRO -->
        <?php
        if ($PobtenerEvento !== null) {
            $hayEvento = true;
            echo '<div>
            <div style="margin-left: 20px;display: flex;">
                <h4>Evento:' . $PobtenerEvento['nombre'] . '</h4>
                
               
                <div style="padding-left:10px">
                  <h4>Fecha y hora : ' . $PobtenerEvento['fecha'] . '</h4>
                </div>

                <div style="padding-left:10px">
                  <h4>Estado : ' . $PobtenerEvento['estado'] . '</h4>
                </div>
                <br>
                
                <!-- BOTON DE CERRAR EVENTO  -->

                <div style="padding-left:10px;">
                <form method="POST">
                <input type="hidden" name="accion" value="cerrarEvento">
                <input type="hidden" id="id_evento" name="id_evento" value="' . $PobtenerEvento['id'] . '">
                <input type="hidden" id="nombre" name="nombre" value="' . $PobtenerEvento['nombre'] . '">
                <input type="hidden" id="fecha" name="fecha" value="' . $PobtenerEvento['fecha'] . '">
                <input type="hidden" id="ubicacion" name="ubicacion" value="' . $PobtenerEvento['ubicacion'] . '">
                <input type="hidden" id="descripcion" name="descripcion" value="' . $PobtenerEvento['descripcion'] . '"><br>
                 <button type="submit">Cerrar evento</button>
                 </form>
                </div>  
                </div> 
               <div style="padding-left:10px;margin-top:-30px">
               <h4>Descripcion: ' . $PobtenerEvento['descripcion'] . '</h4>
               </div>

               
                <!-- FORMULARIO DE EDITAR INFORMACION DE EVENTO  -->

<div style="padding-left:10px;">
    <div style="border-radius: 10px; border: 2px solid #000; padding: 20px;width:250px ">

    <h2 style="text-align: center;">Editar informacion  del Evento</h2>

            <form method="POST">

                <input type="hidden" name="accion" value="editarEvento">

                <input type="hidden" id="id_evento" name="id_evento" value="' . $PobtenerEvento['id'] . '">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre"  placeholder="' . $PobtenerEvento['nombre'] . '" ><br>
                    <label for="fecha">Fecha y hora:</label><br>
                    <input type="datetime-local" id="fecha" name="fecha" placeholder="' . $PobtenerEvento['fecha'] . '"><br>
                    <label for="ubicacion">Ubicación:</label><br>
                    <input type="text" id="ubicacion" name="ubicacion" placeholder="' . $PobtenerEvento['ubicacion'] . '"><br>
                    <label for="descripcion">Descripción:</label><br>
                    <input type="text" id="descripcion" name="descripcion"  placeholder="' . $PobtenerEvento['descripcion'] . '"><br><br>

                    <button type="submit">Actualizar evento</button>

                </form>
            </div>
            </div>

                
            </div>';
        } else {

            echo '<div style="flex-direction: row; display: flex;">
          
                    <div style="border-radius: 10px; border: 2px solid #000; padding: 20px; margin-left: 20px;">
                        <h2>Registro de Evento</h2>
                        <form method="POST">
                        <input type="hidden" name="accion" value="registrarEvento">
                            <label for="nombre">Nombre:</label><br>
                            <input type="text" id="nombre" name="nombre"><br>
                            <label for="fecha">Fecha y hora:</label><br>
                            <input type="datetime-local" id="fecha" name="fecha"><br>
                            <label for="ubicacion">Ubicación:</label><br>
                            <input type="text" id="ubicacion" name="ubicacion"><br>
                            <label for="descripcion">Descripción:</label><br>
                            <input type="text" id="descripcion" name="descripcion"><br><br>
                            <input type="submit" value="Registrar">
                        </form>
                    </div>';
        }





        ?>
        <?php
        if ($PobtenerEvento == null) {

            echo '  <div style="margin-left: 20px;">
                <h2>Lista de eventos</h2>
    
                <table border="1">
                    <thead>
                        <tr>
                            <th>Nombre </th>
                            <th>Fecha </th>
                            <th>Ubicacion </th>
                            <th>Descripcion </th>
                            <th>Estado </th>

                            <th>Opciones </th>
                        </tr>
                    </thead>
                    <tbody>';
            if (is_object($PlistarEventos)) {
                while ($evento = $PlistarEventos->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $evento['nombre'] . "</td>";
                    echo "<td>" . $evento['fecha'] . "</td>";
                    echo "<td>" . $evento['ubicacion'] . "</td>";
                    echo "<td>" . $evento['descripcion'] . "</td>";
                    echo "<td>" . $evento['estado'] . "</td>";
                    echo ' <form method="POST">
                            <input type="hidden" name="accion" value="eliminarEvento">';
                    echo '<td>  <input type="hidden" name="id_evento" value="' . $evento['id'] . '"
                    <br>
                               <input type="submit" value="eliminar">
                          </td>';
                    echo ' </form>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay eventos disponibles</td></tr>";
            }




            echo '  </tbody>
                </table>
            </div>
            </div>';
        }

        ?>
        <!-- VISTA DONDE MUESTRA LOS DATOS DEL EVENTO DISPONIBLE  -->




    </div>
</body>






</html>