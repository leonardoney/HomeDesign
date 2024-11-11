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

?>