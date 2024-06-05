<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['message'])) {
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        $para = "dav.gonzalezortiz@gmail.com";
        $asunto = "Mensaje recibido desde el formulario de CitWeb";
        $formulario = "Nombre: $name\n";
        $formulario .= "Teléfono: $phone\n";
        $formulario .= "Email: $email\n";
        $formulario .= "Mensaje:\n$message";

        $headers = "From: $email";

        if (@mail($para, $asunto, $formulario, $headers)) {
            echo "<h4>El mensaje se envió correctamente</h4>";
        } else {
            echo "<h4>Error al enviar el mensaje</h4>";
        }
    } else {
        echo "<h4>No pueden existir campos vacios</h4>";
    }
} else {
    echo "<h4>Método de solicitud no válido</h4>";
}
*/
?>
