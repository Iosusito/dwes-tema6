<?php

namespace dwesgram\modelo;

class UsuarioBD 
{
    use BaseDatos;

    public static function getNombreUsuario(int $id) : string|null
    {
        return "iosu";
    }
}
