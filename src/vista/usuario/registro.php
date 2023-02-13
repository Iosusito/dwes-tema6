<?php

use dwesgram\modelo\Usuario;

$usuario = $datosParaVista['datos'];

$nombre = $usuario instanceof Usuario ? $usuario->getNombre() : "";

$email = $usuario instanceof Usuario ? $usuario->getEmail() : "";

$errores = $usuario instanceof Usuario ? $usuario->getErrores() : [];
?>

<div class="container">
    <h1>Regístrate</h1>

    <form action="index.php?controlador=usuario&accion=registro" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
            <?php
            if ($errores && $errores['nombre'] !== null) {
                echo "<p>Error: {$errores['nombre']}</p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label><br>
            <input type="email" id="email" name="email" value="<?= $email ?>">
            <?php
            if ($errores && $errores['email'] !== null) {
                echo "<p>Error: {$errores['email']}</p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
            <?php
            if ($errores && $errores['clave'] !== null) {
                echo "<p>Error: {$errores['clave']}</p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="repiteclave" class="form-label">Repite la contraseña</label><br>
            <input type="password" id="repiteClave" name="repiteClave">
            <?php
            if ($errores && $errores['repiteClave'] !== null) {
                echo "<p>Error: {$errores['repiteClave']}</p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="avatar">Puedes elegir un avatar</label><br>
            <input class="form-control" type="file" name="avatar" id="avatar">
            <?php
            if ($errores && $errores['avatar'] !== null) {
                echo "<p>Error: {$errores['avatar']}</p>";
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Crear cuenta</button>
    </form>
</div>
