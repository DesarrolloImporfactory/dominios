<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
class Home extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->views->render($this, "index");
    }

    public function registro()
    {
        $this->views->render($this, "registro");
    }

    public function actualizar($tienda)
    {
        $this->views->render($this, "actualizar");
    }

    public function borrar($tienda)
    {
        $this->views->render($this, "borrar");
    }

    public function activar($tienda)
    {
        return $this->model->activar($tienda);
    }

    public function reinciarServidor()
    {
        return $this->model->reinciarServidor();
    }

    public function activarSSL($dominio)
    {
        return $this->model->activarSSL($dominio);
    }

    public function cambiarNombre($nombre)
    {
        $antiguo = $_POST['antiguo'];
        return $this->model->cambiarNombre($antiguo, $nombre);
    }
}
