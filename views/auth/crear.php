<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        
        <form action="/create-account" class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $usuario->nombre ?>">
            </div>
            <div class="campo">
                <label for="email">Corre Electronico</label>
                <input type="email" name="email" id="email" placeholder="Correo" value="<?php echo $usuario->email; ?>" >
            </div>
            <div class="campo">
                <label for="password">Contraseña</label>
                <div class="input-password">
                    <input type="password" name="password" id="password" placeholder="Contraseña">
                    <div class="input-eye" data-password="false">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="campo">
                <label for="password2">Repite tu Contraseña</label>
                <div class="input-password">
                    <input type="password" name="password2" id="password2" placeholder="Repite tu Contraseña">
                    <div class="input-eye" data-password="false">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
            </div>

            <input type="submit" value="Crear Cuenta" class="boton">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
            <a href="/forget" class="">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- contenedor-sm -->
</div>

<?php 
    $script .= "
        <script src='build/js/app.js' ></script>
    "
?>