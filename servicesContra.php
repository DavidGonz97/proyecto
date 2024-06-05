<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headerProfile.css">
    <link rel="stylesheet" href="css/footerProfile.css">
    <link rel="stylesheet" href="css/contrataciones.css">
    <script src="scriptServices.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    
    <title>Servicios Médicos</title>
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
                    require_once 'validacionContratacion.php';

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
                    ?>
                </ul>
            </nav>
        </div>
    </header>

<div class = "container-section">
    <section class = "container">
        <h1>Contratar Servicio</h1>
        <form action="validacionContratacion.php" method="POST">
            <label for="servicio">Seleccione el servicio:</label>
            <select id="servicio" name="servicio" onchange="mostrarEspecialistas(this.value)" required>
                <option value="">Seleccione un servicio</option>
                <?php foreach ($servicios as $servicio): ?>
                    <option value="<?= $servicio['idServicio'] ?>"><?= $servicio['NombreServicio'] ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <div id="especialistas">
                <?php foreach ($servicios as $servicio): ?>
                    <div class="especialistas" id="especialistas_<?= $servicio['idServicio'] ?>" style="display: none;">
                        <label for="especialista_<?= $servicio['idServicio'] ?>">Seleccione el especialista:</label>
                        <select id="especialista_<?= $servicio['idServicio'] ?>" name="especialista_<?= $servicio['idServicio'] ?>" required>
                            <?php foreach ($servicios as $especialista): ?>
                                <?php if ($especialista['idServicio'] == $servicio['idServicio']): ?>
                                    <option value="<?= $especialista['idEspecialista'] ?>"><?= $especialista['nombre_especialista'] ?> - € <?= $especialista['precio'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select><br><br>
                    </div>
                <?php endforeach; ?>
            </div>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            <br><br>

            <input type="submit" value="Contratar Servicio" id="contratar-servicio-button">

            <?php if (isset($_SESSION['mensaje'])): ?>
                   <div class="message-done">
                        <h3><?= $_SESSION['mensaje'] ?></h3>
                    </div>
                    <?php unset($_SESSION['mensaje']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="message-error">
                        <h3><?= $_SESSION['error'] ?></h3>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
        </form>
    </section>
    </div>
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
    </footer>  
    </body>
</html>
