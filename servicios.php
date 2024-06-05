<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="script.js"></script>
    <title>Servicios</title>
</head>
<body>
    <header class = "header">

        <div class="menu container">
            <a href="#" class="logo">
                <img src="imagenes/SoloLogo.png" alt="CitWeb">
            </a>            
            <input type="checkbox" id = "menu" />
            <label for="menu">
                <img src="imagenes/menu.png" class = "menu-icono" alt="menu">
            </label>
            <nav class = "navbar">
                <ul>
                    <li><a href="index.php" >Inicio</a></li>
                    <li><a href="#servicios" class = "active">Servicios</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#contacto">Contacto</a></li>
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
                    ?>
                    <div class="modal" id = "userModal">
                        <div class = "modal-content">                            
                            <div class="container-main">

                            <div class="box_trasera">
                    
                                <div class="caja_login">
                                    <h3>Inicia sesion</h3>
                                    <p>Iniciar sesion para entrar en la pagina</p>
                                    <button id = "btn-login">Iniciar sesion</button>
                                </div>
                                <div class="caja_register">
                                    <h3>Registrate</h3>
                                    <p>Registrate para entrar en la pagina</p>
                                    <button type="button" id="btn-register-users" name="btn-register-users" onclick="setTablevalue('user')">Usuario</button>
                                    <button type="button" id="btn-register-specialists" name="btn-register-specialists" onclick="setTablevalue('specialist')">Especialista</button>
                                </div>
                            </div>
                    
                            <div class="container-login-register">
                                <form action="validacionLogin.php" class = "form-login" method="POST">
                                    <h2>Iniciar sesion</h2>
                                    <input type="text" placeholder="Email" name = 'email'>
                                    <input type="password" placeholder="password" name = "password">
                                    <button>Entrar</button>
                                </form>
                    
                                <form action="validacionRegistro.php" class="form-register" method="POST">
                                    <h2>Registro</h2>
                                    <input type="text" placeholder="Usuario" id="user" name="user" required>
                                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                                    <input type="text" id="email" name="email" placeholder="Email" required>  
                                    <input type="text" placeholder="Nombre Completo" id="nombreCompleto" name="nombreCompleto" required>
                                    <input type="number" placeholder="Edad" class="age" id="age" name="age">                                   
                                    <select id="category" class="form-specialists" name="category" required>
                                        <option value="mecanico">Mecánico</option>
                                        <option value="medico">Médico</option>
                                        <option value="abogado">Abogado</option>
                                        <option value="veterinario">Veterinario</option>
                                    </select>
                                    <input type="hidden" name="table" id="table" value=""/>
                                    <button type="submit" id="btn-register">Registrarse</button>
                                </form>
                            </div>
                            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
                        </div>                           
                    </div>
                </li>
            </nav>
        </div>

        <div class = "header-content container">
            <div class="header-txt">
                <h1>Descubre Nuestros Servicios Profesionales en Citweb</h1>
                <p>Ofrecemos una amplia gama de servicios especializados 
                    diseñados para cubrir todas tus necesidades. <br>
                    Nuestros profesionales altamente cualificados 
                    están listos para brindarte soluciones de calidad que superen tus expectativas.</p>
            </div>
            <div class = "header-img">
                <img src="imagenes/servicios.png" alt="">
            </div>
        </div>
    </header>


    <!-- APARTADO DE SERVICIOS -->

    <section class="services container">
        <div class="row-1">
            <div class="list-services">
                <img src="imagenes/medicos2.png" alt="Imagen 1">
                <div class="text-specialist">
                    <h2>Médicos</h2>
                    <p>Contamos con médicos cualificados, ofreciendo atención personalizada 
                        y tratamientos de calidad para su bienestar</p>
                        <?php
                        if (isset($_SESSION['userType'])) {
                            if ($_SESSION['userType'] === 'especialista') {
                                echo '<a class="btn-1" id="doctors" href="servicesOfert.php">Ofrecer Servicio</a>';
                            } elseif ($_SESSION['userType'] === 'usuariogeneral') {
                                echo '<a class="btn-1" id="doctors" href="servicesContra.php">Contratar Servicio</a>';
                            }
                        } else {
                            echo '<a class="btn-1-noLogin" id="doctors" href="javascript:void(0);" onclick="openModal()">Contratar/Ofrecer Servicio</a>';
                        }
                        ?>
                </div>
            </div>
            
            <div class="list-services">
                <img src="imagenes/abogados2.png" alt="">
                <div class="text-specialist">
                    <h2>Abogados</h2>
                    <p>Contamos con abogados cualificados, ofreciendo atención personalizada 
                        y servicios legales de calidad.</p>
                        <?php
                        if (isset($_SESSION['userType'])) {
                            if ($_SESSION['userType'] === 'especialista') {
                                echo '<a class="btn-1" id="lawyer" href="servicesOfert.php">Ofrecer Servicio</a>';
                            } elseif ($_SESSION['userType'] === 'usuariogeneral') {
                                echo '<a class="btn-1" id="doctors" href="servicesContra.php">Contratar Servicio</a>';
                            }
                        } else {
                            echo '<a class="btn-1-noLogin" id="lawyer" href="javascript:void(0);" onclick="openModal()">Contratar/Ofrecer Servicio</a>';
                        }
                        ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="list-services">     
                <div class="text-specialist">
                    <h2>Veterinarios</h2>
                    <p>Contamos con veterinarios cualificados, ofreciendo atención personalizada 
                        y cuidado de mascotas de calidad.</p>
                        <?php
                        if (isset($_SESSION['userType'])) {
                            if ($_SESSION['userType'] === 'especialista') {
                                echo '<a class="btn-1" id="veterinary" href="servicesOfert.php">Ofrecer Servicio</a>';
                            } elseif ($_SESSION['userType'] === 'usuariogeneral') {
                                echo '<a class="btn-1" id="doctors" href="servicesContra.php">Contratar Servicio</a>';
                            }
                        } else {
                            echo '<a class="btn-1-noLogin" id="veterinary" href="javascript:void(0);" onclick="openModal()">Contratar/Ofrecer Servicio</a>';
                        }
                        ?>
                </div>
                <img src="imagenes/veterinarios2.png" alt="Imagen 1">
            </div>
            
            <div class="list-services">          
                <div class="text-specialist">
                    <h2>Mecanicos</h2>
                    <p>Contamos con mecánicos cualificados, ofreciendo atención personalizada 
                        y cuidado de su vehículo.</p>
                        <?php
                        if (isset($_SESSION['userType'])) {
                            if ($_SESSION['userType'] === 'especialista') {
                                echo '<a class="btn-1" id="mechanic" href="servicesOfert.php">Ofrecer Servicio</a>';
                            } elseif ($_SESSION['userType'] === 'usuariogeneral') {
                                echo '<a class="btn-1" id="mechanic" href="servicesContra.php">Contratar Servicio</a>';
                            }
                        } else {
                            echo '<a class="btn-1-noLogin" id="veterinary" href="javascript:void(0);" onclick="openModal()">Contratar/Ofrecer Servicio</a>';
                        }
                        ?>
                </div>
                <img src="imagenes/mecanicos2.png" alt="Imagen 1">
            </div>
        </div>
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
    </footer>

</body>
</html>