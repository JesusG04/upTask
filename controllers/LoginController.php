<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } else if (!$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no esta confirmado');
                } else {
                    //El usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {
                        //iniciar sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionar
                        header('Location:/dashboard');
                    } else {
                        Usuario::setAlerta('error', 'La contraseña es incorrecta');
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location:/');
    }

    public static function create(Router $router)
    {

        //Creamos la instancia de usuario
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                } else {
                    //hasheamos la contraseña
                    $usuario->hashearPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    //Creamos token
                    $usuario->crearToken();

                    $resultado = $usuario->guardar();

                    //Enviar el email de confirmacion
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function forget(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if (empty($alertas)) {
                //Buscar el usuario 
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado) {
                    //Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);


                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado un mensaje a tu correo para que puedas restablecer tu contraseña');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function recover(Router $router)
    {
        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location:/');

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Añadir el nuevo password
            $usuario->sincronizar($_POST);

            //Validamos contraseña
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                //Hashear paswword
                $usuario->hashearPassword();
                unset($usuario->password2);

                //Eliminar el token 
                $usuario->token = null;

                //Guardar en la base de datos
                $resultado = $usuario->guardar();

                //Redireccionar 
                if ($resultado) {
                    header('Location:/');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }
    public static function message(Router $router)
    {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada'
        ]);
    }
    public static function confirm(Router $router)
    {
        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location:/');

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            $mostrar = false;
        } else {
            $usuario->confirmado = 1;
            unset($usuario->password2);
            $usuario->token = null;
            $usuario->guardar();
        }


        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar Cuenta',
            'mostrar' => $mostrar
        ]);
    }
}
