<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Configuración del correo
    $to = "thePersistent@tu-dominio.com";  // Reemplaza con el correo de destino
    $subject = "Nueva solicitud de publicidad";
    $body = "Nombre: $nombre\nCorreo Electrónico: $email\nMensaje:\n$mensaje";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Enviar el correo
    if (mail($to, $subject, $body, $headers)) {
        echo "El mensaje ha sido enviado exitosamente.";
    } else {
        echo "Hubo un error al enviar el mensaje. Por favor, intenta nuevamente.";
    }
}
?>
