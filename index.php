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
    <title>Inicio</title>
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
                    <li><a href="index.php" class = "active">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                    <li>                     
                    <?php
                    session_start();

                    
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
                </ul>
            </nav>
        </div>

        <div class = "header-content container">
            <div class="header-txt">
                <h1>Los mejores <br><span>especialistas </span><span>del mundo </span>están en CitWeb</h1>
                <p>Tu Destino para conectar <br>con los expertos más destacados <br>y aprovechar sus habilidades</p>
                <button class = "btnOpen-information" onclick = "openModalInformation()">Información</button>
                <div class="modal-2" id = "userModal-2">
                    <div class = "modal-information-content">
                        <p>Bienvenido a nuestra plataforma de servicios, un espacio diseñado para conectar a profesionales altamente 
                            cualificados con aquellos que buscan soluciones confiables y expertas en diversas áreas. <br>
                            Ya sea que necesites atención médica de calidad, asesoramiento legal preciso, 
                            servicios de mantenimiento y reparación de coches, o cualquier otro tipo de asistencia profesional, 
                            aquí encontrarás lo que buscas. <br>
                            Nuestra misión es facilitar el acceso a especialistas en medicina, derecho, mecánica, y otros campos esenciales, 
                            asegurando que cada uno de nuestros usuarios reciba el mejor servicio posible. <br>
                            Contamos con un equipo de médicos dedicados y experimentados, preparados para ofrecer consultas, 
                            diagnósticos y tratamientos personalizados que atiendan a tus necesidades de salud.<br>
                            Nuestros abogados, con una amplia trayectoria y conocimiento en diversas ramas del derecho, 
                            están disponibles para brindarte el apoyo legal que necesites, garantizando que tus derechos estén protegidos.<br> 
                            Además, nuestros mecánicos calificados están listos para mantener tu vehículo en óptimas condiciones, 
                            ofreciendo servicios de reparación y mantenimiento que aseguren tu seguridad y comodidad en la carretera. <br>
                            En nuestra plataforma, la calidad y la confianza son pilares fundamentales. <br>
                            Cada profesional ha sido rigurosamente seleccionado y verificado para garantizar que recibas el mejor servicio. <br>
                            Nuestro objetivo es crear un entorno donde tanto los proveedores de servicios como los clientes puedan interactuar 
                            de manera transparente, segura y eficiente. Además, ofrecemos recursos adicionales como reseñas 
                            y calificaciones de usuarios para ayudarte a tomar decisiones informadas.<br>   
                            Gracias por elegirnos como tu solución de confianza para encontrar expertos en diversas disciplinas.<br>
                            Estamos comprometidos a brindarte una experiencia excepcional, facilitando el acceso a servicios esenciales que mejoren 
                            tu calidad de vida y resuelvan tus necesidades específicas. <br> Explora nuestra plataforma y descubre cómo podemos ayudarte hoy.</p>
                    </div>
                    <button class="modalClose-information" onclick="closeModalInformation()"><i class="fas fa-times"></i></button>   
                </div>
            </div>

            <div class = "header-img">
                    <div><img src="imagenes/medicos.png" alt="Imagen 1"></div>
                    <div><img src="imagenes/abogados (1).png" alt="Imagen 2"></div>
                    <div><img src="imagenes/mecanicos.png" alt="Imagen 3"></div>
            </div>
        </div>
    </header>

    <main id="servicios" class = "servicios">
        <h2>Servicios</h2>
        <div class = "servicios-content container">

            <div class = "servicio-1">
                    <i class="fa-solid fa-hospital"></i>
                    <h3>Médicos</h3>
            </div>

            <div class = "servicio-1">
                    <i class="fa-solid fa-car-side"></i>
                    <h3>Mecánicos</h3>
            </div>

            <div class = "servicio-1">
                    <i class="fa-solid fa-landmark"></i>                  
                    <h3>Abogados</h3>
            </div>

            <div class = "servicio-1">
                <i class="fa-solid fa-shield-dog"></i>                
                <h3>Veterinarios</h3>
        </div>
        </div>
            <a href="servicios.php" class="btn-1">Todos nuestros servicios</a>
    </main>

    <section id="nosotros" class = "about container">
        <div class = "about-img">
            <img src="imagenes/ImagenInicio-sinfondo.png" alt="">
        </div>
        <div class = "about-txt">
            <h2>Sobre Nosotros</h2>
            <p>Somos una plataforma en línea que conecta a clientes <br> con una variedad de servicios profesionales,  
                desde médicos y mecánicos <br> hasta peluqueros y veterinarios. <br>
                Nuestro objetivo es proporcionar un espacio digital donde los clientes <br>
                puedan encontrar fácilmente expertos en diferentes áreas y contratar los servicios que necesitan.
            </p>
            <br>
            <p>Al mismo tiempo, ofrecemos a especialistas la oportunidad de registrarse <br> en nuestra plataforma 
                y mostrar sus habilidades y servicios. <br> 
                Esto les permite ampliar su alcance y conectarse con nuevos clientes en línea.
            </p>
        </div>
    </section>

    

    <section id = "contacto" class = "formulario container">

        <form method = "post" autocomplete="off">
            <h2>Contacto</h2>

            <div class = "imput-group">
                
                <div class = "imput-container">
                    <input type="text" name = "name" placeholder="Nombre y Apellidos" required>
                    <i class = "fa-solid fa-user"></i>
                </div>

                <div class = "imput-container">
                    <input type="tel" name = "phone" placeholder="Teléfono" required>
                    <i class = "fa-solid fa-phone"></i>
                </div>

                <div class = "imput-container">
                    <input type="email" name = "email" placeholder="Correo Electrónico" required>
                    <i class = "fa-solid fa-envelope"></i>
                </div>

                <div class = "imput-container">
                    <textarea name="message" placeholder="Detalles de la consulta a realizar"></textarea required> 
                </div>

                <input type="submit" name = "send" class = "btn">
            </div>
        </form>
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