<?php
// Iniciar sesión
session_start();

// Definir las variables para la conexión
$servername = "sql206.infinityfree.com";  // Servidor de la base de datos
$username = "if0_37794355";    // Tu usuario de MySQL
$password = "Pescado12345"; // Tu contraseña de vPanel
$dbname = "if0_37794355_homedesign_db"; // El nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión MySQL: " . $conn->connect_error);
} 
//echo "Conexión MySQL exitosa<br>";

// Configurar DSN (Data Source Name) para PDO
$charset = 'utf8mb4';
$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";

// Crear la conexión PDO con manejo de excepciones
try {
    $pdo = new PDO($dsn, $username, $password);
    // Configurar el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexión PDO establecida<br>";
} catch (PDOException $e) {
    // Manejo de errores
    //echo "Error al crear PDO: " . $e->getMessage();
}
?>
