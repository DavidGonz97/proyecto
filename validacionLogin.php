<?php
require_once 'config.php';

$conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);

if ($conn->connect_errno) {
    die("Fallo al conectar con la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    $querySelect = "
        SELECT 'usuariogeneral' as userType, u.id, u.email, u.password 
        FROM usuarioGeneral u 
        WHERE u.email = ?
        UNION
        SELECT 'especialista' as userType, s.id, s.email, s.password 
        FROM especialista s 
        WHERE s.email = ?";

    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param('ss', $email, $email);
    $stmtSelect->execute();
    $stmtSelect->store_result();

    if ($stmtSelect->num_rows > 0) {
        $stmtSelect->bind_result($userType, $userID, $emailDB, $passwordDB);
        $stmtSelect->fetch();

        if (password_verify($password, $passwordDB)) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['userType'] = $userType;
            $_SESSION['userID'] = $userID; 

            if ($userType === 'usuariogeneral' && $email === 'admin@gmail.com') {
                $_SESSION['isAdmin'] = true;
            } else {
                $_SESSION['isAdmin'] = false;
            }
            
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message-login'] = 'Error al iniciar sesión: ' . $stmt->error;
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['message-login'] = 'Error al iniciar sesión: ' . $stmt->error;
            header("Location: index.php");
            exit;
    }

    $stmtSelect->close();
    $conn->close();
}
?>
