<?php

namespace Negocio;

require_once 'Datos/DAsistencia.php';

use Datos\DEvento;
use Datos\DInvitado;
use Datos\DAsistencia;

class NAsistencia{
    protected $dasistencia;

    public function __construct(){
        $this->dasistencia = new DAsistencia();
    }

    public function NconfirmarAsistencia($id_invitado,$id_evento,$fecha){
        return $this->dasistencia->DconfirmarAsistencia($id_invitado,$id_evento,$fecha);
        
    }


}

