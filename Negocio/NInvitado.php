<?php

namespace Negocio;

require_once 'Datos/DInvitado.php';

use Datos\DEvento;
use Datos\DInvitado;

class NInvitado
{

    protected $dinvitado;
    protected $devento;

    public function __construct()
    {
        $this->dinvitado = new DInvitado();
        $this->devento = new DEvento();
    }


    public function NObtenerUltimoEvento()
    {
        $ultimoIdEvento = $this->devento->DObtenerUltimoEvento();
        return $ultimoIdEvento;
    }


    public function NRegistrar($nombre, $correo, $telefono, $estado, $codigo, $id_evento)
    {
        $this->dinvitado->Dregistrar($nombre, $correo, $telefono, $estado, $codigo, $id_evento);
    }

    public function NlistaInvitados($id_evento)
    {
        return $this->dinvitado->DlistaInvitados($id_evento);
    }

    public function NEliminarInvitado($id_invitado)
    {
        $this->dinvitado->DEliminarInvitado($id_invitado);
    }
    public function NObtenerInvitadoPorId($id_invitado)
    {
        // echo ("<div>hola</div>");
        return $this->dinvitado->DObtenerInvitadoPorId($id_invitado);
    }


    public function NActualizarInvitado($id_invitado,$nombre,$correo,$telefono){
        return $this->dinvitado->DActualizarInvitado($id_invitado,$nombre,$correo,$telefono);
    }

    public function NActualizarEstadoDeConfirmacion($id_invitado,$estadoEvento){
       
        return $this->dinvitado->DActualizarEstadoDeConfirmacion($id_invitado,$estadoEvento);

    }
}
