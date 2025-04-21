<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-ds perfil">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/profile" class="enlace">Volver al Perfil</a>

    <form action="/change-password" class="formulario" method="POST" novalidate>

        <div class="campo">
            <div class="campo-label">
                <label for="password">Contraseña Actual</label> 
                <a href="/forget" class="">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="input-password">
                <input type="password" name="password_actual" id="password" placeholder="Contraseña Actual">
                <div class="input-eye" data-password="false">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>

        </div>
        <div class="campo">
            <label for="passwordN">Contraseña Nueva</label>
            <div class="input-password">
                <input type="password" name="password_nuevo" id="password" placeholder="Contraseña Nueva">
                <div class="input-eye" data-password="false">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="campo">
            <label for="passwordN2">Repite tu Contraseña</label>
            <div class="input-password">
                <input type="password" name="password2" id="password" placeholder="Repite tu Contraseña">
                <div class="input-eye" data-password="false">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>
        </div>


        <input type="submit" value="Cambiar Contraseña">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php
$script .= "
        <script src='build/js/app.js' ></script>
    "
?>