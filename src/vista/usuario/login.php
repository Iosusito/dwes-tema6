<?php
$nombre = $datosParaVista['datos'] !== null ? $datosParaVista['datos']['nombre'] : "";

$errores = $datosParaVista['datos'] !== null ? $datosParaVista['datos']['errores'] : [];

/**
 * Se necesita un nombre, 
 */
?>

<div class="container">
    <h1>Inicia sesión</h1>

    <form action="index.php?controlador=usuario&accion=login" method="post">
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
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
            <?php
            if ($errores && $errores['clave'] !== null) {
                echo "<p>Error: {$errores['clave']}</p>";
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>
