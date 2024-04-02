<?php

namespace Negocio;

use Datos\DEvento;


require_once 'Datos/DEvento.php';


class NEvento
{
    protected $devento;
    public function __construct()
    {

        $this->devento = new DEvento();
    }
    public function Nregistrar($nombre, $fecha, $ubicacion,$estado, $descripcion)
    {
        $Nregistrar = $this->devento->Dregistrar($nombre, $fecha, $ubicacion,$estado, $descripcion);
        echo $Nregistrar;
        // return $Nregistrar;
    }


    public function NobtenerEventoDisponible()
    {
        return $this->devento->DobtenerEventoDisponible();
       
     
    }

    public function NCerrarEvento($id_evento){
       
        return $this->devento->DCerrarEvento($id_evento);
    }


    public function NEditar($id_evento,$nombre, $fecha, $ubicacion,$estado, $descripcion){
       
        return $this->devento->Deditar($id_evento,$nombre, $fecha, $ubicacion,$estado, $descripcion);
       
    }

    public function NlistarEventos()
    {
        return $this->devento->DlistarEventos();
       
     
    }

    public function NeliminarEvento($id_evento){
       
        return $this->devento->DeliminarEvento($id_evento);
    }
}
