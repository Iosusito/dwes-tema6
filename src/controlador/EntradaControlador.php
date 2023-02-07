<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBD;

class EntradaControlador extends Controlador
{
    public function lista(): array
    {
        $this->vista = "entrada/lista";
        return EntradaBD::getAllEntradas();
    }

    public function detalle(): Entrada|array|null
    {
        if (!$_GET || !isset($_GET['id'])) {
            $this->vista = "entrada/lista";
            return EntradaBD::getAllEntradas();
        }

        $id = htmlspecialchars(trim($_GET['id']));
        if (!is_numeric($id) || EntradaBD::existeEntrada($id) == null) {
            $this->vista = "entrada/lista";
            return EntradaBD::getAllEntradas();
        }

        $entrada = EntradaBD::getEntrada($id);
        if ($entrada === null) {
            $this->vista = "errores/500";
            return null;
        }

        $this->vista = "entrada/detalle";
        return $entrada;
    }

    public function nuevo(): Entrada|null
    {
        if (!$_POST) {
            $this->vista = "entrada/nuevo";
            return null;
        }

        $entrada = Entrada::CrearEntradaDesdePost($_POST);

        if ($entrada === null || !$entrada->esValida()) {
            $this->vista = "entrada/nuevo";
            return $entrada;
        }
        
        if ($entrada->getImagen() != null) {
            $ok = EntradaBD::moverImagenEntrada($entrada->getImagen());
            if (!$ok) {
                $this->vista = "errores/500";
                return null;
            }
        }

        $id = EntradaBD::insertar($entrada);
        if ($id != null) {
            
            $this->vista = "entrada/detalle";
            return EntradaBD::getEntrada($id);
        }

        $this->vista = "entrada/nuevo";
        return $entrada;
    }

    public function eliminar(): bool|array|null
    {
        if (!$_GET || !isset($_GET['id'])) {
            $this->vista = "entrada/lista";
            return null;
        }

        $id = htmlspecialchars(trim($_GET['id']));
        if (!is_numeric($id) || EntradaBD::existeEntrada($id) == null) {
            $this->vista = "entrada/lista";
            return EntradaBD::getAllEntradas();
        }

        $entrada = EntradaBD::getEntrada($id);
        if ($entrada === null) {
            $this->vista = "errores/500";
            return null;
        }

        if ($entrada->getImagen() != null) {
            EntradaBD::eliminarImagenEntrada($entrada->getImagen());
        }

        $eliminado = EntradaBD::eliminar($id);
        if ($eliminado) {
            $this->vista = "entrada/eliminada";
            return true;
        }

        $this->vista = "errores/500";
        return $eliminado;
    }
}
