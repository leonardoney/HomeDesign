<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tienda-HomeDesign</title>
    <meta name="description" content="Mira todos los productos que tenemos para vos">
    <meta name="keywords" content="lampara, sofa, muebles, poltones">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css"/>
    <link rel="stylesheet"  href="css/botones.css"/>
    <link rel="stylesheet"  href="css/cajas.css"/>
</head>

    <!-- Navegación -->
    <header>
        <section id="navigation">
            <nav class="navbar navbar-light bg-warning w-100">
                <a class="navbar-brand">
                    <img src="image/HomeDesing logo.png" alt="logo" width="60" height="35" class="d-inline-block align-top" />
                    HomeDesign
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <img width="40" height="35" src="https://img.icons8.com/fluency/48/menu--v1.png" alt="menu--v1"/>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                    </ul>
                </div>
            </nav>
        </section>
    </header>
<body>
    <!-- Contenedor Principal -->
    <div class="container mt-5">
        <h1 class="text-center">La Tienda</h1>
        <h6 class="t">Explora nuestros productos y encuentra todo lo que necesitas para tu hogar</h6>
        
        <!-- Barra de Búsqueda -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form action="buscar.html" method="GET" class="form-inline d-flex justify-content-center">
                    <input class="form-control mr-2" type="search" placeholder="Buscar productos..." aria-label="Buscar" name="q" />
                    <button class="btn btn-sample" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <!-- Filtros de Categorías -->
        <div class="row mb-4">
            <div class="col-md-3">
                <h5>Categorías</h5>
                <div class="d-flex flex-column">
                    <button class="btn-sample mb-2" onclick="mostrarProductos('sofas')">Sofas</button>
                    <button class="btn-sample mb-2" onclick="mostrarProductos('mesas')">Mesas</button>
                    <button class="btn-sample mb-2" onclick="mostrarProductos('iluminacion')">Iluminación</button>
                    <button class="btn-sample mb-2" onclick="mostrarProductos('poltronas')">Poltronas</button>
                    <button class="btn-sample mb-2" onclick="mostrarProductos('todos')">Mostrar Todos</button>
                </div>
            </div>

            <!-- Catálogo de Productos -->
            <div class="col-md">
                <div class="row" id="catalogo">

                            <!-- Producto 1 sofa -->
                            <div class="col-md-4 producto sofas">
                                <div class="card mb-4">
                                    <img src="image/Meet.jpg" class="card-img-top" alt="Producto 1" />
                                    <div class="card-body">
                                        <h5 class="card-title">Sofa Meet</h5>
                                        <p class="card-text">$879.300,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="12">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 2 sofa -->
                            <div class="col-md-4 producto sofas">
                                <div class="card mb-4">
                                    <img src="image/Lerk.jpg" class="card-img-top" alt="Producto 2" />
                                    <div class="card-body">
                                        <h5 class="card-title">Sofa Lerk</h5>
                                        <p class="card-text">$989.700,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="11">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>                                
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 3 sofa -->
                            <div class="col-md-4 producto sofas">
                                <div class="card mb-4">
                                    <img src="image/Mestra.jpg" class="card-img-top" alt="Producto 3" />
                                    <div class="card-body">
                                        <h5 class="card-title">Sofa Mestra</h5>
                                        <p class="card-text">$1.200.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="10">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Producto 1 mesas -->
                            <div class="col-md-4 producto mesas">
                                <div class="card mb-4">
                                    <img src="image/Viena.jpg" class="card-img-top" alt="Producto 1" />
                                    <div class="card-body">
                                        <h5 class="card-title">Mesa Viena</h5>
                                        <p class="card-text">$2.300.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="20">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 2 mesas -->
                            <div class="col-md-4 producto mesas">
                                <div class="card mb-4">
                                    <img src="image/Elit.jpg" class="card-img-top" alt="Producto 2" />
                                    <div class="card-body">
                                        <h5 class="card-title">Mesa Elit</h5>
                                        <p class="card-text">$2.550.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="21">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>                                
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 3 mesas -->
                            <div class="col-md-4 producto mesas">
                                <div class="card mb-4">
                                    <img src="image/Lecto.jpg" class="card-img-top" alt="Producto 3" />
                                    <div class="card-body">
                                        <h5 class="card-title">Mesa Lecto</h5>
                                        <p class="card-text">$2.800.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="22">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
            
                            <!-- Producto 1 lampara -->
                            <div class="col-md-4 producto iluminacion">
                                <div class="card mb-4">
                                    <img src="image/Oslo.jpg" class="card-img-top" alt="Producto 1" />
                                    <div class="card-body">
                                        <h5 class="card-title">Luminaria Oslo</h5>
                                        <p class="card-text">$330.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                             <input type="hidden" name="codigo_producto" value="1">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 2 lampara -->
                            <div class="col-md-4 producto iluminacion">
                                <div class="card mb-4">
                                    <img src="image/Rusty.jpg" class="card-img-top" alt="Producto 2" />
                                    <div class="card-body">
                                        <h5 class="card-title">Luminaria Rusty</h5>
                                        <p class="card-text">$660.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="2">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 3 lampara-->
                            <div class="col-md-4 producto iluminacion">
                                <div class="card mb-4">
                                    <img src="image/Eira5.jpg" class="card-img-top" alt="Producto 3" />
                                    <div class="card-body">
                                        <h5 class="card-title">Luminaria Eira 5</h5>
                                        <p class="card-text">$830.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="3">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
               
                
                            <!-- Producto 1 poltrona -->
                            <div class="col-md-4 producto poltronas">
                                <div class="card mb-4">
                                    <img src="image/Dion.jpg" class="card-img-top" alt="Producto 1" />
                                    <div class="card-body">
                                        <h5 class="card-title">Poltrón Dion</h5>
                                        <p class="card-text">$255.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="30">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                         </form>
                                     </div>
                                </div>
                            </div>
                            <!-- Producto 2 poltrona -->
                            <div class="col-md-4 producto poltronas">
                                 <div class="card mb-4">
                                    <img src="image/Franca.jpg" class="card-img-top" alt="Producto 2" />
                                    <div class="card-body">
                                        <h5 class="card-title">Poltrón Franca</h5>
                                        <p class="card-text">$352.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="31">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>                                
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 3 poltrona -->
                            <div class="col-md-4 producto poltronas">
                                <div class="card mb-4">
                                    <img src="image/Frida.jpg" class="card-img-top" alt="Producto 3" />
                                    <div class="card-body">
                                        <h5 class="card-title">Poltrón Frida</h5>
                                        <p class="card-text">$355.000,00</p>
                                        <form action="php/agregar_carrito.php" method="POST">
                                            <input type="hidden" name="codigo_producto" value="32">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-sample">Agregar al Carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function mostrarProductos(categoria) {
    const productos = document.querySelectorAll('.producto');
    
    productos.forEach((producto, index) => {
        producto.classList.remove('mostrar');
        producto.style.display = 'none';
        
        if (categoria === 'todos' || producto.classList.contains(categoria)) {
            producto.style.display = 'block';
            
            // Aplica un pequeño retardo secuencial a la animación de cada producto
            setTimeout(() => {
                producto.classList.add('mostrar');
            }, index * 100); // El índice añade un retraso progresivo a cada producto
        }
    });
}

</script>

<!-- Modal de Imagen -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Aumenta el tamaño del modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">HomeDesign</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0 text-center"> <!-- Elimina el padding para maximizar el área de la imagen -->
          <img id="modalImage" src="" alt="Imagen en Grande" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
  
 
  <script>
  document.querySelectorAll('.card-img-top').forEach(img => {
    img.addEventListener('click', () => {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = img.src;
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    });
});
</script>




    <!-- Footer -->
    <footer class="bg-warning text-center mt-5">
        <div class="p-3 bg-warning">
            © 2024 HomeDesign. Todos los derechos reservados.
            <a href="contacto.html" class="text ml-3">Contacto</a>
            <a href="sobre-nosotros.html" class="text ml-3">Sobre Nosotros</a>
        </div>
    </footer>

    <!-- Scripts de Bootstrap -->
<!-- Bootstrap 5 JS y Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>