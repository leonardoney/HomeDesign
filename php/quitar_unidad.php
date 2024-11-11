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

        // Obtener la cantidad comprada del producto
        $sql_select = "SELECT cantidad_comprada FROM items_x_compra WHERE id_compra = :id_compra AND codigo_producto = :producto";
        $stmt = $pdo->prepare($sql_select);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el producto está en la tabla items_x_compra
        if ($item) {
            // Verificar si la cantidad comprada es mayor que 1
            if ($item['cantidad_comprada'] > 1) {
                // Disminuir la cantidad_comprada en 1
                $cantidad_comprada = $item['cantidad_comprada'] - 1;

                // Actualizar la cantidad_comprada en la tabla items_x_compra
                $sql_update = "UPDATE items_x_compra SET cantidad_comprada = :cantidad_comprada WHERE id_compra = :id_compra AND codigo_producto = :producto";
                $stmt = $pdo->prepare($sql_update);
                $stmt->bindParam(':cantidad_comprada', $cantidad_comprada, PDO::PARAM_INT);
                $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
                $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
                $stmt->execute();

                // Actualizar el stock en la tabla productos
                $sql_update_stock = "UPDATE productos SET stock = stock + 1 WHERE codigo_producto = :producto";
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
                // No se puede quitar más unidades si la cantidad comprada es 1
                $pdo->rollBack();
                mensaje_popup('No se puede retirar más unidades de este producto');
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
