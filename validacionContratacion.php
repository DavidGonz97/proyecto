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

$sqlServicios = "SELECT s.NombreServicio, e.name AS nombre_especialista, e.ID AS idEspecialista, s.Descripción, s.ID AS idServicio, s.precio
    FROM servicio s
    INNER JOIN especialista e ON s.IDEspecialista = e.ID";

$resultServicios = $conn->query($sqlServicios);
$servicios = $resultServicios->fetch_all(MYSQLI_ASSOC);

// Si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    $servicio_id = $_POST['servicio'];
    $especialista_id = $_POST['especialista_' . $servicio_id];
    $fecha = $_POST['fecha'];

    // Realizar la inserción en la tabla de contratación
    $sqlInsert = "INSERT INTO contratación (IDUsuarioGeneral, IDServicioContratado, IDEspecialista, FechaContratación, EstadoContratación)
                  VALUES (?, ?, ?, ?, 'pagado')";

    $email = $_SESSION['email'];
    $sqlUsuario = "SELECT ID FROM usuariogeneral WHERE email = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->bind_param("s", $email);
    $stmtUsuario->execute();
    $resultUsuario = $stmtUsuario->get_result();
    $usuario = $resultUsuario->fetch_assoc();
    $usuario_id = $usuario['ID'];

    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("iiis", $usuario_id, $servicio_id, $especialista_id, $fecha);

    if ($stmtInsert->execute()) {
        $_SESSION['mensaje'] = "Contratación realizada con éxito.";
        header("Location: pasarelaPago.php");
    } else {
        $_SESSION['error'] = "Error al realizar la contratación: " . $stmtInsert->error;
    }
}

$conn->close();

?>