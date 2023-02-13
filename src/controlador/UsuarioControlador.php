<?php

namespace dwesgram\controlador;

use dwesgram\modelo\EntradaBD;
use dwesgram\modelo\Usuario;
use dwesgram\modelo\UsuarioBD;

class UsuarioControlador extends Controlador
{
    public function login(): array|null
    {
        if ($this->sesionIniciada()) {
            $this->vista = "errores/403";
            return null;
        }

        if (!$_POST) {
            $this->vista = "usuario/login";
            return null;
        }

        $datos = [
            'nombre' => isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : "",
            'errores' => [
                'nombre' => !isset($_POST['nombre']) || empty($_POST['nombre']) ? 'El nombre no puede estar vacío' : null,
                'clave' => !isset($_POST['clave']) || empty($_POST['clave']) ? 'La contraseña no puede estar vacía' : null
            ]
        ];

        if (
            $datos['errores']['nombre'] !== null ||
            $datos['errores']['clave'] !== null
        ) {
            $this->vista = "usuario/login";
            return $datos;
        }

        $nombre = $datos['nombre'];
        $clave = htmlspecialchars(trim($_POST['clave']));

        $existeUsuario = UsuarioBD::existeUsuario($nombre);
        if ($existeUsuario === null) {
            $this->vista = "errores/500";
            return null;
        }

        if (!$existeUsuario) {
            $datos['errores']['clave'] = "Nombre y/o contraseña incorrectos";

            $this->vista = "usuario/login";
            return $datos;
        }

        $usuario = UsuarioBD::getUsuario($nombre);
        if ($usuario === null) {
            $this->vista = "errores/500";
            return null;
        }

        if (!password_verify($clave, $usuario->getClave())) {
            $datos['errores']['clave'] = "Nombre y/o contraseña incorrectos";

            $this->vista = "usuario/login";
            return $datos;
        }

        //se logea
        $_SESSION['usuario']['id'] = $usuario->getId();
        $_SESSION['usuario']['nombre'] = $usuario->getNombre();

        $this->vista = "entrada/lista";
        return EntradaBD::getAllEntradas();
    }

    public function registro(): Usuario|array|null
    {
        if ($this->sesionIniciada()) {
            $this->vista = "errores/403";
            return null;
        }

        if (!$_POST) {
            $this->vista = "usuario/registro";
            return null;
        }

        $usuario = Usuario::crearUsuarioDesdePost($_POST);
        if ($usuario === null || !$usuario->esValido()) {
            $this->vista = "usuario/registro";
            return $usuario;
        }

        if ($usuario->getAvatar() != "assets/img/avatar_predefinido.jpg") {
            $ok = UsuarioBD::moverImagenAvatar($usuario->getAvatar());
            if (!$ok) {
                $this->vista = "errores/500";
                return null;
            }
        }

        $id = UsuarioBD::insertar($usuario);
        if ($id == null) {
            $this->vista = "errores/500";
            return null;
        }

        //se logea
        $_SESSION['usuario']['id'] = $id;
        $_SESSION['usuario']['nombre'] = $usuario->getNombre();

        $this->vista = "entrada/lista";
        return EntradaBD::getAllEntradas();
    }

    public function logout()
    {
        if (!$this->sesionIniciada()) {
            $this->vista = "errores/403";
            return null;
        }

        session_destroy();

        $this->vista = "usuario/logout";
        return null;
    }
}
