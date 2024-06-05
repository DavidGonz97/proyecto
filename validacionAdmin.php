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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete-user"])) {
        $id_user = htmlspecialchars($_POST["id_user"]);

        $sqlSelect = "SELECT ID FROM `usuariogeneral` WHERE `ID` = ?";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bind_param('i', $id_user);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        if ($result->num_rows > 0) { 
            $sqlDelete = "DELETE FROM `usuariogeneral` WHERE `ID` = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param('i', $id_user);
            $stmtDelete->execute();

            if ($stmtDelete->affected_rows > 0) {
                echo "Usuario borrado correctamente";
                header("Location: administrador.php");
                exit;
            } else {
                echo "No se pudo borrar el usuario";
            }
        } else {
            echo "No se encontró el usuario a borrar";
        }

        $stmtSelect->close();
        $stmtDelete->close();
    } elseif (isset($_POST["delete-specialist"])) {
        $id_specialist = htmlspecialchars($_POST["id_specialist"]);

        $sqlSelect = "SELECT ID FROM `especialista` WHERE `ID` = ?";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bind_param('i', $id_specialist);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        if ($result->num_rows > 0) { 
            $sqlDelete = "DELETE FROM `especialista` WHERE `ID` = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param('i', $id_specialist);
            $stmtDelete->execute();

            if ($stmtDelete->affected_rows > 0) {
                echo "Especialista borrado correctamente";
                header("Location: administrador.php");
                exit;
            } else {
                echo "No se pudo borrar el especialista";
            }
        } else {
            echo "No se encontró el especialista a borrar";
        }

        $stmtSelect->close();
        $stmtDelete->close();
    }

    $conn->close();
}
?>
