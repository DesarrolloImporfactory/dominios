<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class HomeModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function activar($tienda)
    {
        // Ruta completa al script .sh
        $script_path = '/var/www/script.sh';

        // Ejecutar el script con el parámetro
        $output = [];
        $return_var = 0;
        exec("echo 'Mark2demasiado.' | su -c 'bash $script_path $tienda' einzas", $output, $return_var);

        // Verificar si la ejecución fue exitosa
        if ($return_var === 0) {
            // Solo mostrar el JSON final si todo salió bien
            echo json_encode(["status" => 200, "message" => "Tienda Creada Correctamente"]);
        } else {
            // Mostrar un mensaje de error en caso de fallo
            echo json_encode(["status" => 500, "message" => "Error al ejecutar el script"]);
        }
    }

    public function reinciarServidor()
    {
        $output = [];
        $return_var = 0;

        // Ejecutar el reinicio del servidor en segundo plano
        exec('sudo systemctl restart apache2 > /dev/null 2>&1 &', $output, $return_var);

        // Asegurarte de que el comando ha sido ejecutado
        echo json_encode(["status" => 200, "message" => "El reinicio del servidor ha sido iniciado."]);
    }


    public function activarSSL($dominio)
    {
        $output = [];
        $return_var = 0;

        // Ejecutar Certbot como 'root' usando sudo
        exec("sudo certbot --apache --reinstall -d $dominio.comprapor.com -v 2>&1", $output, $return_var);

        // Verificar si la ejecución fue exitosa
        if ($return_var === 0) {
            echo json_encode(["status" => 200, "message" => "SSL activado/reinstalado correctamente"]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Error al activar SSL",
                "error_output" => implode("\n", $output)
            ]);
        }
    }

    public function cambiarNombre($nombreViejo, $nombreNuevo)
    {
        // Ruta completa al script .sh
        $script_path = '/var/www/actualizar.sh';

        // Escapar los parámetros
        $nombreViejo = escapeshellarg($nombreViejo);
        $nombreNuevo = escapeshellarg($nombreNuevo);

        // Ejecutar el script con los parámetros
        $output = [];
        $return_var = 0;
        exec("echo 'Mark2demasiado.' | su -c 'bash $script_path $nombreViejo $nombreNuevo' einzas", $output, $return_var);

        // Verificar si la ejecución fue exitosa
        if ($return_var === 0) {
            // Mostrar el JSON de éxito
            echo json_encode(["status" => 200, "message" => "Nombre de tienda cambiado correctamente", "output" => $output]);
        } else {
            // Mostrar el JSON de error con detalles de la salida
            echo json_encode(["status" => 500, "message" => "Error al ejecutar el script", "output" => $output]);
        }
    }
}
