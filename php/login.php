<?php

include 'db_connection.php';
include 'subrutinas.php';

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario']; // Cambiado de 'email' a 'nombre_usuario'
    $clave_usuario = $_POST['password'];

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1"; // Cambiado de 'email' a 'nombre_usuario'
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $nombre_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Verificar la contraseña
        if ($nombre_usuario === $usuario['id_usuario'] && $clave_usuario === $usuario['password']) {
            // Consulta para obtener el ID de compra más grande
            $sql = "SELECT MAX(id_compra) AS max_id_compra FROM compras";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_compra = isset($result['max_id_compra']) ? $result['max_id_compra'] + 1 : 1;

            // Iniciar la sesión, generar id_compra y redirigir al usuario
            //session_start();
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['id_compra'] = $id_compra;
            header("Location: ../tienda.html");
            exit();
        } else {
            mensaje_popup('Usuario o contraseña incorrecta');
        }
    } else {
        mensaje_popup('No se encontró una cuenta con ese nombre de usuario');
    }
}

?>
