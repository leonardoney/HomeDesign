<?php
include 'db_connection.php';
include 'subrutinas.php';

$codigo_producto = $_POST['codigo_producto'];
$cantidad = 1;  // Estático por ahora, puedes permitir que el usuario lo elija.
$id_compra = $_SESSION['id_compra'];

// Obtener el precio y el stock del producto desde la tabla productos.
$sql_precio_stock = "SELECT precio, stock FROM productos WHERE codigo_producto = :codigo_producto LIMIT 1";
$stmt = $pdo->prepare($sql_precio_stock);
$stmt->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_INT);
$stmt->execute();
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    $precio_item = $producto['precio'];
    $stock_actual = $producto['stock'];

    if ($stock_actual >= $cantidad) {
        try {
            // Iniciar transacción
            $pdo->beginTransaction();
            
            // Agregar el producto al carrito
            $sql_insert = "INSERT INTO items_X_compra (id_compra, codigo_producto, cantidad_comprada, precio_item) 
                           VALUES (:id_compra, :codigo_producto, :cantidad_comprada, :precio_item)";
            $stmt = $pdo->prepare($sql_insert);
            $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
            $stmt->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad_comprada', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio_item', $precio_item, PDO::PARAM_STR);
            $stmt->execute();
            
            // Actualizar el stock en la tabla productos
            $sql_update_stock = "UPDATE productos SET stock = stock - :cantidad WHERE codigo_producto = :codigo_producto";
            $stmt = $pdo->prepare($sql_update_stock);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar la transacción
            $pdo->commit();

            // Mensaje de éxito
            mensaje_popup('Producto agregado al carrito con éxito');
        } catch (PDOException $e) {
            // Revertir la transacción si ocurre un error
            $pdo->rollBack();
            mensaje_popup('Hubo un error al agregar el producto al carrito');
        }
    } else {
        mensaje_popup('Stock insuficiente para el producto seleccionado');
    }
} else {
    mensaje_popup('No se encontró el producto');
}
?>
