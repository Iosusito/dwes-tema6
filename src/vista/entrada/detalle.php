<p>Detalle de una entrada</p>

<?php
$entrada = $datosParaVista['datos'];
//var_dump($entrada);
?>

<p><?= $entrada->getId() ?></p>
<p><?= $entrada->getTexto() ?></p>
<p><?= $entrada->getImagen() ?></p>
<p><?= $entrada->getAutor() ?></p>
<p><?= $entrada->getCreado() ?></p>