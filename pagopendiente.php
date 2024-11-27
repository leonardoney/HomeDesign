<!-- Vaciar carrito -->
<?php
include 'php/db_connection.php';
include 'php/subrutinas.php';

// Verificar si se han enviado los parámetros necesarios (id_compra e id_usuario)
if (isset($_SESSION['id_compra']) && isset($_SESSION['user_id'])) {
    $id_compra = $_SESSION['id_compra'];
    $id_usuario = $_SESSION['user_id'];

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Eliminar registros de la tabla items_x_compra según id_compra y id_usuario
        $sql_delete = "DELETE FROM items_x_compra
                       WHERE id_compra = :id_compra
                       AND id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql_delete);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        $stmt->execute();

        // Confirmar la transacción
        $pdo->commit();
    } catch (PDOException $e) {
        // Revertir la transacción si ocurre un error
        $pdo->rollBack();
        mensaje_popup('Error al vaciar el carrito: ' . $e->getMessage());
    }

    // Cerrar la conexión
    $stmt = null;
    $pdo = null;
} else {
    // Si no se recibieron los parámetros necesarios, enviar un error
    mensaje_popup('Parámetros faltantes');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito de Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/botones.css" />
    <link rel="stylesheet" href="css/cajas.css" />
</head>
<body>
  <!-- Navegación -->
  <header>
    <section id="navigation">
      <nav class="navbar navbar-light bg-warning w-100">
        <a class="navbar-brand" href="index.html">
            <img src="image/HomeDesing logo.png" alt="logo" width="60" height="35" class="d-inline-block align-top" />
            HomeDesign
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img width="40" height="35" src="https://img.icons8.com/fluency/48/menu--v1.png" alt="menu"/>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="tienda.php">Tienda</a></li>
                <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="login.html">Iniciar Sesión</a></li>
            </ul>
        </div>
      </nav>
    </section>
  </header>

  <div class="container mt-5">
      <h1 class="text-center">Su pago se encuentra pendiente de acreditación</h1>
      <h6 class="t">Puede regresar a la tienda y seguir comprando</h6>
      <br><br><br><br>
      <div class="text-center">
        <a href="tienda.php" class="btn btn-sample">Regresar a la tienda</a>
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

  <!-- Scripts de Bootstrap y JavaScript para cargar los datos del carrito -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>
</html>