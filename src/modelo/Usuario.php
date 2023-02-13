<?php

namespace dwesgram\modelo;

class Usuario extends Modelo
{
    public function __construct(
        private string|null $nombre,
        private string|null $email,
        private string|null $clave,
        private int|null $id = null,
        private string|null $avatar = "assets/img/avatar_predefinido.jpg",
        private int|null $registrado = null
    ) {
        $this->errores = [
            'nombre' => $nombre === null || empty($nombre) ? 'El nombre no puede estar vacío' : null,
            'clave' => $clave === null || empty($clave) ? 'La clave no puede estar vacía' : null,
            'repiteClave' => null,
            'email' => $email === null || empty($email) ? 'El email no puede estar vacío' : null,
            'avatar' => null
        ];
    }

    public static function crearUsuarioDesdePost(array $post): Usuario|null
    {
        $nombre = isset($post['nombre']) ? htmlspecialchars(trim($post['nombre'])) : null;
        $clave = isset($post['clave']) ? htmlspecialchars(trim($post['clave'])) : null;
        $email = isset($post['email']) ? htmlspecialchars(trim($post['email'])) : null;

        $usuario = new Usuario(
            nombre: $nombre,
            clave: $clave,
            email: $email
        );

        if (mb_strlen($usuario->getNombre()) > 10) {
            $usuario->errores['nombre'] = "Longitud máxima de 10 carácteres";
        }

        if (!isset($post['repiteClave']) || empty($post['repiteClave'])) {
            $usuario->errores['repiteClave'] = "La repetición de clave no puede estar vacía";
        } elseif ($post['clave'] !== $post['repiteClave']) {
            $usuario->errores['clave'] = "Las claves no coindiden";
        }

        if (
            $_FILES && isset($_FILES['avatar']) &&
            $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
            $_FILES['avatar']['size'] > 0
        ) {
            $fichero = $_FILES['avatar']['tmp_name'];

            $permitido = array('image/png', 'image/jpeg');

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fichero);

            if (!in_array($mime, $permitido)) {
                $usuario->errores['avatar'] = "extension no soportada";
                return $usuario;
            }

            $usuario->avatar = "assets/img/avatar-" .
                $usuario->getNombre() . "-" .
                basename($_FILES['avatar']['name']);
        }

        return $usuario;
    }

    public function getNombre(): string|null
    {
        return $this->nombre;
    }

    public function getClave(): string|null
    {
        return $this->clave;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getAvatar(): string|null
    {
        return $this->avatar;
    }

    public function getRegistrado(): int|null
    {
        return $this->registrado;
    }
}
