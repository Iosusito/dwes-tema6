<?php
namespace dwesgram\controlador;

abstract class Controlador
{
    protected string|null $vista = null;

    public function getVista(): string|null
    {
        return $this->vista;
    }
}