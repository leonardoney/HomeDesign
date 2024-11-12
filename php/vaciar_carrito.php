<?php
include 'db_connection.php';
include 'subrutinas.php';

// Verificar si se han enviado los parámetros necesarios (id_compra e id_usuario)
if (isset($_POST['id_compra']) && isset($_SESSION['user_id'])) {
    $id_compra = $_POST['id_compra'];
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
        mensaje_popup('Se ha vaciado el carrito');
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
