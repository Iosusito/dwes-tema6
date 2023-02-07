<?php
use dwesgram\modelo\UsuarioBD;

$entrada = $datosParaVista['datos'];

$id = $entrada->getId();
$texto = $entrada->getTexto();
$imagenRuta = $entrada->getImagen();
$autor = UsuarioBD::getNombreUsuario($entrada->getAutor());
$creado = date('d/m/Y', $entrada->getCreado());
?>

<h2><?= $autor ?> escribió</h2>

<p><?= $texto ?></p>

<?php
if ($imagenRuta !== null) {
    echo "<img src=\"$imagenRuta\" alt=\"Imagen\">";
}
?>

<p>Publicado: <?= $creado ?></p>

<a href="index.php?controlador=entrada&accion=eliminar&id=<?= $id ?>">Eliminar</a>