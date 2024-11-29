<?php
// Incluir conexión a la base de datos
include 'db_connection.php';

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {
        // Verificar si el correo electrónico existe en la base de datos
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Generar una contraseña temporal
            $nueva_password = substr(bin2hex(random_bytes(4)), 0, 8);

            // Actualizar la contraseña del usuario en la base de datos
            $sql = "UPDATE usuarios SET password = :password WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':password', $nueva_password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Enviar el correo electrónico con la nueva contraseña
            $asunto = "Tu nueva contraseña";
            $mensaje = "
                <html>
                <body>
                    <h2>Recuperación de contraseña</h2>
                    <p>Hola, hemos generado una nueva contraseña para tu cuenta:</p>
                    <p><strong>$nueva_password</strong></p>
                    <p>Te recomendamos iniciar sesión y cambiar tu contraseña inmediatamente.</p>
                </body>
                </html>
            ";
            $cabeceras = "MIME-Version: 1.0" . "\r\n";
            $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $cabeceras .= "From: no-reply@tusitio.com" . "\r\n";

            if (mail($email, $asunto, $mensaje, $cabeceras)) {
                echo "<script>alert('Hemos enviado una nueva contraseña a tu correo electrónico.');</script>";
            } else {
                echo "<script>alert('No se pudo enviar el correo. Por favor, inténtalo más tarde.');</script>";
            }
        } else {
            echo "<script>alert('No se encontró una cuenta con ese correo electrónico.');</script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
