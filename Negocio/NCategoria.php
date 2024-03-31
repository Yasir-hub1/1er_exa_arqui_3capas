<?php

namespace Negocio;
require_once 'Datos/DCategoria.php';

use Datos\DCategoria;
use Exception;
use InvalidArgumentException;
// 
class NCategoria
{
    protected $dCategoria;

    public function __construct()
    {

        $this->dCategoria = new DCategoria();
    }
    public function listar()
    {
        return $this->dCategoria->listar();
    }
}
