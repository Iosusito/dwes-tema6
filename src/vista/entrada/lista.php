<?php

use dwesgram\modelo\UsuarioBD;

if ($datosParaVista['datos'] === null || !$datosParaVista['datos']) {
    echo "<p>No hay entradas publicadas<p>";
} else {
    echo "<div>";
    echo "<hr>";
    foreach ($datosParaVista['datos'] as $entrada) {
        $id = $entrada->getId();
        $texto = $entrada->getTexto();
        $imagen = $entrada->getImagen();
        $autor = UsuarioBD::getNombreUsuario($entrada->getAutor());

        echo "<div>";
        echo "<p>$autor escribió:</p>";
        echo "<p>$texto</p>";
        if ($imagen !== null) {
            echo "<img src=\"$imagen\"></img>";
        }
        echo "<p><a href=\"index.php?controlador=entrada&accion=detalle&id=$id\">Detalles</a>";
        if ($sesion->usuarioAutenticado($entrada->getAutor())) {
            echo " | <a href=\"index.php?controlador=entrada&accion=eliminar&id=$id\">Eliminar</a>";
        }
        echo "</p>";
        echo "</div>";
        echo "<hr>";
    }
    echo "</div>";
}
