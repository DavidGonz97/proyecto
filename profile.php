<?php
require_once 'config.php';

session_start();

$conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);

if ($conn->connect_errno) {
    die("Fallo al conectar con la base de datos: " . $conn->connect_error);
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Obtener el email y tipo de usuario de la sesión
$email = $_SESSION['email'];
$userType = $_SESSION['userType'];

if (isset($userType) && $userType === 'especialista') {
    $sql = "SELECT * FROM especialista LEFT JOIN servicio ON especialista.id = servicio.IDEspecialista WHERE especialista.email = ?";

} elseif (isset($userType)) {
    $sql = "SELECT 
                ug.ID AS UsuarioID,
                ug.userName AS NombreUsuario,
                ug.name AS Nombre,
                ug.email AS Correo,
                ug.age AS Edad,
                c.ID AS ContratacionID,
                c.FechaContratación AS FechaContratacion,
                s.NombreServicio AS Servicio,
                s.Descripción AS DescripcionServicio,
                s.Precio AS PrecioServicio,
                e.name AS NombreEspecialista
            FROM 
                usuariogeneral ug
            LEFT JOIN 
                contratación c ON ug.ID = c.IDUsuarioGeneral
            LEFT JOIN 
                servicio s ON c.IDServicioContratado = s.ID
            LEFT JOIN 
                especialista e ON s.IDEspecialista = e.ID
            WHERE 
                ug.email = ?";
} else {
    $sql = "SELECT * FROM especialista WHERE email = ?";
}


$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userG = $result->fetch_assoc();
} else {
    echo "No se encontró el usuario o el servicio asociado";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headerProfile.css">
    <link rel="stylesheet" href="css/footerProfile.css">
    <link rel="stylesheet" href="css/profiles.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="script.js"></script>
    <title>Perfil Especialista</title>
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
                    
                    // Verificar si el usuario está autenticado
                    if (isset($_SESSION['email'])) {
                        if ($_SESSION['isAdmin']) {
                            // Si el usuario es administrador, mostrar el menú de administrador
                            echo '<div class="session-menu">';
                            echo '<button class="open-modal-icon" onclick="OpencloseModalIcon()"><i class="fa-solid fa-circle-user"></i></button>';
                            echo '<div class="modal-icon" id="modal-icon">';
                            echo '<ul>';
                            echo '<li><a href="profile.php">Perfil</a></li>';
                            echo '<li><a href="administrador.php">Administrador</a></li>';
                            echo '<li><a href="#" onclick="logout()">Cerrar sesión</a></li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                        } elseif ($_SESSION['userType'] === 'especialista') {
                            // Si el usuario es especialista, mostrar el menú de especialista
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
                            // Si el usuario es general, mostrar el menú de usuario general
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
                        // Si el usuario no ha iniciado sesión, mostrar el botón de inicio de sesión
                        echo '<button class="open-modal" onclick="openModal()"><i class="fas fa-user"></i></button>';
                    }

                    if (isset($_SESSION['mensaje_registro'])) {
                        echo "<script>
                                setTimeout(function() {
                                    window.location.href = 'index.php';
                                }, 2000); // Redirigir después de 5 segundos
                              </script>";
                        echo "<div id='mensaje-container' class='mensaje-container'>" . $_SESSION['mensaje_registro'] . "</div>";
                        unset($_SESSION['mensaje_registro']); // Limpiar el mensaje después de mostrarlo
                    }

                    ?>
            </nav>
        </div>
    </header>

    <section class="profile container">
        <h1>Perfil de Usuario</h1>
        <?php if ($userType === 'especialista') { ?>
            <div class="profile-item">
                <strong>Nombre:</strong>
                <span><?php echo htmlspecialchars($userG['name']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($userG['email']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Servicio:</strong>
                <span><?php echo htmlspecialchars($userG['NombreServicio']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Descripción:</strong>
                <span><?php echo htmlspecialchars($userG['Descripción']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Precio:</strong>
                <span><?php echo htmlspecialchars($userG['Precio']); ?></span>
            </div>
        <?php } else { ?>
            <div class="profile-item">
                <strong>Nombre de usuario:</strong>
                <span><?php echo htmlspecialchars($userG['NombreUsuario']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($userG['Correo']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Nombre:</strong>
                <span><?php echo htmlspecialchars($userG['Nombre']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Fecha:</strong>
                <span><?php echo htmlspecialchars($userG['FechaContratacion']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Servicio:</strong>
                <span><?php echo htmlspecialchars($userG['Servicio']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Descripción del Servicio:</strong>
                <span><?php echo htmlspecialchars($userG['DescripcionServicio']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Precio del Servicio:</strong>
                <span><?php echo htmlspecialchars($userG['PrecioServicio']); ?></span>
            </div>
            <div class="profile-item">
                <strong>Especialista:</strong>
                <span><?php echo htmlspecialchars($userG['NombreEspecialista']); ?></span>
            </div>
        <?php } ?>
    </section>

    <footer class = "footer">

        <div class = "footer-content container">

            <div class = "link">
                <a href="#" class = "logo">CitWeb</a>
            </div>
                <div class = "link">
                <ul>
                    <li><a href="#">Política de cookies</a></li>
                    <li><a href="#">Privacidad web</a></li>
                    <li><a href="#">Aviso legal</a></li>
                </ul>
                </div>
            </div>
        </div>
    </footer>
    </body>
</html>