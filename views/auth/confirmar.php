<div class="contenedor confirmar">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">

    <?php if ($mostrar) { ?>
        <p class="descripcion-pagina">Confirmación completa. Bienvenido/a, ya puedes ingresar a tu cuenta</p>
    <?php  } else { ?>
        <p class="descripcion-pagina">Token no Valido</p>
    <?php  }?>
    
       <div class="acciones">
        <a href="/">Iniciar Sesion</a>
       </div>
    </div> <!-- contenedor-sm -->
</div>