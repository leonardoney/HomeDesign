<?php
include 'db_connection.php';
include 'subrutinas.php';

// ID de la compra actual
$id_compra = $_SESSION['id_compra'];
$id_usuario = $_SESSION['user_id'];

// Consultar los productos del carrito para la compra específica
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
}

// Cerrar la conexión
$stmt = null;
$pdo = null;

// Invocar plataforma de pagos
plataforma_pago($id_compra, $total);

?>
