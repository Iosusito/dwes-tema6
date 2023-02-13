<?php

namespace dwesgram\modelo;

class Sesion
{
    private int|null $id;
    private string|null $nombre; 

    public function __construct()
    {
        $this->id = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id']) ? htmlspecialchars(trim($_SESSION['usuario']['id'])) : null;
        $this->nombre = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre']) ? htmlspecialchars(trim($_SESSION['usuario']['nombre'])) : null;
    }

    public function sesionIniciada(): bool
    {
        return $this->id !== null && $this->nombre !== null;
    }

    public function usuarioAutenticado(int $id): bool
    {
        return $this->id === $id;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getNombre(): string|null
    {
        return $this->nombre;
    }
}
