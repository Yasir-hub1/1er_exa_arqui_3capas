<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de QR</title>
    <script src="https://unpkg.com/qrious@4.0.2/dist/qrious.js"></script>
</head>

<body>
    <div style="justify-content: center;align-self: center;justify-items:center;">
        <img alt="Código QR" id="codigo">

    </div>
    <script>
        const $imagen = document.querySelector("#codigo"),
            $boton = document.querySelector("#btnDescargar")


        const URLactual = window.location.href;
        const regex = /\/(\d+)$/; // Captura solo dígitos después de la barra al final de la URL
        const matches = URLactual.match(regex);
        if (matches && matches.length > 1) {
            // El último valor encontrado
            const ultimoValor = matches[1];
            console.log("El último valor es:", ultimoValor);
            new QRious({
                element: $imagen,
                value: `${ultimoValor}`, // La URL o el texto
                size: 250,
                backgroundAlpha: 0, // 0 para fondo transparente
                foreground: "#3498db", // Color del QR
                level: "H", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor),

            });
        }


        $boton.onclick = () => {
            const enlace = document.createElement("a");
            enlace.href = $imagen.src;
            enlace.download = `${nombreEvento}.png`;
            enlace.click();
        }
    </script>
</body>

</html>