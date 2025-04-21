<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu contraseña</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form action="/forget" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="email">Corre Electronico</label>
                <input type="email" name="email" id="email" placeholder="Correo">
            </div>

            <input type="submit" value="Enviar Instrucciones" class="boton">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/create-account">¿No tienes una cuenta? Regístrate</a>
        </div>
    </div> <!-- contenedor-sm -->
</div>