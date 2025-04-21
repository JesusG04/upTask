<aside class="sidebar">

    <div class="contenedor-sidebar">
        <h2>UpTask</h2>
        <div class="cerrar-menu">
            <i class="fa-solid fa-xmark" id="cerrar-menu"></i>
        </div>
    </div>


    <nav class="sidebar-nav">
        <a href="/new-project" class="<?php echo ($titulo === 'Nuevo Proyecto') ? 'activo' : ''; ?>"><i class="fa-regular fa-square-plus"></i> Nuevo Proyecto</a>
        <a href="/dashboard" class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>"><i class="fa-solid fa-list-check"></i> Proyectos</a>
        <a href="/profile" class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>"><i class="fa-solid fa-user"></i> Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a
    </div>
</aside>