<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php'
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
       <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />
       </div> 
    </form>
</div>

<?php
    if(count($citas) === 0 ) {
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>
<!--lo que se muestra en la pantalla del admin sobre las citas y servicios  -->
<div id="citas-admin">
     <ul class="citas">
            <?php 
                $idCita = 0;
                foreach( $citas as $key => $cita ) {

                    if($idCita !== $cita->id) {    
                        $total = 0;
            ?>
            <li>
                    <p>ID: <span><?php echo $cita->id; ?></span>
                    <p>Hora: <span><?php echo $cita->hora; ?></span>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span>
                    <p>Email: <span><?php echo $cita->email; ?></span>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span>

                    <h3>Servicios</h3>
            <?php 
                $idCita = $cita->id;
            } // Fin de if
                $total += $cita->precio;
            ?>
                    <p class="servicio"><?php echo $cita->servicio . " $ " . $cita->precio; ?></p>
            <?php 
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if(esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                    <form action="/api/eliminar" method="POST" onsubmit="return confirmDelete()">
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>

                    <script>
                    function confirmDelete() {
                    return confirm("¿Estás seguro de que deseas eliminar este registro/cita?");
                    }
                    </script>
            <?php } 
         } // Fin de for each ?> 
     </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"

?>