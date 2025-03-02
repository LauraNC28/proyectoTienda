<?php

// Importa las clases necesarias de PHPMailer.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga el autoloader de Composer para incluir las dependencias, como PHPMailer.
require 'vendor/autoload.php'; 

/**
 * Función para enviar un correo electrónico con los detalles del pedido.
 *
 * @param string $emailDestino   Correo electrónico del destinatario.
 * @param string $nombreCliente  Nombre del cliente.
 * @param array  $pedido         Datos del pedido (productos, total, etc.).
 * @return bool|string           Retorna true si el correo se envió correctamente, o un mensaje de error si falló.
 */
function enviarCorreoPedido($emailDestino, $nombreCliente, $pedido) {
    // Crea una nueva instancia de PHPMailer.
    $mail = new PHPMailer(true);
    
    try {
        // Configura PHPMailer para usar SMTP.
        $mail->isSMTP(); 

        // Especifica el servidor SMTP (en este caso, Gmail).
        $mail->Host = 'smtp.gmail.com'; 

        // Habilita la autenticación SMTP.
        $mail->SMTPAuth = true; 

        // Credenciales del correo electrónico que enviará el mensaje.
        $mail->Username = 'enviarcorreo71@gmail.com'; // Correo del remitente.
        $mail->Password = 'luwt krxj';               // Contraseña del correo.

        // Habilita el cifrado TLS.
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 

        // Puerto SMTP para Gmail.
        $mail->Port = 587; 

        // Configura el remitente del correo.
        $mail->setFrom('correo@gmail.com', 'Tienda'); 

        // Añade el destinatario del correo.
        $mail->addAddress($emailDestino, $nombreCliente); 

        // Asunto del correo.
        $mail->Subject = 'Confirmación de Pedido - Tienda Accesorios'; 

        // Construye el cuerpo del mensaje en formato HTML.
        $mensaje = "<h2>Hola $nombreCliente,</h2>";
        $mensaje .= "<p>Gracias por tu compra. Aquí están los detalles de tu pedido:</p>";
        $mensaje .= "<ul>";

        // Itera sobre los productos del pedido y los añade al mensaje.
        foreach ($pedido['productos'] as $producto) {
            $mensaje .= "<li>{$producto['nombre']} - Cantidad: {$producto['cantidad']} - Precio: {$producto['precio']}€</li>";
        }

        $mensaje .= "</ul>";
        $mensaje .= "<p>Total: {$pedido['total']}€</p>"; // Muestra el total del pedido.
        $mensaje .= "<p>Esperamos verte pronto.</p>";     // Mensaje de despedida.

        // Indica que el cuerpo del correo es HTML.
        $mail->isHTML(true);

        // Asigna el mensaje al cuerpo del correo.
        $mail->Body = $mensaje;

        // Envía el correo.
        $mail->send();

        // Retorna true si el correo se envió correctamente.
        return true;
    } catch (Exception $e) {
        // Captura cualquier excepción que ocurra durante el envío del correo.
        // Retorna un mensaje de error con detalles.
        return "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}

?>