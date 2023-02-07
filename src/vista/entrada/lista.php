<?php

use dwesgram\modelo\Entrada;

if ($datosParaVista['datos'] === null || !$datosParaVista['datos']) {
    echo "<p>No hay entradas publicadas<p>";
} else {
    echo "<div>";
    echo "<hr>";
    foreach ($datosParaVista['datos'] as $entrada) {
        if ($entrada instanceof Entrada) {
            $id = $entrada->getId();
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();

            echo "<div>";
            echo "<p>$texto</p>";
            if ($imagen !== null) {
                echo "<img src=\"$imagen\"></img>";
            }
            echo <<<END
                <p>
                    <a href=\"index.php?controlador=entrada&accion=detalle&id=$id\">Detalles</a>
                    |
                    <a href=\"index.php?controlador=entrada&accion=eliminar&id=$id\">Eliminar</a>
                </p>
            END;
            echo "</div>";
            echo "<hr>";
        }
    }
    echo "</div>";
}
