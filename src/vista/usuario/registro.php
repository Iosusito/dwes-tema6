<div class="container">
    <h1>Regístrate</h1>

    <form action="index.php?controlador=usuario&accion=registro" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label><br>
            <input type="email" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <div class="mb-3">
            <label for="repiteclave" class="form-label">Repite la contraseña</label><br>
            <input type="password" id="repiteclave" name="repiteclave">
        </div>
        <div class="mb-3">
            <label for="avatar">Puedes elegir un avatar</label><br>
            <input class="form-control" type="file" name="avatar" id="avatar">
        </div>
        <button type="submit" class="btn btn-primary">Crear cuenta</button>
    </form>
</div>
