<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-ds perfil">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/change-password" class="enlace">Cambiar Contraseña</a>

    <form action="/profile" class="formulario" method="POST" novalidate>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre Completo" value="<?php echo $usuario->nombre?>">
        </div>
        <div class="campo">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" placeholder="Correo electronico" value="<?php echo $usuario->email?>">
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>