<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Entrada extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $texto,
        private int|null $id = null,
        private string|null $imagen = null,
        private int|null $autor = null,
        private int|null $creado = null
    ) {
        $this->autor = 1;
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null
        ];
    }

    public static function CrearEntradaDesdePost(array $post): Entrada|null
    {
        if (!isset($post['texto'])) {
            return null;
        }
        
        $texto = mb_substr(htmlspecialchars(trim($post['texto'])), 0, 128);

        if (
            $_FILES && isset($_FILES['imagen']) &&
            $_FILES['imagen']['error'] === UPLOAD_ERR_OK &&
            $_FILES['imagen']['size'] > 0
        ) {
            $fichero = $_FILES['imagen']['tmp_name'];

            $permitido = array('image/png', 'image/jpeg');

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fichero);

            if (!in_array($mime, $permitido)) {
                return null;
            }

            $imagen = "assets/img/" . 
            time() .
            basename($_FILES['imagen']['name']);
        }

        $entrada = new Entrada(
            texto: $texto,
            imagen: isset($imagen) ? $imagen : null
        );
        return $entrada;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getImagen(): string|null
    {
        return $this->imagen;
    }

    public function getAutor(): int|null
    {
        return $this->autor;
    }

    public function getCreado(): int|null
    {
        return $this->creado;
    }

    public function esValida(): bool
    {
        return count(array_filter($this->errores, fn ($err) => $err != null)) == 0;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
