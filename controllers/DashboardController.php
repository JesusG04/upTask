<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        //Obtener los proyectos del usuario
        $idUsuario = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $idUsuario);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }
    public static function new_project(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $proyecto = new Proyecto($_POST);

            //Validacion
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {

                //Crear una url unica
                $proyecto->url =  md5(uniqid());

                //Almacenar el creador del proyecto 
                $proyecto->propietarioId = $_SESSION['id'];


                //Guardar proyecto
                $proyecto->guardar();

                //Redireccionar
                header('Location:/project?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/nuevo-proyecto', [
            'titulo' => 'Nuevo Proyecto',
            'alertas' => $alertas
        ]);
    }
    public static function project(Router $router)
    {
        session_start();
        isAuth();

        $url = $_GET['id'];
        if (!$url) header('Location:/dashboard');

        $proyecto = Proyecto::where('url', $url);
        if ($proyecto->propietarioId !== $_SESSION['id']) header('Location:/dashboard');



        //Revisar que la persona sea el propietario del proyecto 

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }
    public static function profile(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if (empty($alertas)) {

                //Comprobar si el correo ya esta vinculado a una otra cuenta

                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario && $usuario->id !== $existeUsuario->id) {
                    //Mostrar error
                    Usuario::setAlerta('error', 'Este correo ya pertenece a otra cuenta');
                    $alertas = Usuario::getAlertas();
                } else {
                    //Guardar
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Se han guardado los cambios');
                    $alertas = Usuario::getAlertas();

                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function change_password(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $usuario = Usuario::find($_SESSION['id']);
            //Sicronisas con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevoPassword();

            if (empty($alertas)) {
                $resultado = $usuario->comprobarPassword();
                if ($resultado) {

                    //Asignar el nuevo pasword
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminamos los atributos password2, password_Actual y password_nuevo
                    unset($usuario->password2, $usuario->password_actual, $usuario->password_nuevo);

                    //Hasheamos la nueva contraseña
                    $usuario->hashearPassword();

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Tu contraseña ha sido actualizada correctamente');
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'La contraseña es incorrecta');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-contraseña', [
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas
        ]);
    }
}
