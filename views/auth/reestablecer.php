<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">

        <?php if ($mostrar) { ?>
            <p class="descripcion-pagina">Coloca tu nueva contraseña</p>

            <?php include_once __DIR__ . '/../templates/alertas.php' ?>
            <form class="formulario" method="POST">

            <div class="campo">
                <label for="password">Contraseña</label>
                <div class="input-password">
                    <input type="password" name="password" id="password" placeholder="Nueva Contraseña">
                    <div class="input-eye" data-password="false">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="campo">
                <label for="password2">Repite tu Contraseña</label>
                <div class="input-password">
                    <input type="password2" name="password2" id="password2" placeholder="Repite tu Contraseña">
                    <div class="input-eye" data-password="false">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
            </div>

            <input type="submit" value="Cambiar Contraseña" class="boton">
        </form>

        <?php  } else { ?>
            <p class="descripcion-pagina">Token no Valido</p>
        <?php  } ?>
        

        
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