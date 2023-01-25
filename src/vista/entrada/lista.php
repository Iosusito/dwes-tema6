<?php

use dwesgram\modelo\Entrada;

$entradas = $datosParaVista['datos'] == null ? [] : $datosParaVista['datos'];

echo "<p>Esta es una lista de las publicaciones de la red social</p>";

echo "<div>";
foreach ($entradas as $entrada) {
    if ($entrada instanceof Entrada) {
        $id = $entrada->getId();
        $texto = $entrada->getTexto();
        $imagen = $entrada->getImagen();
        echo <<<END
        <div>
            <img src="$imagen"></img>
            <p>$texto</p>
            <a href="index.php?controlador=entrada&accion=detalle&id=$id">Detalles</a>
            <a href="index.php?controlador=entrada&accion=eliminar&id=$id">Eliminar</a>
        </div>
        END;
    }
}
echo "</div>";