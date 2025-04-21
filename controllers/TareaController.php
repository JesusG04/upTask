<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController
{
    public static function index()
    {
        $proyectoId = $_GET['id'];
        if (!$proyectoId) header('Location: /dasboard');

        //Consultamos el proyecto 
        $proyecto = Proyecto::where('url', $proyectoId);
        session_start();

        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoid', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }
    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ocurrió un problema al intentar agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            //Cuando se pase la validacion
            //Instanciamos la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'La tarea se creo correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ocurrió un problema al actualizar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado Correctamente'
                ];
                echo json_encode($respuesta);
            }
        }
    }
    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ocurrió un problema al eliminar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();

            $respuesta = [
                'resultado' => $resultado,
                'mensaje' => 'La tarea se elimino correctamente',
                'tipo' => 'exito'
            ];

            echo json_encode($respuesta);
        }
    }
}
