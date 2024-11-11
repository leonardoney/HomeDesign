<?php
include 'db_connection.php';
include 'subrutinas.php';

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $direccion = $_POST['direccion'];
    $codigo_postal = $_POST['codigo_postal'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];

    // Validar los datos (esto puede mejorarse según tus necesidades)
    if (empty($nombre_usuario) || empty($password) || empty($nombre) || empty($apellido) || empty($email) || empty($dni) || empty($direccion) || empty($codigo_postal) || empty($localidad) || empty($provincia)) {
        mensaje_popup('Todos los campos son obligatorios');
    }

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (id_usuario, password, email, nombre, apellido, dni, telefono, direccion, codigo_postal, localidad, provincia) 
            VALUES (:id_usuario, :password, :email, :nombre, :apellido, :dni, :telefono, :direccion, :codigo_postal, :localidad, :provincia)";
    
    try {
        // Preparar la sentencia con PDO
        $stmt = $pdo->prepare($sql);
        
        // Asignar los valores a los parámetros
        $stmt->bindParam(':id_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_INT);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':codigo_postal', $codigo_postal, PDO::PARAM_INT);
        $stmt->bindParam(':localidad', $localidad, PDO::PARAM_STR);
        $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
        
        // Ejecutar la sentencia SQL
        $stmt->execute();
        
        // Redirigir a la página de éxito o inicio de sesión
        echo "<script>
        alert('Registro exitoso');
        window.location.href = '../login.html';
        </script>";
    } catch (PDOException $e) {
        // Manejo de errores
        mensaje_popup('Error al registrar el usuario');
    }
}

?>
