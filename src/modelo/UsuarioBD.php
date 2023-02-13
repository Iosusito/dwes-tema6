<?php

namespace dwesgram\modelo;

class UsuarioBD
{
    use BaseDatos;

    public static function getNombreUsuario(int $id): string|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select nombre from usuario where id=?"
            );
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return $fila['nombre'];
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getAvatar(int $id): string|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select avatar from usuario where id=?"
            );
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return $fila['avatar'];
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function existeUsuario(string $nombre): bool|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select * from usuario where nombre=?"
            );
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();

            return $fila != null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getUsuario(string $nombre): Usuario|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select * from usuario where nombre=?"
            );
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();

            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    id: $fila['id'],
                    nombre: $fila['nombre'],
                    clave: $fila['clave'],
                    email: $fila['email'],
                    avatar: $fila['avatar'],
                    registrado: $fila['registrado']
                );
            }
            
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function insertar(Usuario $usuario): int|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "insert into usuario (nombre, clave, email, avatar) values (?, ?, ?, ?)"
            );
            $nombre = $usuario->getNombre();
            $clave = password_hash($usuario->getClave(), PASSWORD_BCRYPT);
            $email = $usuario->getEmail();
            $avatar = $usuario->getAvatar();
            $sentencia->bind_param("ssss", $nombre, $clave, $email, $avatar);
            $sentencia->execute();

            return $conexion->insert_id;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function moverImagenAvatar(string $ruta): bool
    {
        $fichero = $_FILES['avatar']['tmp_name'];

        $movido = move_uploaded_file($fichero, $ruta);

        return $movido;
    }
}
