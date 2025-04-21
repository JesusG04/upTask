<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form action="/" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="email">Corre Electronico</label>
                <input type="email" name="email" id="email" placeholder="Correo" value="<?php echo s($usuario->email) ?>">
            </div>
            <div class="campo">
                <label for="password">Contraseña</label>
                <div class="input-password">
                    <input type="password" name="password" id="password" placeholder="Contraseña">
                    <div class="input-eye" id="input-eye" data-password="false">
                        <i class="fa-regular fa-eye" id="icono"></i>
                    </div>
                </div>
            </div>

            <input type="submit" value="Iniciar Sesion" class="boton">
        </form>

        <div class="acciones">
            <a href="/create-account">¿No tienes una cuenta? Regístrate</a>
            <a href="/forget" class="">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- contenedor-sm -->
</div>

<?php 
    $script .= "
        <script src='build/js/app.js' ></script>
    "
?>