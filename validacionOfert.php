<?php
require_once 'config.php';

session_start();

$conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);

if ($conn->connect_errno) {
    die("Fallo al conectar con la base de datos: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$ServicesValidos = [
    'Consulta General', 'Vacunación', 'Cirugía Veterinaria', 'Consulta Legal', 
    'Redacción de Contratos', 'Defensa Jurídica', 'Revisión de Vehículo', 
    'Cambio de Aceite', 'Reparación de Frenos', 'Chequeo Completo', 'Consulta Pediátrica'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["ofert-service"])) {
        $nombreServicio = $_POST['nombreServicio'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $idEspecialista = $_SESSION['userID']; 

        if (!in_array($nombreServicio, $ServicesValidos)) {
            echo "Nombre del servicio no permitido.";
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO servicio (NombreServicio, Descripción, Precio, IDEspecialista) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $nombreServicio, $descripcion, $precio, $idEspecialista);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Servicio ofrecido exitosamente.";
            header("Location: servicesOfert.php");
        } else {
            $_SESSION['message'] = "Error al ofrecer el servicio: " . $stmt->error;
            header("Location: servicesOfert.php");
        }

        $stmt->close();

    } elseif (isset($_POST["delete-service"])) {
        // Código para eliminar un servicio
        $nombreServicioAEliminar = $_POST['servicio'];
        $idEspecialista = $_SESSION['userID']; 

        // Consulta SQL para eliminar el servicio del especialista
        $stmtDelete = $conn->prepare("DELETE FROM servicio WHERE NombreServicio = ? AND IDEspecialista = ?");
        $stmtDelete->bind_param("si", $nombreServicioAEliminar, $idEspecialista);

        if ($stmtDelete->execute()) {
            $_SESSION['message'] = "Servicio eliminado exitosamente.";
            header("Location: servicesOfert.php");
        } else {
            $_SESSION['message'] = "Error al eliminar el servicio: " . $stmtDelete->error;
            header("Location: servicesOfert.php");
        }

        $stmtDelete->close();
    }
}

$conn->close();
?>
