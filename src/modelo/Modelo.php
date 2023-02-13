<?php
namespace dwesgram\modelo;

abstract class Modelo
{
    protected array $errores = [];

    public function getErrores(): array{
        return $this->errores;
    }

    public function esValido(): bool
    {
        return count(array_filter($this->errores, fn ($err) => $err != null)) == 0;
    }
}
