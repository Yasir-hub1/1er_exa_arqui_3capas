<?php
namespace Presentacion;

require_once 'Negocio/NInvitado.php';
require_once 'Negocio/NEvento.php';
require_once 'Negocio/NAsistencia.php';


use Negocio\NInvitado;
use Negocio\NEvento;
use Negocio\NAsistencia;
use PDO;


$PInvitado = new NInvitado;
$PEvento = new NEvento;
$PAsistencia=new NAsistencia;

$estadoDelEvento = $PEvento->NObtenerUltimoEvento();
$id_evento = $estadoDelEvento['id'];






if ($_SERVER["REQUEST_METHOD"] == "POST") {
  /*   foreach ($_POST as $nombre_campo => $valor) {
        echo "Campo: $nombre_campo; Valor: $valor<br>";
    } */
    switch ($_POST["accion"]) {
        case "confirmarAsistencia":
        $id_invitado=$_POST["id_invitado"];
        $fecha = date('Y-m-d');
         $estadoInvitado='confirmado';

        $PAsistencia->NconfirmarAsistencia($id_invitado,$id_evento,$fecha);
        $PInvitado->NActualizarEstadoDeConfirmacion($id_invitado,$estadoInvitado);
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style>
        #video {
            width: 25%;
            height: auto;
            justify-content: center;
            align-self: center;
        }
    </style>
</head>

<body>
    <?php
     if($estadoDelEvento['estado']=='Disponible'){
         echo '<h1>Escanear QR</h1>
         <div style="align-items: center;justify-content: center;align-self: center;">
             <video id="video" playsinline></video>
             <canvas id="canvas" style="display: none;"></canvas>
     
         </div>';

     }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
        // Acceder a la cámara y encenderla
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                const video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
                video.addEventListener('loadedmetadata', () => {


                    setTimeout(scanQRCode(video), 300);
                });
            } catch (error) {
                console.error('Error al acceder a la cámara:', error);
                alert('Error al acceder a la cámara: ' + error);
            }
        }



        // Escanear códigos QR desde la secuencia de video
        function scanQRCode(video) {
            console.log("entro a scan")
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            // Establecer willReadFrequently en true para mejorar el rendimiento de getImageData
            ctx.imageSmoothingEnabled = true;
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            function scan() {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: 'dontInvert',
                });

                if (code && code.data) {
                    console.log("code ", code)
                    alert('Código QR detectado: ' + code.data);

                  
                    enviarDatos(code.data);
                }

                requestAnimationFrame(scan);
            }

            scan();

        }

        function enviarDatos(codeQr) {

            const form = document.createElement('form');
            form.method = 'POST';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_invitado';
            input.value = codeQr;
            form.appendChild(input);

            const inputAcccion = document.createElement('input');
            inputAcccion.type = 'hidden';
            inputAcccion.name = 'accion';
            inputAcccion.value = 'confirmarAsistencia';
            form.appendChild(inputAcccion);

            document.body.appendChild(form);
            form.submit();
        }

        // Iniciar el escáner cuando la página esté completamente cargada
        window.addEventListener('load', () => {
            startCamera();
            // Ejecutar startCamera() cada 300 milisegundos
            setTimeout(() => startCamera(), 300);
        });
    </script>
</body>

</html>