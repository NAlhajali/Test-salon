<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php foreach($servicios as $servicio) {?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$ <?php echo $servicio->precio ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo 
                $servicio->id; ?>">Actualizar</a>

                <form action="/servicios/eliminar" method="POST" onsubmit="return confirmDelete()">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">

                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
                <script> function confirmDelete() 
                { return confirm("¿Estás seguro de que deseas eliminar este registro/servicios?"); } </script>


            </div>
        </li>
    <?php } ?>

</ul>