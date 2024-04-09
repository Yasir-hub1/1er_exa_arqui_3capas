<?php

namespace Presentacion;

require_once 'Negocio/NInvitado.php';
require_once 'Negocio/NEvento.php';

use Negocio\NInvitado;
use Negocio\NEvento;
use PDO;


$PInvitado = new NInvitado;
$PEvento = new NEvento;

$estadoDelEvento = $PEvento->NObtenerUltimoEvento();
$id_evento = $estadoDelEvento['id'];
$PlistaInvitados = $PInvitado->NlistaInvitados($id_evento);

$invitadoSeleccionado = NULL;






if ($_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_POST["accion"]) {
        case "registrarInvitado":
            // Lógica para el formulario de registro
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $telefono = $_POST["telefono"];
            $estado = "sin confirmar";
            $codigo = rand(1, 100);
            $PInvitado->Nregistrar($nombre, $correo, $telefono, $estado, $codigo, $id_evento);
            // Redirigir al usuario después de procesar el formulario
            header("Location:  /");
            exit; // Importante: detener la ejecución del script después de la redirección
            break;

        case "eliminarInvitado":
            // Lógica para el formulario de cierre de Invitado
            $id_invitado = $_POST["id_invitado"];
            $PInvitado->NEliminarInvitado($id_invitado);
            /* header("Location:  /");
            exit; */ // Importante: detener la ejecución del script después de la redirección
            break;
        case "buscarInvitado":
            //    echo ("<div>hola</div>");
            $id_invitado = $_POST["id_invitado"]; // Usar $_GET en lugar de $_POST
            $invitadoSeleccionado = $PInvitado->NObtenerInvitadoPorId($id_invitado);

            // Redirigir al usuario después de procesar el formulario
            /*  header("Location:  /");
                        exit;  */ // Importante: detener la ejecución del script después de la redirección
            break;
        case "actualizarInvitado":

            /*  foreach ($_POST as $nombre_campo => $valor) {
                echo "Campo: $nombre_campo; Valor: $valor<br>";
            }
              return;   */
            $id_evento = $id_evento;
            $id_invitado = $_POST["id_invitado"];
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $telefono = $_POST["telefono"];


            $PInvitado->NActualizarInvitado($id_invitado, $nombre, $correo, $telefono);
            // Redirigir al usuario después de procesar el formulario
            /*  header("Location:  /");
            exit; */ // Importante: detener la ejecución del script después de la redirección
            break;
        case "invitarAEvento":
            // Obtener el ID del invitado a invitar
            $id_invitado = $_POST["id_invitado"];
            $nombreInvitado = $_POST["nombreInvitado"];
            $telefonoInvitado = $_POST["telefonoInvitado"];
            

            // Generar el enlace de WhatsApp con el mensaje
            $mensaje_whatsapp = "Hola $nombreInvitado, te estoy invitando al evento, te adjunto el link de invitación http://gestioneventos.test:84/Presentacion/PQr.php/$id_invitado. ¿Estás disponible?";
            $enlace_whatsapp = "https://api.whatsapp.com/send?phone=$telefonoInvitado&text=" . urlencode($mensaje_whatsapp);
            // Redirigir al usuario al enlace de WhatsApp
            echo "<script>window.open('$enlace_whatsapp', '_blank');</script>";
            break;
        default:
            // Acción por defecto si no coincide ninguna de las anteriores
            break;
    }
}





?>
<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .registro-invitado,
        .editar-invitado {
            border-radius: 10px;
            border: 2px solid #000;
            padding: 20px;
            margin-left: 20px;
            width: 300px;
        }

        .lista-invitados {
            margin-left: 20px;
            width: calc(100% - 640px);
            /* El ancho de la tabla es el 100% menos el ancho de los formularios */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <section>
        <?php
        // var_dump($invitadoSeleccionado);
        if ($estadoDelEvento['estado'] == 'Disponible') {
            echo '
        <h1 style="text-align: center;">INVITADOS</h1>
        <div class="flex-container">
            <div class="registro-invitado">';

            echo '<h2>Registro de invitado</h2>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="accion" value="registrarInvitado">';
            echo '<label for="nombre">Nombre:</label><br>';
            echo '<input type="text" id="nombre" name="nombre"><br>';
            echo '<label for="correo">Correo:</label><br>';
            echo '<input type="email" id="correo" name="correo"><br>';
            echo '<label for="telefono">Teléfono:</label><br>';
            echo '<input type="text" id="telefono" name="telefono"><br>';
            echo '<input type="submit" value="Registrar">';
            echo '</form>';
        }
        echo '</div>';
        ?>
        <?php
        echo '<div class="lista-invitados">';
        if ($estadoDelEvento['estado'] == 'Disponible') {
            echo '<h2>Lista de Invitados</h2>';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nombre</th>';
            echo '<th>Correo</th>';
            echo '<th>Teléfono</th>';
            echo '<th>codigo</th>';
            echo '<th>Estado</th>';
            echo '<th>Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            if (is_array($PlistaInvitados)) {
                foreach ($PlistaInvitados as $invitado) {
                    echo '<tr>';
                    echo '<td>' . $invitado['nombre'] . '</td>';
                    echo '<td>' . $invitado['correo'] . '</td>';
                    echo '<td>' . $invitado['telefono'] . '</td>';
                    echo '<td>' . $invitado['codigo'] . '</td>';
                    echo '<td>' . $invitado['estado'] . '</td>';
                    echo '<td>';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="accion" value="eliminarInvitado">';
                    echo '<input type="hidden" name="id_invitado" value="' . $invitado['id'] . '">';
                    echo '<input type="submit" value="Eliminar">';
                    echo '</form>';



                    echo '<form method="POST">';
                    echo '<input type="hidden" name="accion" value="invitarAEvento">';
                    echo '<input type="hidden" name="codigoInvitado" value="' . $invitado['codigo'] . '">';
                    
                    echo '<input type="hidden" name="nombreInvitado" value="' . $invitado['nombre'] . '">';
                    echo '<input type="hidden" name="telefonoInvitado" value="' . $invitado['telefono'] . '">';

                    echo '<input type="hidden" name="id_invitado" value="' . $invitado['id'] . '">';
                    echo '<input type="submit" value="Invitar">';

                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            echo '</tbody>';
            echo '</table>';
        }
        echo ' </div>';
        ?>
        <?php
        if ($estadoDelEvento['estado'] == 'Disponible') {
            echo '<div class="editar-invitado">';
            echo '<h2>Buscar Invitado Para editar</h2>';
            echo '<form method="POST">';
            echo '<div style="display: flex;">';
            echo '<div>';
            echo '<select class="form-control input-lg" name="id_invitado" required>';
            echo '<option value="">Seleccione un invitado</option>';
            if (is_array($PlistaInvitados)) {
                foreach ($PlistaInvitados as $invitado) {
                    echo '<option value="' . $invitado["id"] . '">' . $invitado["nombre"] . '</option>';
                }
            }
            echo '</select>';
            echo '</div>';
            echo '<input type="hidden" name="accion" value="buscarInvitado">';
            echo '<div>';
            echo '<input type="submit" value="Buscar">';
            echo '</div>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '<br>';
            echo '<br>';
        }

        ?>
        <?php
        if ($estadoDelEvento['estado'] == 'Disponible') {
            echo ('<div class="editar-invitado">
            <h2>Editar Informacion de invitado</h2>
            <form method="POST">
            <input type="hidden"  name="accion" value="actualizarInvitado">
                
           
                <input type="hidden" id="id_evento" name="id_invitado" value="' . ((!is_null($invitadoSeleccionado) && isset($invitadoSeleccionado['id'])) ? $invitadoSeleccionado['id'] : '')  . '">
                
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" placeholder="' . ((!is_null($invitadoSeleccionado) && isset($invitadoSeleccionado['nombre'])) ? $invitadoSeleccionado['nombre'] : '') . '"><br>
               
                <label for="correo">Correo:</label><br>
                <input type="email" id="correo" name="correo" placeholder="' . ((!is_null($invitadoSeleccionado) && isset($invitadoSeleccionado['correo'])) ? $invitadoSeleccionado['correo'] : '') . '"><br>
               
                <label for="telefono">Telefono:</label><br>
                <input type="text" id="telefono" name="telefono" placeholder="' . ((!is_null($invitadoSeleccionado) && isset($invitadoSeleccionado['telefono'])) ? $invitadoSeleccionado['telefono'] : '') . '"><br>
                <br>
                <button type="submit">Actualizar datos</button>
            </form>
        </div>');
        }
        ?>
    </section>
</body>

</html>