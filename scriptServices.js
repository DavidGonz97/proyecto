function mostrarEspecialistas(servicioId) {
    // Ocultar todos los especialistas primero
    $('.especialistas').hide();
    // Mostrar solo los especialistas del servicio seleccionado
    $('#especialistas_' + servicioId).show();
}

document.addEventListener('DOMContentLoaded', function() {
    console.log("Script is running");
    let today = new Date().toISOString().split('T')[0];
    console.log("Today's date is: " + today);
    let fechaInput = document.getElementById('fecha');
    if (fechaInput) {
        fechaInput.setAttribute('min', today);
        console.log("Min attribute set to: " + fechaInput.getAttribute('min'));
    } else {
        console.log("Element with ID 'fecha' not found");
    }
});


