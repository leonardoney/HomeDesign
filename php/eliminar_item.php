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

        // Obtener la cantidad a devolver al stock desde la tabla items_x_compra
        $sql_select = "SELECT cantidad_comprada FROM items_x_compra WHERE id_compra = :id_compra AND codigo_producto = :producto";
        $stmt = $pdo->prepare($sql_select);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $cantidad_a_devolver = $item['cantidad_comprada'];

            // Eliminar el item del carrito
            $sql_delete = "DELETE FROM items_x_compra WHERE id_compra = :id_compra AND codigo_producto = :producto";
            $stmt = $pdo->prepare($sql_delete);
            $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
            $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar si la eliminación fue exitosa
            if ($stmt->rowCount() > 0) {
                // Actualizar el stock en la tabla productos
                $sql_update_stock = "UPDATE productos SET stock = stock + :cantidad WHERE codigo_producto = :producto";
                $stmt = $pdo->prepare($sql_update_stock);
                $stmt->bindParam(':cantidad', $cantidad_a_devolver, PDO::PARAM_INT);
                $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
                $stmt->execute();

                // Confirmar la transacción
                $pdo->commit();
                mensaje_popup('Item eliminado exitosamente');
                
            } else {
                // Revertir la transacción si la eliminación no tuvo éxito
                $pdo->rollBack();
                mensaje_popup('No se pudo eliminar el item');
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
