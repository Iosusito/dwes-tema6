<?php

namespace dwesgram\modelo;

use dwesgram\modelo\BaseDatos;
use dwesgram\modelo\Entrada;

class EntradaBD
{
    use BaseDatos;

    public static function getEntrada(int $id): Entrada|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select * from entrada where id=?"
            );
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Entrada(
                    id: $fila['id'],
                    texto: $fila['texto'],
                    imagen: $fila['imagen'],
                    autor: $fila['autor'],
                    creado: $fila['creado']
                );
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Devuelve un array de objetos tipo Entrada
     */
    public static function getAllEntradas(): array|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $resultado = $conexion->query("select * from entrada order by creado");
            $listaEntradas = [];
            if ($resultado !== false) {
                while (($fila = $resultado->fetch_assoc()) != null) {
                    $entrada = new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        imagen: $fila['imagen'],
                        autor: $fila['autor'],
                        creado: $fila['creado']
                    );
                    $listaEntradas[] = $entrada;
                }
            }

            return $listaEntradas;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function existeEntrada(int $id): bool|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "select * from entrada where id=?"
            );

            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();

            return $fila != null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function insertar(Entrada $entrada): int|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "insert into entrada (texto, imagen, autor) values (?, ?, ?)"
            );
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            $autor = $entrada->getAutor();
            $sentencia->bind_param(
                "ssi",
                $texto,
                $imagen,
                $autor
            );
            $sentencia->execute();

            return $conexion->insert_id;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function moverImagenEntrada(string $ruta) : bool
    {
        $fichero = $_FILES['imagen']['tmp_name'];

        $movido = move_uploaded_file($fichero, $ruta);

        return $movido;
    }

    public static function eliminar(int $id): bool|null
    {
        try {
            $conexion = BaseDatos::getConexion();

            $sentencia = $conexion->prepare(
                "delete from entrada where id=?"
            );
            $sentencia->bind_param("i", $id);
            $eliminado = $sentencia->execute();

            return $eliminado;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function eliminarImagenEntrada(string $ruta) : bool
    {
        return unlink($ruta);
    }
}