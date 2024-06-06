$(document).ready(function(){
    $('.header-img').slick({
        autoplay: true, 
        autoplaySpeed: 3000, 
        dots: true, 
        arrows: false, 
        infinite: true, 
        speed: 500, 
        slidesToShow: 1,
        slidesToScroll: 1 
    });
});

// Función para abrir el modal
function openModal() {
    const body = document.querySelector('body');
    const modal = document.querySelector('.modal');
    body.classList.add('modal-open');
    modal.style.display = 'block'; 
}

// Función para cerrar el modal y desactivar el fondo oscurecido
function closeModal() {
    const body = document.querySelector('body');
    const modal = document.querySelector('.modal');
    body.classList.remove('modal-open'); 
    modal.style.display = 'none'; 
}


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("btn-register-users").addEventListener("click", registerUsers);
    document.getElementById("btn-register-specialists").addEventListener("click", registerSpecialist);
    document.getElementById("btn-login").addEventListener("click", login);

    var container_login_register = document.querySelector(".container-login-register");
    var form_login = document.querySelector(".form-login");
    var form_register = document.querySelector(".form-register");
    var box_login = document.querySelector(".caja_login");
    var box_register = document.querySelector(".caja_register");
    var close_modal = document.querySelector(".close-modal");
    var input_specialist = document.querySelector(".form-specialists");
    var input_age = document.querySelector(".age");

    function registerUsers(){
        form_register.style.display = "block";
        container_login_register.style.left = "410px";
        form_login.style.display = "none";
        box_register.style.opacity = "0";
        box_login.style.opacity = "1";
        close_modal.style.right = "93%";
        input_specialist.style.display = "none";  // Ocultar especialistas
        input_age.style.display = "block";  // Mostrar edad
    }

    function registerSpecialist(){
        form_register.style.display = "block";
        container_login_register.style.left = "410px";
        form_login.style.display = "none";
        box_register.style.opacity = "0";
        box_login.style.opacity = "1";
        close_modal.style.right = "93%";
        input_specialist.style.display = "block";  // Mostrar especialistas
        input_age.style.display = "none";  // Ocultar edad
    }

    function login(){
        form_register.style.display = "none";
        container_login_register.style.left = "10px";
        form_login.style.display = "block";
        box_register.style.opacity = "1";
        box_login.style.opacity = "0";
        close_modal.style.right = "0%";
        input_specialist.style.display = "none";  // Asegurar que especialistas esté oculto
        input_age.style.display = "block";  // Asegurar que edad esté visible
    }
});

// Función para abrir el modal-information
function openModalInformation() {
    const body = document.querySelector('body');
    const modal = document.querySelector('.modal-2');
    body.classList.add('modal-open');
    modal.style.display = 'block'; 
}

// Función para cerrar el modal y desactivar el fondo oscurecido
function closeModalInformation() {
    const body = document.querySelector('body');
    const modal = document.querySelector('.modal-2');
    body.classList.remove('modal-open'); 
    modal.style.display = 'none'; 
}

// Función para abrir el modal del menú de login
function OpencloseModalIcon() {
    const modal = document.getElementById('modal-icon');
    if (modal.style.display === 'block') {
        modal.style.display = 'none';
    } else {
        modal.style.display = 'block';
    }
}


// Identificación de botones mediante JS para poder usarlos en php
function setTablevalue(value) {
    document.getElementById("table").value = value;
}

function logout() {
    window.location.href = "logout.php"; // Redirige al usuario a index.php
}

function toggleMenu() {
    var menu = document.querySelector('.dropdown-menu');
    menu.classList.toggle('open-menu');
}

// Función para hacer desaparecer el mensaje de registro confirmado u erroneo
var mensajeContainer = document.getElementById('mensaje-container');


