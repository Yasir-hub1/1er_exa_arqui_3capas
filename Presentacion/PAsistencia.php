<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner</title>
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
    <h1>QR Scanner</h1>
    <div style="align-items: center;justify-content: center;align-self: center;">
        <video id="video" playsinline></video>
        <canvas id="canvas" style="display: none;"></canvas>
         
    </div>

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

                if (code) {
                    console.log("code ", code)
                    alert('Código QR detectado: ' + code.data);
                }

                requestAnimationFrame(scan);
            }

            scan();
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