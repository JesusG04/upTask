<?php

namespace Model;

class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';

    protected static $columnasDB  = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    protected static $validaciones = [
        ['regex' => '/.{6,}/', 'mensaje' => 'Tu contraseña necesita 6 caracteres o más'],
        ['regex' => '/[A-Z]/', 'mensaje' => 'Tu contraseña necesita al menos una letra mayúscula'],
        ['regex' => '/\d/', 'mensaje' => 'Tu contraseña necesita al menos un número'],
        ['regex' => '/[@$#,!%*?&]/', 'mensaje' => 'Tu contraseña necesita al menos uno de estos caracteres (@$#,!%*?&)'],
    ];

    public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }


    public function validarLogin(): array
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es valido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    public function validarNuevaCuenta(): array
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        } else {
            foreach (self::$validaciones as $validacion):
                if (!preg_match($validacion['regex'], $this->password)) {
                    self::$alertas['error'][] = $validacion['mensaje'];
                }
            endforeach;
        }
        return self::$alertas;
    }

    public function validarEmail(): array
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es valido';
        }

        return self::$alertas;
    }

    public function validarPassword(): array
    {
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        } else {
            foreach (self::$validaciones as $validacion):
                if (!preg_match($validacion['regex'], $this->password)) {
                    self::$alertas['error'][] = $validacion['mensaje'];
                }
            endforeach;
        }
        return self::$alertas;
    }

    public function validarNuevoPassword(): array
    {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'Ingresa tu contraseña actual, por favor';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'Ingresa una nueva contraseña, por favor';
        } else {
            foreach (self::$validaciones as $validacion):
                if (!preg_match($validacion['regex'], $this->password_nuevo)) {
                    self::$alertas['error'][] = $validacion['mensaje'];
                }
            endforeach;
        }
        if ($this->password2 !== $this->password_nuevo) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }
        return self::$alertas;
    }
    public function validarPerfil(): array
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }
        return self::$alertas;
    }

    public function comprobarPassword(): bool
    {
        return password_verify($this->password_actual, $this->password);
    }

    public function hashearPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken(): void
    {
        $this->token = md5(uniqid());
    }
}
