<?php

use dwesgram\modelo\Entrada;

echo "<p>Esta es una lista de las publicaciones de la red social</p>";

if ($datosParaVista['datos'] === null || !$datosParaVista['datos']) {
    echo "<p>No hay entradas publicadas<p>";
} else {
    echo "<div>";
    foreach ($datosParaVista['datos'] as $entrada) {
        if ($entrada instanceof Entrada) {
            $id = $entrada->getId();
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            echo <<<END
            <div>
                <img href="$imagen"></img>
                <p>$texto</p>
                <a href="index.php?controlador=entrada&accion=detalle&id=$id">Detalles</a>
                <a href="index.php?controlador=entrada&accion=eliminar&id=$id">Eliminar</a>
            </div>
            <hr>
            END;
        }
    }
    echo "</div>";
}
