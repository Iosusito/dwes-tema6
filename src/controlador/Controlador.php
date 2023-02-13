<?php
namespace dwesgram\controlador;

use dwesgram\modelo\Sesion;

abstract class Controlador
{
    protected string|null $vista = null;

    public function getVista(): string|null
    {
        return $this->vista;
    }

    public function sesionIniciada(): bool
    {
        return (new Sesion())->sesionIniciada();
    }

    public function usuarioAutenticado(int $id): bool
    {
        return (new Sesion())->usuarioAutenticado($id);
    }
}