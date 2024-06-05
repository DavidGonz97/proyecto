<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scriptServices.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/headerProfile.css">
    <link rel="stylesheet" href="css/footerProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <title>Panel Administrador</title>
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
                require_once 'validacionAdmin.php';
                if (isset($_SESSION['email'])) {
                    if ($_SESSION['isAdmin']) {
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
                    } else {
                        echo '<button class="open-modal" onclick="openModal()"><i class="fas fa-user"></i></button>';
                    }
                }
                ?>
            </ul>
        </nav>
    </div>
</header>

<section class="panel_admin">
    <div class="admin-info" id="usuarios-registrados" style="display: none;">
    <?php
        require_once 'config.php';

        
        $conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);
        
        if ($conn->connect_errno) {
            die("Fallo al conectar con la base de datos: " . $conn->connect_error);
        }
        
        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        $sqlInfo = "SELECT ID, userName, name, email, age FROM usuariogeneral";

        $result = $conn->query($sqlInfo);

        if ($result->num_rows > 0) {
            // Mostrar los datos de cada usuario general
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["ID"] . "<br>";
                echo "Nombre de usuario: " . $row["userName"] . "<br>";
                echo "Nombre: " . $row["name"] . "<br>";
                echo "Correo electrónico: " . $row["email"] . "<br>";
                echo "Edad: " . $row["age"] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron usuarios generales.";
        }

        $conn->close();
        ?>
    </div>

    <div class="admin-info" id="contrataciones" style="display: none;">
    <?php
        require_once 'config.php';

        $conn = new mysqli(BBDD_HOST, BBDD_USER, BBDD_PASSWORD, BBDD_NAME);
        
        if ($conn->connect_errno) {
            die("Fallo al conectar con la base de datos: " . $conn->connect_error);
        }
        
        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }
        
        $sqlServicios = "SELECT ID, NombreServicio, Descripción, Precio, IDEspecialista FROM servicio";
        
        $result = $conn->query($sqlServicios);
        
        if ($result->num_rows > 0) {
            // Mostrar los detalles de cada servicio
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["ID"] . "<br>";
                echo "Nombre del servicio: " . $row["NombreServicio"] . "<br>";
                echo "Descripción: " . $row["Descripción"] . "<br>";
                echo "Precio: " . $row["Precio"] . "<br>";
                echo "ID del Especialista: " . $row["IDEspecialista"] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron servicios.";
        }
        
        $conn->close();
        ?>
    </div>

    <div class="form-admin container">
        <button onclick="mostrarUsuarios()">Mostrar Usuarios</button>
        <button onclick="mostrarContrataciones()">Mostrar Contrataciones</button>

        <form action="validacionAdmin.php" method="POST" onsubmit="confirmDelete(event)">
            <h2>Borrar Usuario</h2>
            <label for="id_user">ID Usuario:</label>
            <input type="number" id="id_user" name="id_user" step="1.00" required>
            <textarea name="message" placeholder="Motivo" required></textarea>
            <input type="submit" name="delete-user" class="btn-admin" value="Borrar usuario">
        </form>

        <form action="validacionAdmin.php" method="POST" onsubmit="confirmDelete(event)">
            <h2>Borrar Especialista</h2>
            <label for="id_specialist">ID Especialista:</label>
            <input type="number" id="id_specialist" name="id_specialist" step="1.00" required>
            <textarea name="message" placeholder="Motivo" required></textarea>
            <input type="submit" name="delete-specialist" class="btn-admin" value="Borrar especialista">
        </form>
    </div> 
</section>

<script>
    // Función para mostrar usuarios registrados
    function mostrarUsuarios() {
        document.getElementById("usuarios-registrados").style.display = "block";
        document.getElementById("contrataciones").style.display = "none";
    }

    // Función para mostrar contrataciones
    function mostrarContrataciones() {
        document.getElementById("usuarios-registrados").style.display = "none";
        document.getElementById("contrataciones").style.display = "block";
    }
</script>

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
