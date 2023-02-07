<?php
if ($datosParaVista['datos']) {
    echo "<p>Entrada eliminada correctamente</p>";
} else {
    echo "<p>No se ha podido eliminar la entrada, prueba más tarde</p>";
}
?>

<a href="index.php?controlador=entrada&accion=lista">Ir al inicio</a>