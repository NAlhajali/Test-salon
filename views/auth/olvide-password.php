<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion=pagina">Reestablece tu contraseña escribe tu email a continuación</p>

<?php  
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>
    
    <input type="submit" class="boton" value="Enviar Contraseña" >
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta ? Crear una</a>
</div>