<?php

// Requires necesarios para el test

require_once dirname(__FILE__) . '/config/config.inc.php';
require_once dirname(__FILE__) . '/init.php';
require_once dirname(__FILE__) . '/modules/mimodulobasico/mimodulobasico.php';
require_once dirname(__FILE__) . '/modules/mimodulobasico/classes/MiModuloBasicoMessage.php';

// Codigo del Test

try {
    // INSERTAR: Crear un nuevo mensaje
    $message = new MiModuloBasicoMessage();
    $message->message = 'Este es un mensaje de prueba';
    if ($message->save()) {
        echo "✅ Mensaje añadido correctamente.<br>";
    } else {
        echo "❌ Error al añadir el mensaje.<br>";
    }

    // LEER: Recuperar todos los mensajes
    echo "Mensajes en la base de datos:<br>";
    $messages = MiModuloBasicoMessage::getCollection();
    foreach ($messages as $msg) {
        echo "ID: {$msg->id} - Mensaje: {$msg->mensaje}<br>";
    }

    // ACTUALIZAR: Modificar un mensaje existente
    if (!empty($messages)) {
        $firstMessage = reset($messages); // Obtener el primer mensaje
        $firstMessage->mensaje = 'Mensaje actualizado';
        if ($firstMessage->update()) {
            echo "✅ Mensaje con ID {$firstMessage->id} actualizado correctamente.<br>";
        } else {
            echo "❌ Error al actualizar el mensaje con ID {$firstMessage->id}.<br>";
        }
    }

    // ELIMINAR: Eliminar un mensaje
    if (!empty($messages)) {
        $firstMessage = reset($messages); // Obtener el primer mensaje
        if ($firstMessage->delete()) {
            echo "✅ Mensaje con ID {$firstMessage->id} eliminado correctamente.<br>";
        } else {
            echo "❌ Error al eliminar el mensaje con ID {$firstMessage->id}.<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
