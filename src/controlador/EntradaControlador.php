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

    public function detalle(): Entrada|null
    {
        $this->vista = "entrada/detalle";
        return null;
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

        $id = EntradaBD::insertar($entrada);
        if ($id !== null) {
            $this->vista = "entrada/detalle";
            return EntradaBD::getEntrada($id);
        }

        $this->vista = "entrada/nuevo";
        return $entrada;
    }

    public function eliminar(): bool|null
    {
        if (!$_GET || !isset($_GET['id'])) {
            $this->vista = "entrada/lista";
            return null;
        }

        $id = htmlspecialchars(trim($_GET['id']));
        if (!is_numeric($id)) {
            $this->vista = "entrada/lista";
            return null;
        }

        if (!EntradaBD::existeEntrada($id)) {
            $this->vista = "entrada/lista";
            return null;
        }

        $eliminado = EntradaBD::eliminar($id);
        if ($eliminado) {
            $this->vista = "entrada/eliminada";
            return true;
        }

        $this->vista = "entrada/lista";
        return $eliminado;
    }
}
