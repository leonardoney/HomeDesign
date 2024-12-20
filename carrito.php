<!-- PHP para mercadopago -->
<?php

include 'php/db_connection.php';

// ID de la compra actual
$id_compra = $_SESSION['id_compra'];
$id_usuario = $_SESSION['user_id'];

// Consultar los productos del carrito para la compra específica
// $sql = "SELECT * FROM items_x_compra WHERE id_compra = :id_compra";
$sql = "SELECT i.*, p.nombre FROM items_x_compra i
JOIN productos p ON i.codigo_producto = p.codigo_producto
WHERE i.id_compra = :id_compra AND i.id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
$items = [];

// Cerrar la conexión
$stmt = null;
$pdo = null;

// Desactiva la notificación de errores deprecados en PHP
error_reporting(~E_DEPRECATED);

// Carga el autoload de Composer para gestionar dependencias
require_once 'vendor/autoload.php';

// Importa las clases necesarias del SDK de MercadoPago
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

//Si hay productos en el carrito, crear items para pago
if (!empty($result)) {
    
// Agrega credenciales ACCESS_TOKEN
MercadoPagoConfig::setAccessToken("APP_USR-1186059779117849-111200-34340602b93556944f57fe01c278abe2-2092484724");

// Crea una instancia del cliente de preferencias de MercadoPago
$client = new PreferenceClient();

// Crea una preferencia de pago con los detalles del producto y otras configuraciones
// Recorrer los resultados de la consulta
foreach ($result as $row) {
    $subtotal = $row['cantidad_comprada'] * $row['precio_item'];
    $total += $subtotal;
    $items[] = [
        'id_compra' => $row['id_compra'],
        'producto' => $row['codigo_producto'],
        'descripcion' => $row['nombre'], 
        'precio' => $row['precio_item'],
        'cantidad' => $row['cantidad_comprada'],
        'subtotal' => $subtotal,
    ];

    $precio_item = floatval($row['precio_item']);
    $pref_item[] = [
            "id" => $row['codigo_producto'],
            "title" => $row['nombre'],
            "quantity" => $row['cantidad_comprada'],
            "unit_price" => $precio_item
    ];
}
$preference = $client->create([
    "items" => $pref_item,  // Aquí pasas la variable que contiene el arreglo de items
    "statement_descriptor" => "Home Desginer",  // Descripción extracto de la tarjeta del comprador    
    "external_reference" => "CDP001", // Ref externa de la transacción en el sistema del vendedor
]);
$preference->back_urls = array(
    "success" => "http://homedesign.infy.uk/pagoaprobado.php",
    "failure" => "http://homedesign.infy.uk/errordepago.php",
    "pending" => "http://homedesign.infy.uk/pagopendiente.php"
);
$preference->auto_return = "approved";
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
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
  <!-- Navegación -->
  <header>
    <section id="navigation">
      <nav class="navbar navbar-light bg-warning w-100">
        <a class="navbar-brand">
            <img src="image/HomeDesing logo.png" alt="logo" width="60" height="35" class="d-inline-block align-top" />
            HomeDesign
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img width="40" height="35" src="https://img.icons8.com/fluency/48/menu--v1.png" alt="menu"/>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="tienda.php">Tienda</a></li>
            </ul>
        </div>
      </nav>
    </section>
  </header>

  <div class="container mt-5">
      <h1 class="text-center">Tu Carrito de Compras</h1>
      <h6 class="t">Revisa los productos que seleccionaste</h6>
      <table class="table table-striped mt-4">
          <thead class="thead">
              <tr>
                  <th>Compra</th>
                  <th>Producto</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Subtotal</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody id="carrito-body">
              <!-- Los productos se mostrarán aquí mediante JavaScript -->
          </tbody>
      </table>
      <h3 class="text-right">Total: $<span id="total"></span></h3>

      <div class="text-right">


      <!--  
        <form action='php/eliminar_item.php' method='POST'>
            <input type='hidden' name='id_item' value='{$row['id_item']}' />
          </button>
          <button type="button" class="btn btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
</svg>

-->





          <form action="php/vaciar_carrito.php" method="POST" class="d-inline">
              <input type="hidden" name="id_compra" value="1" />
              <button type="submit" class="btn btn-outline-danger btn-vaciar">Vaciar Carrito</button>
          </form>
      </div>
  <div id="wallet_container"></div>

     <!--<div class="text-right">
          <form action="php/finalizar_compra.php" method="POST" class="d-inline">
              <input type="hidden" name="id_compra" value="1" />
              <button type="submit" class="btn btn-sample btn-fin">Finalizar Compra</button>
          </form>
      </div>-->
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
  <script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('php/obtener_carrito.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            const tbody = document.getElementById('carrito-body');
            tbody.innerHTML = '';

            // Verifica si hay items en el carrito
            if (data.items && data.items.length > 0) {
                data.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id_compra}</td>
                        <td>${item.producto}</td>
                        <td>${item.descripcion}</td>
                        <td>$${item.precio}</td>
                        <td>${item.cantidad}
                            <form action="php/agregar_unidad.php" method="POST">
                                <input type="hidden" name="id_compra" value="${item.id_compra}" />
                                <input type="hidden" name="producto" value="${item.producto}" />
                                <button type="submit" class="btn btn-outline-danger">+1</button>
                            </form>
                            <form action="php/quitar_unidad.php" method="POST">
                                <input type="hidden" name="id_compra" value="${item.id_compra}" />
                                <input type="hidden" name="producto" value="${item.producto}" />
                                <button type="submit" class="btn btn-outline-danger">-1</button>
                            </form>
                        </td>
                        <td>$${item.subtotal}</td>
                        <td>
                            <form action="php/eliminar_item.php" method="POST">
                                <input type="hidden" name="id_compra" value="${item.id_compra}" />
                                <input type="hidden" name="producto" value="${item.producto}" />
                                <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="7" class="text-center">No hay productos en el carrito</td>
                `;
                tbody.appendChild(row);
            }

            // Mostrar el total
            document.getElementById('total').textContent = data.total || 0;
        })
        .catch(error => console.error('Error al obtener los datos del carrito:', error));
});
  </script>
  <!-- Script de mercadopago -->
    <script defer>
      const mp = new MercadoPago('APP_USR-aec9b95c-7058-49a7-aa2f-9daa70ac92f5', {
        locale: 'es-AR'
      });

      mp.bricks().create("wallet", "wallet_container", {
        initialization: {
            preferenceId: '<?php echo $preference->id; ?>',
        },
      });
  </script>
</body>
</html>