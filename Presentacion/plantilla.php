<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Eventos</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">




</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
 
  <?php

  // if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

   echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    // include "Presentacion/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    // include "Presentacion/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    
      include "Presentacion/Pinicio.php";
     

    /*=============================================
    FOOTER
    =============================================*/

    // include "Presentacion/footer.php";

    echo '</div>';

/*   }else{

    include "Presentacion/login.php";

  } */

  ?>



</body>
</html>
