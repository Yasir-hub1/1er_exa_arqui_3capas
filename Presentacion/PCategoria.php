<?php

namespace Presentacion;

require_once 'Negocio/NCategoria.php';

use Negocio\NCategoria;
use PDO;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>PCategoria</h2>

    <?php


    $obj = new NCategoria();
    $resultado = $obj->listar();

    // Iteramos sobre los resultados y los mostramos en pantalla
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $fila['id'] . ", Nombre: " . $fila['nombre'] . "<br>";
    }
    ?>
</body>

</html>'