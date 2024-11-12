<?php

function mensaje_popup($mensaje) {
    echo "<script>
            alert('$mensaje');
            window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
          </script>";
    exit();
}

function plataforma_pago($id_compra, $total) {
  echo "<script>
  alert('Compra ID: $id_compra, Total a pagar: $total');
  window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
  </script>";
  exit();
}

function enviar_correo($nombre, $email, $mensaje) {
  echo "<script>
  alert('Nombre: $nombre, Email: $email, Mensaje: $mensaje');
  window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
  </script>";
  exit();

  /*// Configuración del correo
  $to = "thePersistent@tu-dominio.com";  // Reemplaza con el correo de destino
  $subject = "Nueva solicitud de contacto";
  $body = "Nombre: $nombre\nCorreo Electrónico: $email\nMensaje:\n$mensaje";
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";*/

}
?>