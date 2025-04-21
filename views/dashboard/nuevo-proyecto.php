<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-ds">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <form action="/new-project" class="formulario" method="POST">
        <?php include_once __DIR__ . '/formulario-dashboard.php' ?>
        <input type="submit" value="Crear Proyecto">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>