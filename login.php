<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión - HomeDesign</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/botones.css" />
</head>

<?php
include 'php/db_connection.php';
include 'php/subrutinas.php';

// Procesar el formulario de inicio de sesión
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $clave_usuario = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $nombre_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if ($nombre_usuario === $usuario['id_usuario'] && $clave_usuario === $usuario['password']) {
            $sql = "SELECT MAX(id_compra) AS max_id_compra FROM compras";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_compra = isset($result['max_id_compra']) ? $result['max_id_compra'] + 1 : 1;

            session_start();
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['id_compra'] = $id_compra;
            header("Location: tienda.html");
            exit();
        } else {
            $error = 'Usuario o contraseña incorrecta';
        }
    } else {
        $error = 'No se encontró una cuenta con ese nombre de usuario';
    }
}
?>

<body>
<header>
    <section id="navigation">
        <nav class="navbar navbar-light bg-warning w-100">
            <a class="navbar-brand" href="index.html">
                <img src="image/HomeDesing logo.png" alt="logo" width="60" height="35" class="d-inline-block align-top" />
                HomeDesign
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img width="40" height="35" src="https://img.icons8.com/fluency/48/menu--v1.png" alt="menu--v1"/>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="tienda.html">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                </ul>
            </div>
        </nav>
    </section>
</header>

<div class="container mt-5">
    <h1 class="text-center">Iniciar Sesión</h1>
    <p class="text-center">Introduce tus datos para acceder a tu cuenta</p>

    <div class="row justify-content-center">
        <div class="container">
            <form method="post">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-sample">Iniciar Sesión</button>
                </div>
                
                <div class="text-center">
                    <a href="recuperacion.html" class="text-primary">¿Olvidaste tu contraseña?</a>
                </div>

                <div class="text-center">
                    <p>¿No tienes cuenta? Crea una ahora.</p>
                    <a href="registro.html" class="btn btn-sample">Regístrate aquí</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para mostrar errores -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <?= htmlspecialchars($error) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-warning text-center mt-5">
    <div class="p-3 bg-warning">
        © 2024 HomeDesign. Todos los derechos reservados.
        <a href="contacto.html" class="text ml-3">Contacto</a>
        <a href="sobre-nosotros.html" class="text ml-3">Sobre Nosotros</a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Mostrar el modal si hay un error
    <?php if ($error): ?>
    $(document).ready(function() {
        $('#errorModal').modal('show');
    });
    <?php endif; ?>
</script>
</body>
</html>
