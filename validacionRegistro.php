<?php
require_once 'config.php';

// Iniciar sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);

    if ($conn->connect_errno) {
        die("Fallo al conectar con la base de datos: " . $conn->connect_error);
    }

    $user = $_POST['user'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nombreCompleto = $_POST['nombreCompleto'];
    $age = $_POST['age'];
    $table = $_POST['table'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($table == 'user') {
        $sql = "INSERT INTO usuariogeneral (userName, password, email, name, age) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $user, $hashedPassword, $email, $nombreCompleto, $age);
    } else if ($table == 'specialist') {
        $category = $_POST['category'];
        $sql = "INSERT INTO especialista (userName, password, email, name, category) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $user, $hashedPassword, $email, $nombreCompleto, $category);
    } else {
        die("Valor de tabla no válido.");
    }

    if ($stmt->execute()) {
        $_SESSION['mensaje_registro'] = 'Registro exitoso';
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensaje_registro'] = 'Error en el registro: ' . $stmt->error;
        header("Location: index.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['mensaje_registro'] = 'Error: la solicitud no es POST.';
}

// Redireccionar de vuelta a la página principal
header("Location: index.php");
exit;
?>
