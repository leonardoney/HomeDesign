<?php
include 'db_connection.php';
include 'subrutinas.php';

// Verificar si se ha enviado el parámetro necesario (id_compra y producto)
if (isset($_POST['id_compra']) && isset($_POST['producto'])) {
    $id_compra = $_POST['id_compra'];
    $producto = $_POST['producto'];

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Obtener la cantidad comprada y el stock disponible del producto
        $sql_select = "SELECT cantidad_comprada FROM items_x_compra WHERE id_compra = :id_compra AND codigo_producto = :producto";
        $stmt = $pdo->prepare($sql_select);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el producto está en la tabla items_x_compra
        if ($item) {
            // Obtener el stock disponible del producto
            $sql_stock = "SELECT stock FROM productos WHERE codigo_producto = :producto";
            $stmt = $pdo->prepare($sql_stock);
            $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
            $stmt->execute();
            $producto_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto_info) {
                $stock_disponible = $producto_info['stock'];

                // Verificar si hay suficiente stock para agregar una unidad más
                if ($stock_disponible > 0) {
                    // Aumentar la cantidad_comprada en 1
                    $cantidad_comprada = $item['cantidad_comprada'] + 1;

                    // Actualizar la cantidad_comprada en la tabla items_x_compra
                    $sql_update = "UPDATE items_x_compra SET cantidad_comprada = :cantidad_comprada WHERE id_compra = :id_compra AND codigo_producto = :producto";
                    $stmt = $pdo->prepare($sql_update);
                    $stmt->bindParam(':cantidad_comprada', $cantidad_comprada, PDO::PARAM_INT);
                    $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
                    $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
                    $stmt->execute();

                    // Disminuir el stock en la tabla productos
                    $sql_update_stock = "UPDATE productos SET stock = stock - 1 WHERE codigo_producto = :producto";
                    $stmt = $pdo->prepare($sql_update_stock);
                    $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
                    $stmt->execute();

                    // Confirmar la transacción
                    $pdo->commit();
                    echo "<script>
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                    </script>";
                    exit();
                } else {
                    // No hay suficiente stock
                    $pdo->rollBack();
                    mensaje_popup('No hay suficiente stock para agregar una unidad');
                }
            } else {
                // Producto no encontrado en la tabla productos
                $pdo->rollBack();
                mensaje_popup('Producto no encontrado');
            }
        } else {
            // No se encontró el item en la tabla items_x_compra
            $pdo->rollBack();
            mensaje_popup('Item no encontrado en el carrito');
        }
    } catch (PDOException $e) {
        // Revertir la transacción si ocurre un error
        $pdo->rollBack();
        mensaje_popup('Hubo un error: ' . $e->getMessage());
    }

    // Cerrar la conexión
    $stmt = null;
    $pdo = null;

    // Devolver los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no se recibieron los parámetros necesarios, enviar un error
    mensaje_popup('Parámetros faltantes');
}
?>
