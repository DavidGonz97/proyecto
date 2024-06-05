<?php 
require_once 'validacionOfert.php';
require_once 'config.php';


$conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);

if ($conn->connect_errno) {
    die("Fallo al conectar con la base de datos: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ofertServices.css">
    <link rel="stylesheet" href="css/headerProfile.css">
    <link rel="stylesheet" href="css/footerProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="script.js"></script>
    <title>Ofrecer Servicio</title>
</head>
<body>
<header class="header">
    <div class="menu container">
        <a href="#" class="logo">
            <img src="imagenes/SoloLogo.png" alt="CitWeb">
        </a>            
        <input type="checkbox" id="menu" />
        <label for="menu">
            <img src="imagenes/menu.png" class="menu-icono" alt="menu">
        </label>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="index.php">Nosotros</a></li>
                <li><a href="index.php">Contacto</a></li>
                <li>
                <?php
                if (isset($_SESSION['email'])) {
                    if ($_SESSION['userType'] === 'especialista') {
                        echo '<div class="session-menu">';
                        echo '<button class="open-modal-icon" onclick="OpencloseModalIcon()"><i class="fa-solid fa-circle-user"></i></button>';
                        echo '<div class="modal-icon" id="modal-icon">';
                        echo '<ul>';
                        echo '<li><a href="profile.php">Perfil</a></li>';
                        echo '<li><a href="servicesOfert.php">Ofrecer Servicio</a></li>';
                        echo '<li><a href="#" onclick="logout()">Cerrar sesión</a></li>';
                        echo '</ul>';                           
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="session-menu">';
                        echo '<button class="open-modal-icon" onclick="OpencloseModalIcon()"><i class="fa-solid fa-circle-user"></i></button>';
                        echo '<div class="modal-icon" id="modal-icon">';
                        echo '<ul>';
                        echo '<li><a href="profile.php">Perfil</a></li>';
                        echo '<li><a href="#">Configuración</a></li>';
                        echo '<li><a href="#" onclick="logout()">Cerrar sesión</a></li>';
                        echo '</ul>';                           
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<button class="open-modal" onclick="openModal()"><i class="fas fa-user"></i></button>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>

<div class="container-section">
    <section class="form-add-services container">
        <h1>Ofrecer Servicio</h1>
        <form action="validacionOfert.php" method="POST">
            <label for="nombreServicio">Nombre del Servicio:</label>
            <select id="nombreServicio" name="nombreServicio" required>
                <option value="">Selecciona un servicio</option>
                <option value="Consulta General">Consulta General</option>
                <option value="Vacunación">Vacunación</option>
                <option value="Cirugía Veterinaria">Cirugía Veterinaria</option>
                <option value="Consulta Legal">Consulta Legal</option>
                <option value="Redacción de Contratos">Redacción de Contratos</option>
                <option value="Defensa Jurídica">Defensa Jurídica</option>
                <option value="Revisión de Vehículo">Revisión de Vehículo</option>
                <option value="Cambio de Aceite">Cambio de Aceite</option>
                <option value="Reparación de Frenos">Reparación de Frenos</option>
                <option value="Chequeo Completo">Chequeo Completo</option>
                <option value="Consulta Pediátrica">Consulta Pediátrica</option>
            </select>
            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
            
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="1.00" required>
            <br>
            
            <input type="submit" value="Ofrecer Servicio" id="ofert-service" name="ofert-service">
           
        </form>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="form-delete-services container">
    <h1>Eliminar Servicio</h1>
        <form action="validacionOfert.php" method="POST">
            <label for="servicio">Seleccione el servicio a eliminar:</label>
            <select id="servicio" name="servicio" required>
                <?php
                $queryServicios = "SELECT NombreServicio FROM servicio WHERE IDEspecialista = ?";
                $stmtServicios = $conn->prepare($queryServicios);
                $stmtServicios->bind_param('i', $_SESSION['userID']); // Suponiendo que $_SESSION['userID'] contiene el ID del especialista
                $stmtServicios->execute();
                $resultServicios = $stmtServicios->get_result();

                if ($resultServicios->num_rows > 0) {
                    // Iterar sobre los resultados y mostrar cada servicio como una opción en el menú desplegable
                    while ($row = $resultServicios->fetch_assoc()) {
                        $nombreServicio = $row['NombreServicio'];
                        echo "<option value=\"$nombreServicio\">$nombreServicio</option>";
                    }
                } else {
                    echo "<option value=\"\">No hay servicios ofrecidos</option>";
                }

                $stmtServicios->close();
                ?>
            </select>
            <label for="motivo">Motivo:</label>
            <textarea id="motivo" name="motivo" required></textarea>
            <input type="submit" value="Borrar Servicio" id="delete-service" name="delete-service">               
        </form>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<footer class="footer">
    <div class="footer-content container">
        <div class="link">
            <a href="#" class="logo">CitWeb</a>
        </div>
        <div class="link">
            <ul>
                <li><a href="#">Política de cookies</a></li>
                <li><a href="#">Privacidad web</a></li>
                <li><a href="#">Aviso legal</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>
